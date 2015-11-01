<?php

namespace app\controllers;

use Yii;
use app\models\Emiten;
use app\models\EmitenSearch;
use app\models\DetemitenSearch;
use app\models\Detemiten;
use app\models\Lotshare;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\base\DynamicModel;

/**
 * EmitenController implements the CRUD actions for Emiten model.
 */
class ReportEmitenController extends Controller
{
    public function behaviors()
    {
        return [
          'access' => [
              'class' => AccessControl::className(),
              'rules' => [
                  [
                      'allow' => true,
                      'roles' => ['@'],
                  ],
              ],
          ],
          'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Emiten models.
     * @return mixed
     */
    public function actionIndex($date='')
    {
        $simulation = new DynamicModel([
            'tipe', 'jml_lot', 'harga', 'komisi', 'total_komisi', 'jml_saham',
            'range','total_harga',
        ]);
        $simulation->addRule(['tipe','jml_lot','harga'], 'required');
        $simulation->tipe = 1;
        $selectDate = [];
        if(!empty($date)){
          $selectDate = $this->getDates($date)[0];
          if(!$this->checkDetemitenByDate($date)){
              // TIDAK ADA DETEMITEN
              $maxDate = $this->getMaxDetemitenDate();
              $connection = \Yii::$app->db;
              $transaction = $connection->beginTransaction();
              try {
                $sql = "INSERT INTO detemiten
                  SELECT '".$selectDate."', emiten.KODE, emiten.JMLLOT, emiten.JMLSAHAM,
                  emiten.SALDO, emiten.SALDOR1, emiten.HARGA, '".$maxDate."',
                  emiten.JMLLOTB, emiten.JMLSAHAMB, emiten.SALDOB
                  FROM emiten WHERE emiten.JMLLOT>0";
                $connection->createCommand($sql)->execute();
                //f.	Buat query untuk menampung data detemiten dimana tanggal = [tglMax]
                //select * from detemiten where tanggal = [tglMax]
                $emitens = Detemiten::find()->where(['TGL'=>$maxDate])->all();
                //g.	Lakukan looping sebanyak record yg dihasilkan dari query f.
                foreach($emitens as $emiten){
                    /*
                    Setiap looping lakukan update harga sbb :
                    For i = 1 To RecordCount
                    update detemiten set harga = [harga hasil query f]
                    where kode = [kode hasil query f] and tanggal = [tgl yg dipilih]
                    Next i
                    */
                    $emiten_update = Detemiten::find()->where([
                      'EMITEN_KODE'=>$emiten->EMITEN_KODE,
                      'TGL'=>$selectDate,
                    ])->one();
                    if($emiten_update){
                      $emiten_update->HARGA = $emiten->HARGA;
                      $emiten_update->save();
                    }

                }

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Success.');
              } catch(Exception $e) {
                Yii::$app->session->setFlash('error', 'Fatal error.');
                $transaction->rollback();
              }
          }
        }

        $reportDates = [];
        $detemitenDates = [];
        foreach ($this->getDetemitenDates() as $detemitenDate) {
            $formatDate = date('d-M-Y',strtotime($detemitenDate));
            if(empty($reportDates)){
                if(empty($selectDate)){
                  $reportDates = $this->getDates($formatDate);
                }
                else{
                  $reportDates = $this->getDates($date);
                  //die($selectDate[0]);
                }
            }
            $detemitenDates[$formatDate] = $formatDate;
        }

        //$detemitenDates = ['31-Oct-2015'=>'31-Oct-2015'];
        $searchModel = new DetemitenSearch([
            'TGL' => $reportDates[0],
        ]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;//->pageSize=10;
        $session = Yii::$app->session;
        $session->set('dataProvider',$dataProvider);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'simulation' => $simulation,
            'reportDates' => $reportDates,
            'detemitenDates' => $detemitenDates,
        ]);
    }

    public function getDates($date=''){
        if(!empty($date)){
            $dates[0] = date('Y-m-d',strtotime($date));
            $dates[1] = date('d-M-Y',strtotime($date));
        }
        else{
            $dates[0] = date('Y-m-d');
            $dates[1] = date('d-M-Y');
        }
        return $dates;
    }

    public function getDetemitenDates(){
      $dates = Detemiten::find()
        ->select('TGL')
        ->orderBy('TGL desc')
        ->groupBy('TGL')
        ->column();
      return $dates;
    }

    public function getMaxDetemitenDate(){
      $detemiten = Detemiten::find()
        ->select('TGL')
        ->orderBy('TGL desc')
        ->one();
      if($detemiten) return $detemiten->TGL;
      else return null;
    }

    public function checkDetemitenByDate($date){
      $date = date('Y-m-d',strtotime($date));
      $exists = Detemiten::find()
        ->where(['TGL'=>$date])
        ->exists();
      return $exists;
    }

}

<?php

namespace app\controllers;

use Yii;
use app\models\Emiten;
use app\models\Komisi;
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

        $komisi = Komisi::find()->one();
        $lotshare = Lotshare::find()->one();
        //$detemitenDates = ['31-Oct-2015'=>'31-Oct-2015'];
        //Saldo**) = jmlsaham * harga
        $detemitenSaldo = Detemiten::find()
          ->select('SUM(JMLSAHAM * HARGA) as total_saldo')
          ->where(['TGL' => $reportDates[0]])
          ->asArray()
          ->one();
        $total_saldo = $detemitenSaldo['total_saldo'];

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
            'komisi' => $komisi,
            'lotshare' => $lotshare,
            'total_saldo' => $total_saldo,
        ]);
    }

    /**
     * Updates an existing Emiten model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $dates= $this->getDates();
        if ($post = Yii::$app->request->post()) {
          $dates = $this->getDates($post['reportDate']);
          foreach ($post['harga'] as $kode => $harga){
            //echo $kode.'=>'.$harga.'<br>';
            $detemiten = Detemiten::find()
              ->where([
                  'TGL'=>$dates[0],
                  'EMITEN_KODE'=>$kode,
              ])
              ->one();
            $detemiten->HARGA = (float)$harga;
            $detemiten->save();
          }
          Yii::$app->session->setFlash('success', 'Data berhasil disimpan.');
        }
        return $this->redirect(['index', 'date' => $dates[0]]);
    }

    /**
     * Updates an existing Emiten model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($date)
    {
        $dates= $this->getDates($date);
        Detemiten::deleteAll(['TGL'=>$dates[0]]);
        Yii::$app->session->setFlash('success', 'Data berhasil dihapus.');
        return $this->redirect(['index']);
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

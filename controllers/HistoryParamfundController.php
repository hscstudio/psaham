<?php

namespace app\controllers;

use Yii;
use app\models\Paramfund;
use app\models\HistoryParamfund;
use app\models\Emiten;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * HistoryParamfundController implements the CRUD actions for Paramfund model.
 */
class HistoryParamfundController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Paramfund models.
     * @return mixed
     */
    public function actionIndex()
    {
        $historyModel = new HistoryParamfund();
        $historyModel->TAHUN_MULAI = date('Y');
        $historyModel->TAHUN_AKHIR = $historyModel->TAHUN_MULAI;
        $historyModel->TRIWULAN_MULAI = 'I';
        if(date('m')>=9){
          $historyModel->TRIWULAN_AKHIR = 'IV';
        }
        else if(date('m')>=6){
          $historyModel->TRIWULAN_AKHIR = 'III';
        }
        else if(date('m')>=3){
          $historyModel->TRIWULAN_AKHIR = 'II';
        }
        else{
          $historyModel->TRIWULAN_AKHIR = 'I';
        }

        if ($historyModel->load(Yii::$app->request->post())) {
          $emitenKodes = $historyModel->EMITEN_KODES;
          if(!$emitenKodes) $emitenKodes = [];
          $tahunMulai = $historyModel->TAHUN_MULAI;
          $tahunAkhir = $historyModel->TAHUN_AKHIR;
          $tahuns = [];
          for($i=$tahunMulai;$i<=$tahunAkhir;$i++){
            $tahuns[] =  $i;
          }

          $triwulanMulai = $historyModel->TRIWULAN_MULAI;
          $triwulanAkhir = $historyModel->TRIWULAN_AKHIR;
          $triwulans = [];
          if($triwulanMulai=='I' and $triwulanAkhir=='IV'){
              $triwulans = ['I','II','III','IV'];
          }
          else if($triwulanMulai=='I' and $triwulanAkhir=='III'){
              $triwulans = ['I','II','III'];
          }
          else if($triwulanMulai=='I' and $triwulanAkhir=='II'){
              $triwulans = ['I','II'];
          }
          else if($triwulanMulai=='II' and $triwulanAkhir=='IV'){
              $triwulans = ['II','III','IV'];
          }
          else if($triwulanMulai=='II' and $triwulanAkhir=='III'){
              $triwulans = ['II','III'];
          }
          else if($triwulanMulai=='III' and $triwulanAkhir=='IV'){
              $triwulans = ['III','IV'];
          }
          else if($triwulanMulai==$triwulanAkhir){
              $triwulans = [$triwulanMulai];
          }

          $dataProviders = [];
          foreach ($emitenKodes as $kode) {
              $emitenModel = $this->getEmiten($kode);
              if($emitenModel){
                  $query = Paramfund::find()
                    ->where([
                      'TAHUN' => $tahuns,
                      'TRIWULAN' => $triwulans,
                    ]);

                  $dataProvider = new ActiveDataProvider([
                      'query' => $query,
                  ]);
                  $dataProvider->getSort()->defaultOrder = [
                      'TAHUN'=>SORT_ASC,'TRIWULAN'=>SORT_ASC
                  ];

                  $dataProviders[$kode] = $dataProvider;
              }
          }
          if(!empty($dataProviders)){
              return $this->render('index', [
                  'historyModel' => $historyModel,
                  'dataProviders' => $dataProviders,
              ]);
          }
          else{
              return $this->render('index', [
                  'historyModel' => $historyModel,
              ]);
          }
        }
        else{
          return $this->render('index', [
              'historyModel' => $historyModel,
          ]);
        }
    }

    public function getEmiten($id)
    {
        if (($model = Emiten::find()->where(['KODE'=>$id])->asArray()->one()) !== null) {
            return $model;
        } else {
            return null;
        }

    }

    
}

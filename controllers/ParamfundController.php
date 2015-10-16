<?php

namespace app\controllers;

use Yii;
use app\models\Paramfund;
use app\models\ParamfundSearch;
use app\models\Emiten;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ParamfundController implements the CRUD actions for Paramfund model.
 */
class ParamfundController extends Controller
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
        $searchModel = new ParamfundSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Paramfund model.
     * @param string $EMITEN_KODE
     * @param string $TAHUN
     * @param string $TRIWULAN
     * @return mixed
     */
    public function actionView($EMITEN_KODE, $TAHUN, $TRIWULAN)
    {
        return $this->render('view', [
            'model' => $this->findModel($EMITEN_KODE, $TAHUN, $TRIWULAN),
        ]);
    }

    /**
     * Creates a new Paramfund model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Paramfund();
        $model->TAHUN = date('Y');
        if(date('m')>=9){
          $model->TRIWULAN = 'IV';
        }
        else if(date('m')>=6){
          $model->TRIWULAN = 'III';
        }
        else if(date('m')>=3){
          $model->TRIWULAN = 'II';
        }
        else{
          $model->TRIWULAN = 'I';
        }

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Data berhasil disimpan.');
                /*
                1. P_BV = Persentase BV  didapat dari:
                (BV – BV dr Emiten yg sama pd Tahun & Triwulan sebelumnya) / BV dr Emiten yg sama pd Tahun & Triwulan sebelumnya  * 100%
                2. P_EPS = Persentase EPS  didapat dari: EPS rumus sama seperti P_BV
                - P_TE = Persentase Total Equity  didapat dari: Total Equity rumus sama seperti  P_BV
                - P_SALES = Persentase Sales  didapat dari: Sales rumus sama seperti  P_BV
                - P_NI = Persentase Net Income  didapat dari: Net Income rumus sama seperti  P_BV
                */
                $oldModel = $this->findModel($model->EMITEN_KODE, $model->TAHUN-1, $model->TRIWULAN,true);
                if($oldModel){
                    $model->P_BV = @number_format( (($model->BV - $oldModel->BV) / $oldModel->BV ) , 2);
                    $model->P_EPS = @number_format( (($model->P_EPS - $oldModel->P_EPS) / $oldModel->P_EPS ), 2);
                    $model->P_TE = @number_format(  (($model->P_TE - $oldModel->P_TE) / $oldModel->P_TE ), 2);
                    $model->P_SALES = @number_format(  (($model->P_SALES - $oldModel->P_SALES) / $oldModel->P_SALES ), 2);
                    $model->P_NI = @number_format(  (($model->P_NI - $oldModel->P_NI) / $oldModel->P_NI ), 2);
                    $model->save();
                }
            }
            else{
              Yii::$app->session->setFlash('error', 'Data gagal disimpan.');
            }
            return $this->redirect(['index']);
            //return $this->redirect(['view', 'EMITEN_KODE' => $model->EMITEN_KODE, 'TAHUN' => $model->TAHUN, 'TRIWULAN' => $model->TRIWULAN]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Paramfund model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $EMITEN_KODE
     * @param string $TAHUN
     * @param string $TRIWULAN
     * @return mixed
     */
    public function actionUpdate($EMITEN_KODE, $TAHUN, $TRIWULAN)
    {
        $model = $this->findModel($EMITEN_KODE, $TAHUN, $TRIWULAN);

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Data berhasil disimpan.');
                $oldModel = @$this->findModel($model->EMITEN_KODE, $model->TAHUN-1, $model->TRIWULAN,true);
                if($oldModel){
                    $model->P_BV = @number_format( (($model->BV - $oldModel->BV) / $oldModel->BV ) , 2);
                    $model->P_EPS = @number_format( (($model->P_EPS - $oldModel->P_EPS) / $oldModel->P_EPS ), 2);
                    $model->P_TE = @number_format(  (($model->P_TE - $oldModel->P_TE) / $oldModel->P_TE ), 2);
                    $model->P_SALES = @number_format(  (($model->P_SALES - $oldModel->P_SALES) / $oldModel->P_SALES ), 2);
                    $model->P_NI = @number_format(  (($model->P_NI - $oldModel->P_NI) / $oldModel->P_NI ), 2);
                    $model->save();
                    //print_r($model->errors);
                    //die();
                }
            }
            else{
              Yii::$app->session->setFlash('error', 'Data gagal disimpan.');
            }
            return $this->redirect(['index']);
            //return $this->redirect(['view', 'EMITEN_KODE' => $model->EMITEN_KODE, 'TAHUN' => $model->TAHUN, 'TRIWULAN' => $model->TRIWULAN]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Paramfund model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $EMITEN_KODE
     * @param string $TAHUN
     * @param string $TRIWULAN
     * @return mixed
     */
    public function actionDelete($EMITEN_KODE, $TAHUN, $TRIWULAN)
    {
        $model = $this->findModel($EMITEN_KODE, $TAHUN, $TRIWULAN);
        if($model->delete()){
          Yii::$app->session->setFlash('success', 'Data berhasil disimpan.');
        }
        else{
          Yii::$app->session->setFlash('error', 'Data gagal disimpan.');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Paramfund model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $EMITEN_KODE
     * @param string $TAHUN
     * @param string $TRIWULAN
     * @return Paramfund the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($EMITEN_KODE, $TAHUN, $TRIWULAN, $safe=false)
    {
        if (($model = Paramfund::findOne(['EMITEN_KODE' => $EMITEN_KODE, 'TAHUN' => $TAHUN, 'TRIWULAN' => $TRIWULAN])) !== null) {
            return $model;
        } else {
            if($safe) return;
            else
              throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetEmiten($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (($model = Emiten::find()->where(['KODE'=>$id])->asArray()->one()) !== null) {
            return ['data' => $model];
        } else {
            return ['data' => ''];
        }

    }
}

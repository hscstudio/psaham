<?php

namespace app\controllers;

use Yii;
use app\models\Asset;
use app\models\Assetat;
use app\models\AssetSearch;
use app\models\IndikatorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AssetController implements the CRUD actions for Asset model.
 */
class AssetController extends Controller
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
     * Lists all Asset models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AssetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Asset model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Asset model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($date='')
    {
        $dates = $this->getDates($date);
        $model = Asset::find()->where(['TGL'=>$dates[0]]) ->one();
        if($model){
          return $this->redirect(['update', 'id' => $model->TGL]);
        }

        $model = new Asset([
          'TGL' => $dates[0],
          ]);

        $modelat = Assetat::find()->where(['TGL'=>$dates[2]]) ->one();
        if(!$modelat){
          $modelat = new Assetat([
            'TGL' => $dates[2],
          ]);
        }

        if ($model->load(Yii::$app->request->post()) and $modelat->load(Yii::$app->request->post()) ) {
          $connection = \Yii::$app->db;
          $transaction = $connection->beginTransaction();
          try {
            $dates = $this->getDates($model->TGL);
            $model->TGL  = $dates[0];
            $modelat->TGL  = $dates[2];
            if($model->save() and $modelat->save()){
              Yii::$app->session->setFlash('success', 'Data berhasil disimpan.');
              $transaction->commit();
            }
            else{
              Yii::$app->session->setFlash('error', 'Data gagal disimpan.');
              $transaction->rollBack();
            }
          } catch(Exception $e) {
            Yii::$app->session->setFlash('error', 'Fatal error.');
            $transaction->rollback();
          }
          return $this->redirect(['index', 'date' => $model->TGL]);
        } else {
            foreach ($model->attributes as $key => $value) {
                if($key=='TGL'){
                  $model->TGL = $dates[1];
                }
                else{
                  $model->{$key} = 0.00;
                }
            }

            foreach ($modelat->attributes as $key => $value) {
                if($key=='TGL'){
                  $modelat->TGL = $dates[3];
                }
                else{
                  $modelat->{$key} = 0.00;
                }
            }

            return $this->render('create', [
                'model' => $model,
                'modelat' => $modelat,
            ]);
        }
    }

    /**
     * Updates an existing Asset model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id='')
    {
        $dates = $this->getDates($id);

        $model = Asset::find()->where(['TGL'=>$dates[0]]) ->one();
        if(!$model){
          $model = new Asset([
            'TGL' => $dates[0],
          ]);

          if(!Yii::$app->request->post()){
            foreach ($model->attributes as $key => $value) {
                if($key=='TGL'){
                  $model->TGL = $dates[1];
                }
                else{
                  $model->{$key} = 0.00;
                }
            }
          }
          $model->save();
        }

        $modelat = Assetat::find()->where(['TGL'=>$dates[2]]) ->one();
        if(!$modelat){
          $modelat = new Assetat([
            'TGL' => $dates[2],
          ]);
          if(!Yii::$app->request->post()){
            foreach ($modelat->attributes as $key => $value) {
                if($key=='TGL'){
                  $modelat->TGL = $dates[3];
                }
                else{
                  $modelat->{$key} = 0.00;
                }
            }
          }
          $modelat->save();
        }

        $searchModel = new IndikatorSearch([
            'TGL' => $dates[0],
          ]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post()) and $modelat->load(Yii::$app->request->post()) ) {
          $connection = \Yii::$app->db;
          $transaction = $connection->beginTransaction();
          try {
            $dates = $this->getDates($model->TGL);
            $model->TGL  = $dates[0];
            $modelat->TGL  = $dates[2];
            if($model->save() and $modelat->save()){
              Yii::$app->session->setFlash('success', 'Data berhasil disimpan.');
              $transaction->commit();
            }
            else{
              Yii::$app->session->setFlash('error', 'Data gagal disimpan.');
              $transaction->rollBack();
            }
          } catch(Exception $e) {
            Yii::$app->session->setFlash('error', 'Fatal error.');
            $transaction->rollback();
          }
          return $this->redirect(['index', 'date' => $model->TGL]);
        } else {
            $model->TGL = $dates[1];
            $modelat->TGL = $dates[3];
            return $this->render('update', [
                'model' => $model,
                'modelat' => $modelat,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Deletes an existing Asset model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Asset model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Asset the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Asset::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function getDates($date){
        if(!empty($date)){
            $dates[0] = date('Y-m-d',strtotime($date));
            $dates[1] = date('d-M-Y',strtotime($date));
            $dates[2] = date('Y',strtotime($date)).'-01-01';
            $dates[3] = '01-Jan-'.date('Y',strtotime($date));
        }
        else{
            $dates[0] = date('Y-m-d');
            $dates[1] = date('d-M-Y');
            $dates[2] = date('Y').'-01-01';
            $dates[3] = '01-Jan-'.date('Y');
        }
        return $dates;
    }
}

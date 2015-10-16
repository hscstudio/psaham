<?php

namespace app\controllers;

use Yii;
use app\models\Securitas;
use app\models\SecuritasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Exception;

/**
 * SecuritasController implements the CRUD actions for Securitas model.
 */
class SecuritasController extends Controller
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
     * Lists all Securitas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SecuritasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=10;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Securitas model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (Yii::$app->request->isAjax) {
          return $this->renderAjax('view', [
              'model' => $this->findModel($id),
          ]);
        }
        else{
          return $this->render('view', [
              'model' => $this->findModel($id),
          ]);
        }
    }

    /**
     * Creates a new Securitas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Securitas();
        $ajax = Yii::$app->request->isAjax;
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
              Yii::$app->session->setFlash('success', 'Data berhasil disimpan.');
              return $this->redirect(['index']);
            }
            else{
              Yii::$app->session->setFlash('error', 'Data gagal disimpan.');
              if ($ajax) {
                return $this->renderAjax('create', [
                    'model' => $model,
                ]);
              }
              else{
                return $this->render('create', [
                    'model' => $model,
                ]);
              }
            }
        } else {
            if ($ajax) {
              return $this->renderAjax('create', [
                  'model' => $model,
              ]);
            }
            else{
              return $this->render('create', [
                  'model' => $model,
              ]);
            }
        }
    }

    /**
     * Updates an existing Securitas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $ajax = Yii::$app->request->isAjax;
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
              Yii::$app->session->setFlash('success', 'Data berhasil disimpan.');
            }
            else{
              Yii::$app->session->setFlash('error', 'Data gagal disimpan.');
            }
            if ($ajax) {
              return $this->renderAjax('update', [
                'model' => $model,
              ]);
            }
            else{
              return $this->refresh();
            }
        } else {
            if ($ajax) {
              return $this->renderAjax('update', [
                  'model' => $model,
              ]);
            }
            else{
              return $this->render('update', [
                  'model' => $model,
              ]);
            }
        }
    }

    /**
     * Deletes an existing Securitas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        try {
          $model->delete();
          Yii::$app->session->setFlash('success', 'Data berhasil dihapus.');
        } catch(Exception $e) {
          Yii::$app->session->setFlash('error', 'Data tidak dapat dihapus karena telah digunakan pada transaksi pembelian.');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Securitas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Securitas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Securitas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

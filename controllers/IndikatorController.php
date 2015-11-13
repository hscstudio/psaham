<?php

namespace app\controllers;

use Yii;
use app\models\Indikator;
use app\models\IndikatorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * IndikatorController implements the CRUD actions for Indikator model.
 */
class IndikatorController extends Controller
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
     * Lists all Indikator models.
     * @return mixed
     */
    public function actionIndex($tgl)
    {
        $searchModel = new IndikatorSearch([
          'TGL' => $tgl
          ]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->getSort()->defaultOrder = ['updated_at'=>SORT_DESC,'created_at'=>SORT_DESC];

        if (Yii::$app->request->isAjax) {
          return $this->renderAjax('index', [
              'searchModel' => $searchModel,
              'dataProvider' => $dataProvider,
          ]);
        }
        else{
          return $this->render('index', [
              'searchModel' => $searchModel,
              'dataProvider' => $dataProvider,
          ]);
        }
    }

    /**
     * Displays a single Indikator model.
     * @param string $TGL
     * @param string $NAMA
     * @return mixed
     */
    public function actionView($TGL, $NAMA)
    {

        if (Yii::$app->request->isAjax) {
          return $this->renderAjax('view', [
              'model' => $this->findModel($TGL, $NAMA),
          ]);
        }
        else{
          return $this->render('view', [
              'model' => $this->findModel($TGL, $NAMA),
          ]);
        }
    }

    /**
     * Creates a new Indikator model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($tgl)
    {
        $model = new Indikator([
          'TGL' => $tgl
          ]);
        $ajax = Yii::$app->request->isAjax;
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
              Yii::$app->session->setFlash('success', 'Data berhasil disimpan.');
              $model = new Indikator([
                'TGL' => $tgl
              ]);
            }
            else{
              Yii::$app->session->setFlash('error', 'Data gagal disimpan.');
            }
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
            //return $this->redirect(['view', 'id' => $model->KODE]);
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
     * Updates an existing Indikator model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $TGL
     * @param string $NAMA
     * @return mixed
     */
    public function actionUpdate($TGL, $NAMA)
    {
        $model = $this->findModel($TGL, $NAMA);

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
              return $this->render('update', [
                  'model' => $model,
              ]);
            }
            //return $this->redirect(['view', 'id' => $model->KODE]);
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
     * Deletes an existing Indikator model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $TGL
     * @param string $NAMA
     * @return mixed
     */
    public function actionDelete($TGL, $NAMA)
    {
        $model = $this->findModel($TGL, $NAMA);
        try {
          $model->delete();
          Yii::$app->session->setFlash('success', 'Data berhasil dihapus.');
        } catch(Exception $e) {
          Yii::$app->session->setFlash('error', 'Data tidak dapat dihapus karena telah digunakan pada transaksi lain.');
        }
        exit;
        //return $this->redirect(['index','tgl'=>$TGL]);
    }

    /**
     * Finds the Indikator model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $TGL
     * @param string $NAMA
     * @return Indikator the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($TGL, $NAMA)
    {
        if (($model = Indikator::findOne(['TGL' => $TGL, 'NAMA' => $NAMA])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

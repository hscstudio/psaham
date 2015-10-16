<?php

namespace app\controllers;

use Yii;
use app\models\Emiten;
use app\models\EmitenSearch;
use app\models\Lotshare;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Exception;

/**
 * EmitenController implements the CRUD actions for Emiten model.
 */
class EmitenController extends Controller
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
     * Lists all Emiten models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmitenSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=10;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Emiten model.
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
     * Creates a new Emiten model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Emiten();

        if ($model->load(Yii::$app->request->post())) {
            $model->SALDOR1 = (float) @($model->SALDO / $model->JMLSAHAM);
            $model->JMLLOTB = $model->JMLLOT;
            $model->SALDOB = $model->SALDO;
            if($model->save()){
              Yii::$app->session->setFlash('success', 'Data berhasil disimpan.');
              return $this->redirect(['index']);
            }
            else{
              Yii::$app->session->setFlash('error', 'Data gagal disimpan.');
              return $this->render('create', [
                  'model' => $model,
                  'lotshare' => $this->getLotshare(),
              ]);
            }
            //return $this->redirect(['view', 'id' => $model->KODE]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'lotshare' => $this->getLotshare(),
            ]);
        }
    }

    /**
     * Updates an existing Emiten model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            //return $this->redirect(['view', 'id' => $model->KODE]);
            if($model->save()){
              Yii::$app->session->setFlash('success', 'Data berhasil disimpan.');
              return $this->redirect(['index']);
            }
            else{
              Yii::$app->session->setFlash('error', 'Data gagal disimpan.');
              return $this->render('update', [
                  'model' => $model,
                  'lotshare' => $this->getLotshare(),
              ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'lotshare' => $this->getLotshare(),
            ]);
        }
    }

    /**
     * Deletes an existing Emiten model.
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
        Yii::$app->session->setFlash('error', 'Data tidak dapat dihapus karena telah digunakan pada transaksi lain.');
      }
      return $this->redirect(['index']);
    }

    /**
     * Finds the Emiten model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Emiten the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Emiten::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function getLotshare()
    {
        $lotshare = Lotshare::find()->select('JML_LBRSAHAM')->one();
        $jml_saham = '100';
        if($lotshare!==null){
            $jml_saham = (int)$lotshare->JML_LBRSAHAM;
        }
        return $jml_saham;
    }
}

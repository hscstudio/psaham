<?php

namespace app\controllers;

use Yii;
use app\models\Komisi;
use app\models\Lotshare;
use app\models\KomisiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Exception;

/**
 * KomisiController implements the CRUD actions for Komisi model.
 */
class KomisiController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'update' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Komisi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = $this->findModel();
        $model2 = $this->findModel2();
        if ($model->load(Yii::$app->request->post()) && $model2->load(Yii::$app->request->post())) {
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
              if($model->save() && $model2->save()){
                  Yii::$app->session->setFlash('success', 'Data have updated.');
                   $transaction->commit();
              }
              else{
                  Yii::$app->session->setFlash('warning', 'Update failed.');
                  $transaction->rollBack();
              }
            } catch(Exception $e) {
              Yii::$app->session->setFlash('error', 'Fatal error.');
              $transaction->rollback();
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'model2' => $model2,
            ]);
        }
    }

    /**
     * Finds the Komisi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Komisi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel()
    {
        $model = Komisi::find()->one();
        if ($model !== null) {

        } else {
            $model = new Komisi();
            $model->KOM_BELI = 0.25;
            $model->KOM_JUAL = 0.35;
            $model->save();
        }
        return $model;
    }

    protected function findModel2()
    {
        $model = Lotshare::find()->one();
        if ($model !== null) {

        } else {
            $model = new Lotshare();
            $model->JML_LBRSAHAM = 100;
            $model->save();
        }
        return $model;
    }
}

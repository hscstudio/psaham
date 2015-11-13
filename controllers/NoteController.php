<?php

namespace app\controllers;

use Yii;
use app\models\Note;
use app\models\NoteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * NoteController implements the CRUD actions for Note model.
 */
class NoteController extends Controller
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
     * Lists all Note models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NoteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->getSort()->defaultOrder = ['updated_at'=>SORT_DESC,'created_at'=>SORT_DESC];
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Note model.
     * @param integer $id
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
     * Creates a new Note model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Note();

        $ajax = Yii::$app->request->isAjax;
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
              Yii::$app->session->setFlash('success', 'Data berhasil disimpan.');
              $model = new Note();
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
     * Updates an existing Note model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
     * Deletes an existing Note model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Data berhasil dihapus.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Note model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Note the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Note::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDownload($id)
    {
        $model = $this->findModel($id);
        header("Content-type: text/plain");
        header("Content-Disposition: attachment; filename=".\yii\helpers\Inflector::underscore($model->title).".txt");
        print $model->content;
    }
}

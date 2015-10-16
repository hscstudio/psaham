<?php

namespace app\controllers;

use Yii;
use app\models\Pembelian;
use app\models\PembelianSearch;
use app\models\Emiten;
use app\models\Securitas;
use app\models\Komisi;
use app\models\Lotshare;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PembelianController implements the CRUD actions for Pembelian model.
 */
class PembelianController extends Controller
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
     * Lists all Pembelian models.
     * @return mixed
     */
    public function actionIndex($date='')
    {
        $dates = $this->getDates($date);
        $searchModel = new PembelianSearch([
            'TGL' => $dates[0]
        ]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=10;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'latestDate' => $this->getLatestDate(),
            'lotshare' => $this->getLotshare(),
            'dates' => $dates,
        ]);
    }

    /**
     * Displays a single Pembelian model.
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
     * Creates a new Pembelian model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($date='')
    {
        $dates = $this->getDates($date);
        $model = new Pembelian([
              'TGL' => $dates[0],
        ]);

        if ($model->load(Yii::$app->request->post())) {
          $connection = \Yii::$app->db;
          $transaction = $connection->beginTransaction();
          try {
            $model->NOMOR = $this->getNumber();
            $dates = $this->getDates($model->TGL);
            $model->TGL  = $dates[0];
            if($model->save()){
                // Ada trigger saat terjadi pembelian yg mengubah nilai
                // Saldor1 = (Saldo + Total Beli) / (Jml Saham + Jml Saham Beli)
                // Total Beli, Jml Saham Beli dari table Pembelian sesuai kode Emiten.
                $modelEmiten = Emiten::find()->where(['KODE'=>$model->EMITEN_KODE])->one();
                if($modelEmiten){
                  $modelEmiten->SALDOR1 = @ ($modelEmiten->SALDO + $model->TOTAL_BELI) / ($modelEmiten->JMLSAHAM + $model->JMLSAHAM);
                  //-Ada trigger saat terjadi pembelian untuk mengubah nilai jmllot dan saldo pada table emiten:
                  // JMLLOTB = JMLLOTB + JMLLOT BELI
                  // SALDOB = SALDOB + TOTAL BELI
                  $modelEmiten->JMLLOTB = $modelEmiten->JMLLOTB + $model->JMLLOT;
                  $modelEmiten->SALDOB = $modelEmiten->SALDOB + $model->TOTAL_BELI;
                  if($modelEmiten->save()){
                    Yii::$app->session->setFlash('success', 'Data berhasil disimpan.');
                    $transaction->commit();
                  }
                  else{
                    Yii::$app->session->setFlash('error', 'Data gagal disimpan.');
                    $transaction->rollBack();
                  }
                }
                else{
                  Yii::$app->session->setFlash('error', 'Data gagal disimpan.');
                  $transaction->rollBack();
                }

                //return $this->redirect(['view', 'id' => $model->NOMOR]);
            }
            else{
                Yii::$app->session->setFlash('error', 'Data gagal disimpan.');
                $transaction->rollBack();
            }
          } catch(Exception $e) {
            Yii::$app->session->setFlash('error', 'Fatal error.');
            $transaction->rollback();
          }
          return $this->redirect(['index', 'date'=>$dates[0] ]);
        } else {
            $model->NOMOR = $this->getNumber();
            $model->TGL = $dates[1];
            //$model->JMLLOT = 1;
            //$model->HARGA = 1000;
            $model->KOM_BELI = $this->getKomisi();
            return $this->render('create', [
                'model' => $model,
                'lotshare' => $this->getLotshare(),
            ]);
        }
    }

    /**
     * Updates an existing Pembelian model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldModel = $model;
        $dates = $this->getDates($model->TGL);
        if ($model->load(Yii::$app->request->post())) {
          $connection = \Yii::$app->db;
          $transaction = $connection->beginTransaction();
          try {
            $dates = $this->getDates($model->TGL);
            $model->TGL  = $dates[0];
            if($model->save()){
                // Ada trigger saat terjadi pembelian yg mengubah nilai
                // Saldor1 = (Saldo + Total Beli) / (Jml Saham + Jml Saham Beli)
                // Total Beli, Jml Saham Beli dari table Pembelian sesuai kode Emiten.
                $modelEmiten = Emiten::find()->where(['KODE'=>$model->EMITEN_KODE])->one();
                if($modelEmiten){
                  $modelEmiten->SALDOR1 = @ ($modelEmiten->SALDO + $model->TOTAL_BELI - $oldModel->TOTAL_BELI ) / ($modelEmiten->JMLSAHAM + $model->JMLSAHAM - $oldModel->JMLSAHAM);
                  //-Ada trigger saat terjadi pembelian untuk mengubah nilai jmllot dan saldo pada table emiten:
                  // JMLLOTB = JMLLOTB + JMLLOT BELI
                  // SALDOB = SALDOB + TOTAL BELI
                  $modelEmiten->JMLLOTB = $modelEmiten->JMLLOTB + $model->JMLLOT - $oldModel->JMLLOT;
                  $modelEmiten->SALDOB = $modelEmiten->SALDOB + $model->TOTAL_BELI - $oldModel->TOTAL_BELI;
                  if($modelEmiten->save()){
                    Yii::$app->session->setFlash('success', 'Data berhasil disimpan.');
                    $transaction->commit();
                  }
                  else{
                    Yii::$app->session->setFlash('error', 'Data gagal disimpan.');
                    $transaction->rollBack();
                  }
                }
                else {
                  Yii::$app->session->setFlash('error', 'Data gagal disimpan.');
                  $transaction->rollBack();
                }
                //return $this->redirect(['view', 'id' => $model->NOMOR]);
            }
            else{
                Yii::$app->session->setFlash('error', 'Data gagal disimpan.');
                $transaction->rollBack();
            }
          } catch(Exception $e) {
            Yii::$app->session->setFlash('error', 'Fatal error.');
            $transaction->rollback();
          }
          return $this->redirect(['index', 'date'=>$dates[0] ]);
        } else {
            $model->TGL  = $dates[1];
            return $this->render('update', [
                'model' => $model,
                'lotshare' => $this->getLotshare(),
            ]);
        }
    }

    /**
     * Deletes an existing Pembelian model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $oldModel = $model;
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
          $dates = $this->getDates($model->TGL);
          if($model->delete()){
            // Ada trigger saat terjadi pembelian yg mengubah nilai
            // Saldor1 = (Saldo + Total Beli) / (Jml Saham + Jml Saham Beli)
            // Total Beli, Jml Saham Beli dari table Pembelian sesuai kode Emiten.
            $modelEmiten = Emiten::find()->where(['KODE'=>$oldModel->EMITEN_KODE])->one();
            if($modelEmiten){
              $modelEmiten->SALDOR1 = @ ($modelEmiten->SALDO - $oldModel->TOTAL_BELI ) / ($modelEmiten->JMLSAHAM - $oldModel->JMLSAHAM);
              //-Ada trigger saat terjadi pembelian untuk mengubah nilai jmllot dan saldo pada table emiten:
              // JMLLOTB = JMLLOTB + JMLLOT BELI
              // SALDOB = SALDOB + TOTAL BELI
              $modelEmiten->JMLLOTB = $modelEmiten->JMLLOTB - $oldModel->JMLLOT;
              $modelEmiten->SALDOB = $modelEmiten->SALDOB - $oldModel->TOTAL_BELI;
              if($modelEmiten->save()){
                Yii::$app->session->setFlash('success', 'Data berhasil dihapus.');
                $transaction->commit();
              }
              else{
                Yii::$app->session->setFlash('error', 'Data gagal dihapus.');
                $transaction->rollBack();
              }
            }
            else {
              Yii::$app->session->setFlash('error', 'Data gagal dihapus.');
              $transaction->rollBack();
            }
          }
          else{
            Yii::$app->session->setFlash('error', 'Data gagal dihapus.');
            $transaction->rollback();
          }
        } catch(Exception $e) {
          Yii::$app->session->setFlash('error', 'Fatal error.');
          $transaction->rollback();
        }
        return $this->redirect(['index', 'date'=>$dates[0] ]);
    }

    /**
     * Finds the Pembelian model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Pembelian the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pembelian::findOne($id)) !== null) {
            return $model;
        } else {
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

    public function actionGetSecuritas($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (($model = Securitas::find()->where(['KODE'=>$id])->asArray()->one()) !== null) {
            return ['data' => $model];
        } else {
            return ['data' => ''];
        }
    }

    public function getNumber()
    {
        $pembelian = Pembelian::find()->select('NOMOR')->orderBy('NOMOR desc')->one();
        $number = '000001';
        if($pembelian!==null){
            $number = str_pad((int)$pembelian->NOMOR+1,6,"0",STR_PAD_LEFT);
        }
        return $number;
    }

    public function getLatestDate()
    {
        $pembelian = Pembelian::find()->select('TGL')->orderBy('TGL desc')->one();
        $dates = [0,1];
        if($pembelian!==null){
            $dates = $this->getDates($pembelian->TGL);
        }
        return $dates;
    }

    public function getDates($date){
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

    public function getKomisi()
    {
        $komisi = Komisi::find()->select('KOM_BELI')->one();
        $kom_beli = '0.00';
        if($komisi!==null){
            $kom_beli = (float)$komisi->KOM_BELI;
        }
        return $kom_beli;
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

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
use yii\filters\AccessControl;

/**
 * PembelianController implements the CRUD actions for Pembelian model.
 */
class PembelianController extends Controller
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
     * Lists all Pembelian models.
     * @return mixed
     */
    public function actionIndex($date='')
    {
        $perpage = 10;
        if(!empty($_GET['per-page'])){
            $perpage = (int)$_GET['per-page'];
        }

        $dates = $this->getDates($date);
        $searchModel = new PembelianSearch([
            'TGL' => $dates[0]
        ]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->getSort()->defaultOrder = ['updated_at'=>SORT_DESC,'created_at'=>SORT_DESC];
        $dataProvider2 = clone $dataProvider;
        $latestDate = $this->getLatestDate();
        $session = Yii::$app->session;
        $session->set('dataProvider',$dataProvider2);
        $session->set('dates',$dates);
        $session->set('latestDate',$latestDate);
        $dataProvider->pagination->pageSize=$perpage;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'latestDate' => $latestDate,
            'lotshare' => $this->getLotshare(),
            'dates' => $dates,
            'perpage' => $perpage,
        ]);
    }

    /**
     * Displays a single Pembelian model.
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
        $ajax = Yii::$app->request->isAjax;
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
                  // JMLSAHAMB = JMLSAHAMB + JMLSAHAM
                  // SALDOB = SALDOB + TOTAL BELI
                  $modelEmiten->JMLLOTB = $modelEmiten->JMLLOTB + $model->JMLLOT;
                  $modelEmiten->JMLSAHAMB = $modelEmiten->JMLSAHAMB + $model->JMLSAHAM;
                  $modelEmiten->SALDOB = $modelEmiten->SALDOB + $model->TOTAL_BELI;
                  if($modelEmiten->save()){
                    Yii::$app->session->setFlash('success', 'Data berhasil disimpan.');
                    $transaction->commit();
                    $model = new Pembelian([
                          'TGL' => $dates[0],
                    ]);
                    $model->NOMOR = $this->getNumber();
                    $model->KOM_BELI = $this->getKomisi();
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
          //return $this->redirect(['index', 'date'=>$dates[0] ]);
          if ($ajax) {
            return $this->renderAjax('create', [
                'model' => $model,
                'lotshare' => $this->getLotshare(),
            ]);
          }
          else{
            return $this->render('create', [
                'model' => $model,
                'lotshare' => $this->getLotshare(),
            ]);
          }
        } else {
            $model->NOMOR = $this->getNumber();
            $model->TGL = $dates[1];
            //$model->JMLLOT = 1;
            //$model->HARGA = 1000;
            $model->KOM_BELI = $this->getKomisi();
            if ($ajax) {
              return $this->renderAjax('create', [
                  'model' => $model,
                  'lotshare' => $this->getLotshare(),
              ]);
            }
            else{
              return $this->render('create', [
                  'model' => $model,
                  'lotshare' => $this->getLotshare(),
              ]);
            }
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
        $oldModel = clone $model;
        $dates = $this->getDates($model->TGL);
        $ajax = Yii::$app->request->isAjax;
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
                  // JMLSAHAMB = JMLSAHAMB + JMLSAHAM
                  // SALDOB = SALDOB + TOTAL BELI
                  $modelEmiten->JMLLOTB = $modelEmiten->JMLLOTB + $model->JMLLOT - $oldModel->JMLLOT;
                  $modelEmiten->JMLSAHAMB = $modelEmiten->JMLSAHAMB + $model->JMLSAHAM - $oldModel->JMLSAHAM;
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
                if ($ajax) {
                  return $this->renderAjax('update', [
                      'model' => $model,
                      'lotshare' => $this->getLotshare(),
                  ]);
                }
                else{
                  return $this->render('update', [
                      'model' => $model,
                      'lotshare' => $this->getLotshare(),
                  ]);
                }
            }
          } catch(Exception $e) {
            Yii::$app->session->setFlash('error', 'Fatal error.');
            $transaction->rollback();
          }
          return $this->redirect(['index', 'date'=>$dates[0] ]);
        } else {
            $model->TGL  = $dates[1];
            if ($ajax) {
              return $this->renderAjax('update', [
                  'model' => $model,
                  'lotshare' => $this->getLotshare(),
              ]);
            }
            else{
              return $this->render('update', [
                  'model' => $model,
                  'lotshare' => $this->getLotshare(),
              ]);
            }
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
        $EMITEN_KODE = $model->EMITEN_KODE;
        $TOTAL_BELI = $model->TOTAL_BELI;
        //$SALDOR1 = $model->SALDOR1;
        $JMLSAHAM = $model->JMLSAHAM;
        $JMLLOT = $model->JMLLOT;
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
          $dates = $this->getDates($model->TGL);
          if($model->delete()){
            // Ada trigger saat terjadi pembelian yg mengubah nilai
            // Saldor1 = (Saldo + Total Beli) / (Jml Saham + Jml Saham Beli)
            // Total Beli, Jml Saham Beli dari table Pembelian sesuai kode Emiten.
            $modelEmiten = Emiten::find()->where(['KODE'=>$EMITEN_KODE])->one();
            if($modelEmiten){
              $modelEmiten->SALDOR1 = @(($modelEmiten->SALDO - $TOTAL_BELI ) / ($modelEmiten->JMLSAHAM - $JMLSAHAM));
              //-Ada trigger saat terjadi pembelian untuk mengubah nilai jmllot dan saldo pada table emiten:
              // JMLLOTB = JMLLOTB + JMLLOT BELI
              // JMLSAHAMB = JMLSAHAMB + JMLSAHAM
              // SALDOB = SALDOB + TOTAL BELI
              $modelEmiten->JMLLOTB = $modelEmiten->JMLLOTB - $JMLLOT;
              $modelEmiten->JMLSAHAMB =$modelEmiten->JMLSAHAMB - $JMLSAHAM;
              if($modelEmiten->JMLSAHAMB<0) $modelEmiten->JMLSAHAMB=0;
              $modelEmiten->SALDOB = $modelEmiten->SALDOB - $TOTAL_BELI;
              if($modelEmiten->save()){
                Yii::$app->session->setFlash('success', 'Data berhasil dihapus.');
                $transaction->commit();
              }
              else{
                //print_r($modelEmiten->errors);
                Yii::$app->session->setFlash('error', 'Data gagal dihapus.');
                $transaction->rollBack();
              }
            }
            else {
              Yii::$app->session->setFlash('error', 'Data gagal dihapus, fatal error.');
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

    /*
  	EXPORT WITH PHPEXCEL
  	*/
  	public function actionExportExcel()
    {
        //$searchModel = new SecuritasSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $session = Yii::$app->session;
        $dataProvider = $session->get('dataProvider');
        $dates = $session->get('dates');
        $latestDate = $session->get('latestDate');

        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $template = Yii::getAlias('@app/views/'.$this->id).'/_export.xlsx';
        $objPHPExcel = $objReader->load($template);
        //$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(\PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        //$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);
        $baseRow=4; // line 2
        $activeSheet = $objPHPExcel->getActiveSheet();
        $activeSheet->setCellValue('J2', $dates[1]);
        $activeSheet->setCellValue('D2', $latestDate[1]);
        foreach($dataProvider->getModels() as $row){
            if($baseRow!=4) $activeSheet->insertNewRowBefore($baseRow,1);
            $activeSheet->setCellValue('A'.$baseRow, $baseRow-3);
            $activeSheet->setCellValue('B'.$baseRow, $row->TGL);
            $activeSheet->setCellValue('C'.$baseRow, $row->NOMOR);
            $activeSheet->setCellValue('D'.$baseRow, $row->EMITEN_KODE);
            $activeSheet->setCellValue('E'.$baseRow, $row->SECURITAS_KODE);
            $activeSheet->setCellValue('F'.$baseRow, $row->JMLLOT);
            $activeSheet->setCellValue('G'.$baseRow, $row->JMLSAHAM);
            $activeSheet->setCellValue('H'.$baseRow, $row->HARGA);
            $activeSheet->setCellValue('I'.$baseRow, $row->KOM_BELI);
            $activeSheet->setCellValue('J'.$baseRow, $row->TOTAL_BELI);
            if($baseRow%2==1){
                $activeSheet->getStyle('A'.$baseRow.':'.'J'.$baseRow)->applyFromArray(
                    [
                        'fill' => [
                            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => ['rgb' => 'efefef']
                        ]
                    ]
                );
            }
            else{
              $activeSheet->getStyle('A'.$baseRow.':'.'J'.$baseRow)->applyFromArray(
                  [
                      'fill' => [
                          'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                          'color' => ['rgb' => 'ffffff']
                      ]
                  ]
              );
            }
            $baseRow++;

        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$this->id.'_'.date('YmdHis').'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        $objWriter->save('php://output');
        exit;
    }

    /*
  	EXPORT WITH MPDF
  	*/
    public function actionExportPdf()
    {
        //$searchModel = new SecuritasSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $session = Yii::$app->session;
        $dataProvider = $session->get('dataProvider');
        $dates = $session->get('dates');
        $latestDate = $session->get('latestDate');
        $html = $this->renderPartial('_pdf',[
          'dataProvider'=>$dataProvider,
          'dates'=>$dates,
          'latestDate'=>$latestDate,
        ]);
        //function mPDF($mode='',$format='A4',$default_font_size=0,$default_font='',$mgl=15,$mgr=15,$mgt=16,$mgb=16,$mgh=9,$mgf=9, $orientation='P') {
        $mpdf=new \mPDF('c','A4-L',0,'' , 15 , 10 , 15 , 10 , 10 , 10);
        $header = [
          'L' => [],
          'C' => [],
          'R' => [
            'content' => 'Page {PAGENO} of {nbpg}',
            'font-family' => 'sans',
            'font-style' => '',
            'font-size' => '9',	/* gives default */
          ],
          'line' => 1,		/* 1 or 0 to include line above/below header/footer */
        ];
        $mpdf->SetFooter($header,'O');
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
        $mpdf->WriteHTML($html);
        $mpdf->Output($this->id.'_'.date('YmdHis').'.pdf','D');
        exit;
    }
}

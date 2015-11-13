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
use yii\filters\AccessControl;

/**
 * AssetController implements the CRUD actions for Asset model.
 */
class AssetController extends Controller
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
     * Lists all Asset models.
     * @return mixed
     */
    public function actionIndex($start='',$end='')
    {
        $dates = $this->getFilterDates($start,$end);
        $searchModel = new AssetSearch([
            'start'=>$dates[0],
            'end'=>$dates[2],
        ]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->getSort()->defaultOrder = ['updated_at'=>SORT_DESC,'created_at'=>SORT_DESC];
        $dataProvider->pagination->pageSize=10;
        $session = Yii::$app->session;
        $session->set('dataProvider',$dataProvider);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dates' => $dates,
        ]);
    }

    /**
     * Displays a single Asset model.
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
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
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
        $model = Asset::find()->where(['TGL'=>$dates[0]])->one();
        if(!$model){
          $model = new Asset([
            'TGL' => $dates[0],
          ]);

          if(!Yii::$app->request->post()){
            foreach ($model->attributes as $key => $value) {
                if($key=='TGL'){
                  $model->TGL = $dates[0];
                }
                else{
                  $model->{$key} = 0.00;
                }
            }
          }
          $model->save();
          $model->TGL = $dates[1];
        }

        $modelat = Assetat::find()->where(['TGL'=>$dates[2]])->one();
        if(!$modelat){
          $modelat = new Assetat([
            'TGL' => $dates[2],
          ]);
          if(!Yii::$app->request->post()){
            foreach ($modelat->attributes as $key => $value) {
                if($key!='TGL'){
                  $modelat->{$key} = 0.00;
                }
            }
          }
          $modelat->save();
          $modelat->TGL = $dates[3];
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
            //die($model->TGL);
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

    public function getFilterDates($date1, $date2){
        $dates = [];
        if(!empty($date1)){
            $dates[0] = date('Y-m-d',strtotime($date1));
            $dates[1] = date('d-M-Y',strtotime($date1));
        }
        else{
            $dates[0] = date('Y').'-01-01';
            $dates[1] = '01-Jan-'.date('Y');
        }

        if(!empty($date2)){
            $dates[2] = date('Y-m-d',strtotime($date2));
            $dates[3] = date('d-M-Y',strtotime($date2));
        }
        else{
            $dates[2] = date('Y-m-d');
            $dates[3] = date('d-M-Y');
        }
        return $dates;
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

        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $template = Yii::getAlias('@app/views/'.$this->id).'/_export.xlsx';
        $objPHPExcel = $objReader->load($template);
        //$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(\PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        //$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);
        $baseRow=4; // line 2
        $activeSheet = $objPHPExcel->getActiveSheet();
        foreach($dataProvider->getModels() as $row){
            if($baseRow!=4) $activeSheet->insertNewRowBefore($baseRow,1);
            $activeSheet->setCellValue('A'.$baseRow, $baseRow-3);
            $activeSheet->setCellValue('B'.$baseRow, $row->TGL);
            $activeSheet->setCellValue('C'.$baseRow, $row->KAS_BANK);
            $activeSheet->setCellValue('D'.$baseRow, $row->TRAN_JALAN);
            $activeSheet->setCellValue('E'.$baseRow, $row->INV_LAIN);
            $activeSheet->setCellValue('F'.$baseRow, $row->STOK_SAHAM);
            if($baseRow%2==1){
                $activeSheet->getStyle('A'.$baseRow.':'.'F'.$baseRow)->applyFromArray(
                    [
                        'fill' => [
                            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => ['rgb' => 'efefef']
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
        $html = $this->renderPartial('_pdf',['dataProvider'=>$dataProvider]);
        //function mPDF($mode='',$format='A4',$default_font_size=0,$default_font='',$mgl=15,$mgr=15,$mgt=16,$mgb=16,$mgh=9,$mgf=9, $orientation='P') {
        $mpdf=new \mPDF('c','A4',0,'' , 15 , 10 , 15 , 10 , 10 , 10);
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

    /*
  	EXPORT WITH PHPEXCEL
  	*/
  	public function actionExportExcelDetail($tgl)
    {
        $dates = $this->getDates($tgl);
        $asset = Asset::find()->where(['TGL'=>$dates[0]])->one();
        $assetat = Assetat::find()->where(['TGL'=>$dates[2]])->one();

        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $template = Yii::getAlias('@app/views/'.$this->id).'/_detail_export.xlsx';
        $objPHPExcel = $objReader->load($template);

        $activeSheet = $objPHPExcel->getActiveSheet();
        $activeSheet->setCellValue('E1',date('d M Y H:i:s'));
        $activeSheet->setCellValue('B5',$dates[3]);
        $activeSheet->setCellValue('B6',$assetat->KAS_BANK);
        $activeSheet->setCellValue('B7',$assetat->TRAN_JALAN);
        $activeSheet->setCellValue('B8',$assetat->INV_LAIN);
        $activeSheet->setCellValue('B9',$assetat->STOK_SAHAM);

        $activeSheet->setCellValue('E6',$assetat->HUTANG);
        $activeSheet->setCellValue('E7',$assetat->HUT_LAIN);
        $activeSheet->setCellValue('E8',$assetat->MODAL);
        $activeSheet->setCellValue('E9',$assetat->CAD_LABA);
        $activeSheet->setCellValue('E10',$assetat->LABA_JALAN);
        $activeSheet->setCellValue('B14',$assetat->UNITAT);
        $activeSheet->setCellValue('C14',$assetat->NAVAT);

        $activeSheet->setCellValue('C5',$dates[1]);
        $activeSheet->setCellValue('C6',$asset->KAS_BANK);
        $activeSheet->setCellValue('C7',$asset->TRAN_JALAN);
        $activeSheet->setCellValue('C8',$asset->INV_LAIN);
        $activeSheet->setCellValue('C9',$asset->STOK_SAHAM);

        $activeSheet->setCellValue('D6',$asset->HUTANG);
        $activeSheet->setCellValue('D7',$asset->HUT_LANCAR);
        $activeSheet->setCellValue('D8',$asset->MODAL);
        $activeSheet->setCellValue('D9',$asset->CAD_LABA);
        $activeSheet->setCellValue('D10',$asset->LABA_JALAN);
        $activeSheet->setCellValue('B15',$asset->UNIT);
        $activeSheet->setCellValue('C15',$asset->NAV);
        $activeSheet->setCellValue('C16',$asset->TUMBUH);

        $searchModel = new IndikatorSearch([
          'TGL' => $tgl
          ]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $baseRow=19; // line 2
        $activeSheet = $objPHPExcel->getActiveSheet();
        foreach($dataProvider->getModels() as $row){
            if($baseRow!=19) $activeSheet->insertNewRowBefore($baseRow,1);
            $activeSheet->setCellValue('A'.$baseRow, $row->NAMA);
            $activeSheet->setCellValue('D'.$baseRow, $row->NAVAT);
            $activeSheet->setCellValue('E'.$baseRow, $row->NAV);
            $activeSheet->setCellValue('F'.$baseRow, $row->TUMBUH);
            if($baseRow%2==0){
                $activeSheet->getStyle('A'.$baseRow.':'.'F'.$baseRow)->applyFromArray(
                    [
                        'fill' => [
                            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => ['rgb' => 'efefef']
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
    public function actionExportPdfDetail($tgl)
    {
        $dates = $this->getDates($tgl);
        $asset = Asset::find()->where(['TGL'=>$dates[0]])->one();
        $assetat = Assetat::find()->where(['TGL'=>$dates[2]])->one();

        $searchModel = new IndikatorSearch([
          'TGL' => $tgl
          ]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $html = $this->renderPartial('_detail_pdf',[
          'asset'=>$asset,
          'assetat'=>$assetat,
          'dataProvider'=>$dataProvider,
          'dates'=>$dates,
        ]);
        //function mPDF($mode='',$format='A4',$default_font_size=0,$default_font='',$mgl=15,$mgr=15,$mgt=16,$mgb=16,$mgh=9,$mgf=9, $orientation='P') {
        $mpdf=new \mPDF('c','A4',0,'' , 15 , 10 , 15 , 10 , 10 , 10);
        $header = [
          'L' => [
            'content' => date('d-M-Y H:i:s'),
            'font-family' => 'sans',
            'font-style' => '',
            'font-size' => '9',	/* gives default */
          ],
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

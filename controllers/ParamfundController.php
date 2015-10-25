<?php

namespace app\controllers;

use Yii;
use app\models\Paramfund;
use app\models\ParamfundSearch;
use app\models\Emiten;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ParamfundController implements the CRUD actions for Paramfund model.
 */
class ParamfundController extends Controller
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
     * Lists all Paramfund models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ParamfundSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=10;
        $session = Yii::$app->session;
        $session->set('dataProvider',$dataProvider);
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
        if (Yii::$app->request->isAjax) {
          return $this->renderAjax('view', [
              'model' => $this->findModel($EMITEN_KODE, $TAHUN, $TRIWULAN),
          ]);
        }
        else{
          return $this->render('view', [
              'model' => $this->findModel($EMITEN_KODE, $TAHUN, $TRIWULAN),
          ]);
        }
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
                return $this->redirect(['index']);
            }
            else{
                Yii::$app->session->setFlash('error', 'Data gagal disimpan.');
                if (Yii::$app->request->isAjax) {
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

            //return $this->redirect(['view', 'EMITEN_KODE' => $model->EMITEN_KODE, 'TAHUN' => $model->TAHUN, 'TRIWULAN' => $model->TRIWULAN]);
        } else {
            if (Yii::$app->request->isAjax) {
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
                return $this->redirect(['index']);
            }
            else{
                Yii::$app->session->setFlash('error', 'Data gagal disimpan.');
                if (Yii::$app->request->isAjax) {
                  return $this->renderAjax('update', [
                      'model' => $this->findModel($EMITEN_KODE, $TAHUN, $TRIWULAN),
                  ]);
                }
                else{
                  return $this->render('update', [
                      'model' => $this->findModel($EMITEN_KODE, $TAHUN, $TRIWULAN),
                  ]);
                }
            }

            //return $this->redirect(['view', 'EMITEN_KODE' => $model->EMITEN_KODE, 'TAHUN' => $model->TAHUN, 'TRIWULAN' => $model->TRIWULAN]);
        } else {
            if (Yii::$app->request->isAjax) {
              return $this->renderAjax('update', [
                  'model' => $this->findModel($EMITEN_KODE, $TAHUN, $TRIWULAN),
              ]);
            }
            else{
              return $this->render('update', [
                  'model' => $this->findModel($EMITEN_KODE, $TAHUN, $TRIWULAN),
              ]);
            }
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
            $activeSheet->setCellValue('B'.$baseRow, $row->EMITEN_KODE);
            $activeSheet->setCellValue('C'.$baseRow, $row->TAHUN);
            $activeSheet->setCellValue('D'.$baseRow, $row->TRIWULAN);
            $activeSheet->setCellValue('E'.$baseRow, $row->CE);
            $activeSheet->setCellValue('F'.$baseRow, $row->CA);
            $activeSheet->setCellValue('G'.$baseRow, $row->TA);
            $activeSheet->setCellValue('H'.$baseRow, $row->TE);
            $activeSheet->setCellValue('I'.$baseRow, $row->CL);
            $activeSheet->setCellValue('J'.$baseRow, $row->TL);
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

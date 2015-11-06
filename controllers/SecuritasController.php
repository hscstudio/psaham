<?php

namespace app\controllers;

use Yii;
use app\models\Securitas;
use app\models\SecuritasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Exception;
use yii\filters\AccessControl;

/**
 * SecuritasController implements the CRUD actions for Securitas model.
 */
class SecuritasController extends Controller
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
     * Lists all Securitas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SecuritasSearch();
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
          try {
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
          } catch(Exception $e) {
            Yii::$app->session->setFlash('error', 'Kode sudah ada, pilih kode lain.');
            return $this->renderAjax('create', [
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
          try {
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
          } catch(Exception $e) {
            Yii::$app->session->setFlash('error', 'Fatal error.');
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
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
            $activeSheet->setCellValue('B'.$baseRow, $row->KODE);
            $activeSheet->setCellValue('C'.$baseRow, $row->NAMA);
            $activeSheet->setCellValue('D'.$baseRow, $row->ALAMAT.','.$row->TELP);
            $activeSheet->setCellValue('E'.$baseRow, $row->CP);
            if($baseRow%2==1){
                $activeSheet->getStyle('A'.$baseRow.':'.'E'.$baseRow)->applyFromArray(
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
        $mpdf=new \mPDF('c','A4',0,'' , 15 , 10 , 15 , 10 , 10 , 10, 'L');
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

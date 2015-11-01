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
use yii\filters\AccessControl;

/**
 * EmitenController implements the CRUD actions for Emiten model.
 */
class EmitenController extends Controller
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
     * Lists all Emiten models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmitenSearch();
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
     * Displays a single Emiten model.
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
     * Creates a new Emiten model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Emiten();
        $ajax = Yii::$app->request->isAjax;
        if ($model->load(Yii::$app->request->post())) {
            //$model->SALDOR1 = (float) @($model->SALDO / $model->JMLSAHAM);
            $model->SALDOR1 = 0;
            $model->JMLLOTB = $model->JMLLOT;
            $model->SALDOB = $model->SALDO;
            if($model->save()){
              Yii::$app->session->setFlash('success', 'Data berhasil disimpan.');
              return $this->redirect(['index']);
            }
            else{
              Yii::$app->session->setFlash('error', 'Data gagal disimpan.');
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
            //return $this->redirect(['view', 'id' => $model->KODE]);
        } else {
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
     * Updates an existing Emiten model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $ajax = Yii::$app->request->isAjax;
        if ($model->load(Yii::$app->request->post())) {
            //return $this->redirect(['view', 'id' => $model->KODE]);
            if($model->save()){
              Yii::$app->session->setFlash('success', 'Data berhasil disimpan.');
              return $this->redirect(['index']);
            }
            else{
              Yii::$app->session->setFlash('error', 'Data gagal disimpan.');
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
        } else {
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
            $activeSheet->setCellValue('D'.$baseRow, $row->JMLLOT);
            $activeSheet->setCellValue('E'.$baseRow, $row->JMLSAHAM);
            $activeSheet->setCellValue('F'.$baseRow, $row->SALDO);
            $activeSheet->setCellValue('G'.$baseRow, $row->HARGA);
            $activeSheet->setCellValue('H'.$baseRow, $row->SALDOR1);
            $activeSheet->setCellValue('I'.$baseRow, $row->JMLLOTB);
            $activeSheet->setCellValue('J'.$baseRow, $row->SALDOB);
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

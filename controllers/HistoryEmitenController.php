<?php

namespace app\controllers;

use Yii;
use app\models\Emiten;
use app\models\Detemiten;
use app\models\EmitenSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Lotshare;

/**
 * HistoryEmitenController implements the CRUD actions for Emiten model.
 */
class HistoryEmitenController extends Controller
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
    public function actionIndex($perpage=20)
    {
        $searchModel = new EmitenSearch([
            'JMLLOT' => 0,
        ]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=$perpage;
        $session = Yii::$app->session;
        $session->set('dataProvider',$dataProvider);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perpage' => $perpage,
            'lotshare' => $this->getLotshare(),
        ]);
    }

    /**
     * Displays a single Emiten model.
     * @param string $id
     * @return mixed
     */
    public function actionSse()
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        //generate random number for demonstration
        $emiten = Emiten::find()
          ->select('last_update')
          ->orderBy('last_update DESC')
          ->one();
        $last_update = $emiten->last_update;
        echo "data: ".$last_update."\n\n";
        ob_flush();
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

    /*
  	EXPORT WITH PHPEXCEL
  	*/
  	public function actionExportExcel()
    {
        //$searchModel = new SecuritasSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $session = Yii::$app->session;
        $dataProvider = $session->get('dataProvider');
        $lotshare = $this->getLotshare();
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
            $activeSheet->setCellValue('C'.$baseRow, $row->JMLLOT);
            $activeSheet->setCellValue('D'.$baseRow, $row->JMLSAHAM);

            //-	Range Beli = saldob / (jmllotb * jmllbrsaham) -> Ket:  saldob, jmllotb dr detemiten; jmllbrsaham dr lotshare.
            $detemiten = Detemiten::find()->where(['EMITEN_KODE'=>$row->KODE])->orderBy('TGL DESC')->one();
            $range_beli = (float) @($detemiten->SALDOB / ($detemiten->JMLLOTB * $lotshare));

            $activeSheet->setCellValue('E'.$baseRow, $range_beli);
            $range = @($row->SALDO / $row->JMLSAHAM);
            $activeSheet->setCellValue('F'.$baseRow, $range);

            $activeSheet->setCellValue('G'.$baseRow, $row->SALDO);
            $activeSheet->setCellValue('H'.$baseRow, $row->HARGA);

            $detemiten = Detemiten::find()->where(['EMITEN_KODE'=>$row->KODE])->orderBy('TGL DESC')->one();
            if(substr($detemiten->TGLAKHIR,0,4)=='0000'){
              $tgl = '-';
            }
            else
              $tgl = date('d-m-Y',strtotime($detemiten->TGLAKHIR));
            $activeSheet->setCellValue('I'.$baseRow, $tgl);
            $saldo2 = @($row->HARGA / $row->JMLSAHAM);
            $activeSheet->setCellValue('J'.$baseRow, $saldo2);
            $laba_rugi = ($row->JMLSAHAM * $row->HARGA) - $row->SALDO;
            $activeSheet->setCellValue('K'.$baseRow, $laba_rugi);
            if($baseRow%2==0){
                $activeSheet->getStyle('A'.$baseRow.':'.'K'.$baseRow)->applyFromArray(
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

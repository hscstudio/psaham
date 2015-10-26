<?php

namespace app\controllers;

use Yii;
use app\models\Paramfund;
use app\models\HistoryParamfund;
use app\models\Emiten;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

/**
 * HistoryParamfundController implements the CRUD actions for Paramfund model.
 */
class HistoryParamfundController extends Controller
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
        $historyModel = new HistoryParamfund();
        $historyModel->TAHUN_MULAI = date('Y');
        $historyModel->TAHUN_AKHIR = $historyModel->TAHUN_MULAI;
        $historyModel->TRIWULAN_MULAI = 'I';
        if(date('m')>=9){
          $historyModel->TRIWULAN_AKHIR = 'IV';
        }
        else if(date('m')>=6){
          $historyModel->TRIWULAN_AKHIR = 'III';
        }
        else if(date('m')>=3){
          $historyModel->TRIWULAN_AKHIR = 'II';
        }
        else{
          $historyModel->TRIWULAN_AKHIR = 'I';
        }

        if ($historyModel->load(Yii::$app->request->post())) {
          $emitenKodes = $historyModel->EMITEN_KODES;
          if(!$emitenKodes) $emitenKodes = [];
          $tahunMulai = $historyModel->TAHUN_MULAI;
          $tahunAkhir = $historyModel->TAHUN_AKHIR;
          $tahuns = [];
          for($i=$tahunMulai;$i<=$tahunAkhir;$i++){
            $tahuns[] =  $i;
          }

          $triwulanMulai = $historyModel->TRIWULAN_MULAI;
          $triwulanAkhir = $historyModel->TRIWULAN_AKHIR;
          $triwulans = [];
          if($triwulanMulai=='I' and $triwulanAkhir=='IV'){
              $triwulans = ['I','II','III','IV'];
          }
          else if($triwulanMulai=='I' and $triwulanAkhir=='III'){
              $triwulans = ['I','II','III'];
          }
          else if($triwulanMulai=='I' and $triwulanAkhir=='II'){
              $triwulans = ['I','II'];
          }
          else if($triwulanMulai=='II' and $triwulanAkhir=='IV'){
              $triwulans = ['II','III','IV'];
          }
          else if($triwulanMulai=='II' and $triwulanAkhir=='III'){
              $triwulans = ['II','III'];
          }
          else if($triwulanMulai=='III' and $triwulanAkhir=='IV'){
              $triwulans = ['III','IV'];
          }
          else if($triwulanMulai==$triwulanAkhir){
              $triwulans = [$triwulanMulai];
          }

          $dataProviders = [];
          foreach ($emitenKodes as $kode) {
              $emitenModel = $this->getEmiten($kode);
              if($emitenModel){
                  $query = Paramfund::find()
                    ->where([
                      'TAHUN' => $tahuns,
                      'TRIWULAN' => $triwulans,
                      'EMITEN_KODE' => $kode,
                    ]);

                  $dataProvider = new ActiveDataProvider([
                      'query' => $query,
                  ]);
                  $dataProvider->getSort()->defaultOrder = [
                      'TAHUN'=>SORT_ASC,'TRIWULAN'=>SORT_ASC
                  ];

                  $dataProviders[$kode] = $dataProvider;
              }
          }
          if(!empty($dataProviders)){
              $session = Yii::$app->session;
              $session->set('dataProviders',$dataProviders);
              return $this->render('index', [
                  'historyModel' => $historyModel,
                  'dataProviders' => $dataProviders,
              ]);
          }
          else{
              return $this->render('index', [
                  'historyModel' => $historyModel,
              ]);
          }
        }
        else{
          return $this->render('index', [
              'historyModel' => $historyModel,
          ]);
        }
    }

    public function getEmiten($id)
    {
        if (($model = Emiten::find()->where(['KODE'=>$id])->asArray()->one()) !== null) {
            return $model;
        } else {
            return null;
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
        $dataProviders = $session->get('dataProviders');

        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $template = Yii::getAlias('@app/views/'.$this->id).'/_export.xlsx';
        $objPHPExcel = $objReader->load($template);
        $activeSheet = $objPHPExcel->getActiveSheet();
        $iterate=0;
        $startRow = 3;
        $spaceRow = 4;
        $space = 2;
        foreach ($dataProviders as $emitenCode => $dataProvider) {
          $iterate++;
          if($iterate==1){
            $baseRow= $startRow; // line 2
            $space = 1;
          }
          else{
            $baseRow= $baseRow+$spaceRow; // line 2
            $space = 2;
          }
          $activeSheet->setCellValue('C'.($baseRow+($space-1)), $emitenCode);
          $no = 0;
          foreach($dataProvider->getModels() as $row){
              $no++;
              $currentRow = $no+$baseRow+$space;
              if($no!=1){
                  $activeSheet->insertNewRowBefore($currentRow,1);
              }
              $activeSheet->setCellValue('A'.$currentRow, $no);
              $activeSheet->setCellValue('B'.$currentRow, $row->TAHUN);
              $activeSheet->setCellValue('C'.$currentRow, $row->TRIWULAN);
              $activeSheet->setCellValue('D'.$currentRow, $row->SHARE);
              $activeSheet->setCellValue('E'.$currentRow, $row->BV);
              $activeSheet->setCellValue('F'.$currentRow, $row->P_BV);
              $activeSheet->setCellValue('G'.$currentRow, $row->EPS);
              $activeSheet->setCellValue('H'.$currentRow, $row->P_EPS);
              $activeSheet->setCellValue('I'.$currentRow, $row->PBV);
              $activeSheet->setCellValue('J'.$currentRow, $row->PER);
              $activeSheet->setCellValue('K'.$currentRow, $row->DER);
              $activeSheet->setCellValue('L'.$currentRow, $row->HARGA);
              if($no%2==0){
                  $activeSheet->getStyle('A'.$currentRow.':'.'L'.$currentRow)->applyFromArray(
                      [
                          'fill' => [
                              'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                              'color' => ['rgb' => 'efefef']
                          ]
                      ]
                  );
              }
          }
        }
        $objPHPExcel->getActiveSheet()->removeRow($currentRow+$space, 50);
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
        $dataProviders = $session->get('dataProviders');
        $html = $this->renderPartial('_pdf',['dataProviders'=>$dataProviders]);
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

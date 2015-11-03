<?php

namespace app\controllers;

use Yii;
use app\models\Emiten;
use app\models\Komisi;
use app\models\EmitenSearch;
use app\models\DetemitenSearch;
use app\models\Detemiten;
use app\models\Lotshare;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\base\DynamicModel;

/**
 * EmitenController implements the CRUD actions for Emiten model.
 */
class ReportEmitenController extends Controller
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
    public function actionIndex($date='')
    {
        $session = Yii::$app->session;

        $simulation = new DynamicModel([
            'tipe', 'jml_lot', 'harga', 'komisi', 'total_komisi', 'jml_saham',
            'range','total_harga',
        ]);
        $simulation->addRule(['tipe','jml_lot','harga'], 'required');
        $simulation->tipe = 1;
        $selectDate = [];
        if(!empty($date)){
          $selectDate = $this->getDates($date)[0];
          if(!$this->checkDetemitenByDate($date)){
              // TIDAK ADA DETEMITEN
              $maxDate = $this->getMaxDetemitenDate();
              $connection = \Yii::$app->db;
              $transaction = $connection->beginTransaction();
              try {
                $sql = "INSERT INTO detemiten
                  SELECT '".$selectDate."', emiten.KODE, emiten.JMLLOT, emiten.JMLSAHAM,
                  emiten.SALDO, emiten.SALDOR1, emiten.HARGA, '".$maxDate."',
                  emiten.JMLLOTB, emiten.JMLSAHAMB, emiten.SALDOB
                  FROM emiten WHERE emiten.JMLLOT>0";
                $connection->createCommand($sql)->execute();
                //f.	Buat query untuk menampung data detemiten dimana tanggal = [tglMax]
                //select * from detemiten where tanggal = [tglMax]
                $emitens = Detemiten::find()->where(['TGL'=>$maxDate])->all();
                //g.	Lakukan looping sebanyak record yg dihasilkan dari query f.
                foreach($emitens as $emiten){
                    /*
                    Setiap looping lakukan update harga sbb :
                    For i = 1 To RecordCount
                    update detemiten set harga = [harga hasil query f]
                    where kode = [kode hasil query f] and tanggal = [tgl yg dipilih]
                    Next i
                    */
                    $emiten_update = Detemiten::find()->where([
                      'EMITEN_KODE'=>$emiten->EMITEN_KODE,
                      'TGL'=>$selectDate,
                    ])->one();
                    if($emiten_update){
                      $emiten_update->HARGA = $emiten->HARGA;
                      $emiten_update->save();
                    }

                }

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Success.');
              } catch(Exception $e) {
                Yii::$app->session->setFlash('error', 'Fatal error.');
                $transaction->rollback();
              }
          }
        }

        $reportDates = [];
        $detemitenDates = [];
        foreach ($this->getDetemitenDates() as $detemitenDate) {
            $formatDate = date('d-M-Y',strtotime($detemitenDate));
            if(empty($reportDates)){
                if(empty($selectDate)){
                  $reportDates = $this->getDates($formatDate);
                }
                else{
                  $reportDates = $this->getDates($date);
                  //die($selectDate[0]);
                }
            }
            $detemitenDates[$formatDate] = $formatDate;
        }

        $komisi = Komisi::find()->one();
        $lotshare = Lotshare::find()->one();
        //$detemitenDates = ['31-Oct-2015'=>'31-Oct-2015'];
        //Saldo**) = jmlsaham * harga
        $detemitenSaldo = Detemiten::find()
          ->select('SUM(JMLSAHAM * HARGA) as total_saldo')
          ->where(['TGL' => $reportDates[0]])
          ->asArray()
          ->one();
        $total_saldo = $detemitenSaldo['total_saldo'];
        $session->set('total_saldo',$total_saldo);

        $detemitenLabaRugi = Detemiten::find()
          ->select('SUM(JMLSAHAM * HARGA - SALDO) as total_laba_rugi')
          ->where(['TGL' => $reportDates[0]])
          ->asArray()
          ->one();
        $total_laba_rugi = $detemitenLabaRugi['total_laba_rugi'];
        $session->set('total_laba_rugi',$total_laba_rugi);

        $searchModel = new DetemitenSearch([
            'TGL' => $reportDates[0],
        ]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider2 = clone $dataProvider;
        $session->set('dataProvider',$dataProvider2);
        $dataProvider->pagination->pageSize=10;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'simulation' => $simulation,
            'reportDates' => $reportDates,
            'detemitenDates' => $detemitenDates,
            'komisi' => $komisi,
            'lotshare' => $lotshare,
            'total_saldo' => $total_saldo,
            'total_laba_rugi'=> $total_laba_rugi,
        ]);
    }

    /**
     * Updates an existing Emiten model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $dates= $this->getDates();
        if ($post = Yii::$app->request->post()) {
          $dates = $this->getDates($post['reportDate']);
          foreach ($post['harga'] as $kode => $harga){
            //echo $kode.'=>'.$harga.'<br>';
            $detemiten = Detemiten::find()
              ->where([
                  'TGL'=>$dates[0],
                  'EMITEN_KODE'=>$kode,
              ])
              ->one();
            $detemiten->HARGA = (float)$harga;
            $detemiten->save();
          }
          Yii::$app->session->setFlash('success', 'Data berhasil disimpan.');
        }
        return $this->redirect(['index', 'date' => $dates[0]]);
    }

    /**
     * Updates an existing Emiten model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($date)
    {
        $dates= $this->getDates($date);
        Detemiten::deleteAll(['TGL'=>$dates[0]]);
        Yii::$app->session->setFlash('success', 'Data berhasil dihapus.');
        return $this->redirect(['index']);
    }

    public function getDates($date=''){
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

    public function getDetemitenDates(){
      $dates = Detemiten::find()
        ->select('TGL')
        ->orderBy('TGL desc')
        ->groupBy('TGL')
        ->column();
      return $dates;
    }

    public function getMaxDetemitenDate(){
      $detemiten = Detemiten::find()
        ->select('TGL')
        ->orderBy('TGL desc')
        ->one();
      if($detemiten) return $detemiten->TGL;
      else return null;
    }

    public function checkDetemitenByDate($date){
      $date = date('Y-m-d',strtotime($date));
      $exists = Detemiten::find()
        ->where(['TGL'=>$date])
        ->exists();
      return $exists;
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
        $total_saldo = $session->get('total_saldo');
        $total_laba_rugi = $session->get('total_laba_rugi');

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
            $activeSheet->setCellValue('C'.$baseRow, $row->JMLLOT);
            $activeSheet->setCellValue('D'.$baseRow, $row->JMLSAHAM);
            $activeSheet->setCellValue('E'.$baseRow, (float) @($row->SALDOB / $row->JMLSAHAMB) );
            $activeSheet->setCellValue('F'.$baseRow, (float) @($row->SALDO / $row->JMLSAHAM));
            $activeSheet->setCellValue('G'.$baseRow, $row->SALDO);
            $activeSheet->setCellValue('H'.$baseRow, $row->HARGA);
            $activeSheet->setCellValue('I'.$baseRow, $row->TGLAKHIR);
            $activeSheet->setCellValue('J'.$baseRow, $row->HARGA * $row->JMLSAHAM);
            $activeSheet->setCellValue('K'.$baseRow, (float) @(($row->JMLSAHAM * $row->HARGA * 100) / $total_saldo) );
            $activeSheet->setCellValue('L'.$baseRow, ($row->JMLSAHAM * $row->HARGA) - $row->SALDO );
            if($baseRow%2==1){
                $activeSheet->getStyle('A'.$baseRow.':'.'M'.$baseRow)->applyFromArray(
                    [
                        'fill' => [
                            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => ['rgb' => 'efefef']
                        ]
                    ]
                );
            }
            else{
              $activeSheet->getStyle('A'.$baseRow.':'.'M'.$baseRow)->applyFromArray(
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
        //$activeSheet->setCellValue('M'.$baseRow+1, ($total_laba_rugi) );
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
        $total_saldo = $session->get('total_saldo');
        $total_laba_rugi = $session->get('total_laba_rugi');
        $html = $this->renderPartial('_pdf',[
          'dataProvider'=>$dataProvider,
          'total_saldo'=>$total_saldo,
          'total_laba_rugi'=>$total_laba_rugi,
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

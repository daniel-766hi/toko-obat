<?php

namespace app\controllers;

use app\models\ObatAuroM;
use app\models\PembelianObat;
use TCPDF;
use yii;

use app\models\PenjualanObat;
use app\models\PencJualan;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * PenjualanController implements the CRUD actions for PenjualanObat model.
 */
class PenjualanController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all PenjualanObat models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PencJualan();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionPenjualan()
    {
        $model = new \app\models\PenjualanObat();
    
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                return;
            }
        }
    
        return $this->render('penjualan', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single PenjualanObat model.
     * @param int $id_penjualan Id Penjualan
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_penjualan)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_penjualan),
        ]);
    }

    /**
     * Creates a new PenjualanObat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
{
    $model = new PenjualanObat();

    if ($this->request->isPost) {
        if ($model->load($this->request->post()) && $model->validate()) {
            // Ambil harga_jual terbaru dari PembelianObat berdasarkan nama_obat
            $pembelianObat = PembelianObat::find()
                ->where(['id_obat' => $model->nama_obat])
                ->orderBy(['id_pembelian' => SORT_DESC])
                ->one();

            if ($pembelianObat) {
                $model->harga_pembelian = $pembelianObat->harga_jual * $model->banyak_pembelian;
            }

            if ($model->save()) {
                // Mengurangi stok obat di ObatAuroM
                $obat = ObatAuroM::findOne(['nama_obat' => $model->nama_obat]);
                if ($obat) {
                    $obat->stock_obat -= $model->banyak_pembelian;
                    $obat->save();
                }
                return $this->redirect(['view', 'id_penjualan' => $model->id_penjualan]);
            }
        }
    } else {
        $model->loadDefaultValues();
    }

    return $this->render('create', [
        'model' => $model,
    ]);
}
public function actionGenerateInvoicePdf($id)
{
    // Fetch the PenjualanObat model based on the $id
    $model = PenjualanObat::findOne($id);

    // Create a new TCPDF object
    $pdf = new TCPDF();

    // Start PDF document
    $pdf->SetTitle('Invoice');
    $pdf->SetAutoPageBreak(true, 15);

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('Courier', '', 12);

    // Define table column widths
    $col1Width = 60;
    $col2Width = 100;

    // Output data in the table
    $pdf->Cell($col1Width, 10, 'Transaction Date', 1);
    $pdf->Cell($col2Width, 10, $model->tanggal_transaksi, 1);
    $pdf->Ln();

    $pdf->Cell($col1Width, 10, 'Number of Items Bought', 1);
    $pdf->Cell($col2Width, 10, $model->banyak_pembelian, 1);
    $pdf->Ln();

    $pdf->Cell($col1Width, 10, 'Buyer Name', 1);
    $pdf->Cell($col2Width, 10, $model->nama_pembeli, 1);
    $pdf->Ln();

    $medicineModel = ObatAuroM::findOne($model->nama_obat);
    if ($medicineModel) {
        $medicineName = $medicineModel->nama_obat;
    } else {
        $medicineName = 'Medicine Not Found';
    }
    $pdf->Cell($col1Width, 10, 'Obat', 1);
    $pdf->Cell($col2Width, 10, $medicineModel->nama_obat, 1);
    $pdf->Ln();

    $pdf->Cell($col1Width, 10, 'Total Cost', 1);
    $pdf->Cell($col2Width, 10, $model->harga_pembelian, 1);
    $pdf->Ln();

    // Output the PDF
    $pdf->Output();
    Yii::$app->end();
}


    


    /**
     * Updates an existing PenjualanObat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_penjualan Id Penjualan
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_penjualan)
    {
        $model = $this->findModel($id_penjualan);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_penjualan' => $model->id_penjualan]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PenjualanObat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_penjualan Id Penjualan
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_penjualan)
    {
        $this->findModel($id_penjualan)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PenjualanObat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_penjualan Id Penjualan
     * @return PenjualanObat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_penjualan)
    {
        if (($model = PenjualanObat::findOne(['id_penjualan' => $id_penjualan])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

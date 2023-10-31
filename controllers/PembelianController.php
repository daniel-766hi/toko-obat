<?php

namespace app\controllers;

use app\models\ObatAuroM;
use yii;

use app\models\PembelianObat;
use app\models\PencBeli;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PembelianController implements the CRUD actions for PembelianObat model.
 */
class PembelianController extends Controller
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
     * Lists all PembelianObat models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PencBeli();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionPembelian()
{
    $model = new \app\models\PembelianObat();

    if ($model->load(Yii::$app->request->post())) {
        if ($model->validate()) {
            // form inputs are valid, do something here
            return;
        }
    }

    return $this->render('pembelian', [
        'model' => $model,
    ]);
}

    /**
     * Displays a single PembelianObat model.
     * @param int $id_pembelian Id Pembelian
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_pembelian)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_pembelian),
        ]);
    }

    /**
     * Creates a new PembelianObat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
{
    $model = new PembelianObat();
    
    if ($model->load(Yii::$app->request->post())) {
        if ($model->validate()) {
            // Simpan data pembelian
            if ($model->save()) {
                // Update stok obat di ObatAuroM
                $obat = ObatAuroM::findOne(['id_obat' => $model->id_obat]);
                if ($obat) {
                    $obat->stock_obat += $model->banyak_dibeli;
                    // Update harga_obat dari harga_beli
                    $obat->harga_obat = $model->harga_beli;
                    $obat->save();
                }
                return $this->redirect(['view', 'id_pembelian' => $model->id_pembelian]);
            }
        }
    }
    
    return $this->render('create', [
        'model' => $model,
    ]);
}

    
    /**
     * Updates an existing PembelianObat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_pembelian Id Pembelian
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_pembelian)
    {
        $model = $this->findModel($id_pembelian);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_pembelian' => $model->id_pembelian]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PembelianObat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_pembelian Id Pembelian
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_pembelian)
    {
        $this->findModel($id_pembelian)->delete();

        return $this->redirect(['index']);
    }
    


    /**
     * Finds the PembelianObat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_pembelian Id Pembelian
     * @return PembelianObat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_pembelian)
    {
        if (($model = PembelianObat::findOne(['id_pembelian' => $id_pembelian])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

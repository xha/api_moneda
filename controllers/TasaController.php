<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Moneda;
use app\models\Tasa;
use app\models\TasaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use app\models\AccessHelpers;

/**
 * TasaController implements the CRUD actions for Tasa model.
 */
class TasaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create','actualiza-moneda','retornar-moneda','view','index','update','delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create','actualiza-moneda','retornar-moneda','view','index','update','delete'],
                        'roles' => ['@'],
                    ],
                ],
                /*'denyCallback' => function ($rule, $action) {
                    return $this->render('index');
                }*/
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Tasa models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TasaSearch(['activo' => 1]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['fechaOperacion'=>SORT_DESC]];
        return $this->render('index', [
            'principal' => $this->actionRetornarMoneda(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    function actionActualizaMoneda($moneda) {
        $data = Tasa::find()
            ->where(['activo' => true, 'idMoneda' => $moneda])
            ->one();
        if (count($data) > 0) {
            $model = $this->findModel($data->idTasa);
            $model->activo=0;
            $model->save();
        }
        return true;
    }

    public function actionRetornarMoneda() 
    {
        $data = Moneda::find()
            ->where(['principal' => true])
            ->all();
        return $data[0]->simbolo." ".$data[0]->alias;
    }

    public function actionRetornaTasa($currency, $pair = null) 
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $currency = trim(strtoupper($currency));
        $rs = [];
        $rate = [];
        $data = [];
        $bandera=false;
        $dolar=0;

        if ($pair!==null) {
            $pair = trim(strtoupper($pair));
            if ($pair==$currency) {
                $rate = floatval(1);
            } else {
                $mcurrency = Moneda::find()
                    ->where(['alias' => $currency])
                    ->one();

                $mpair = Moneda::find()
                    ->where(['alias' => $pair])
                    ->one();

                if($mcurrency->principal==1) {
                    $tasa = Tasa::find()
                        ->where(['idMoneda' => $mpair->idMoneda])
                        ->one();
                    $rate = floatval($tasa->tasaActual);
                } else {
                    $tasa = Tasa::find()
                        ->where(['idMoneda' => $mcurrency->idMoneda])
                        ->one();
                    $rate = floatval(1 / $tasa->tasaActual);
                }    
            }
            

            $rs["pair"]=$currency.$pair;
            $rs["status"]="success";
            $rs["rate"]=$rate;
        } else {
            $actual = Moneda::find()
                ->where(['alias' => trim(strtoupper($currency))])
                ->one();
            
            if($actual->principal==1) {
                $bandera=true;
                $rate[$currency] = floatval(1);
            } else {
                $tasa = Tasa::find()
                    ->where(['idMoneda' => $actual->idMoneda])
                    ->one();
                $dolar = 1 / $tasa->tasaActual;
                $rate['USD'] = floatval($dolar);
            }

            $tasa = Tasa::find()
                ->where(['activo' => 1])
                ->all();

            foreach($tasa as $tasa) {
                $moneda = Moneda::find()
                    ->where(['activo' => 1, 'idMoneda' => $tasa->idMoneda])
                    ->one();
                if (count($moneda)>0) {
                    if ($bandera) {
                        $rate[$moneda->alias] = floatval($tasa->tasaActual);
                    } else {
                        if ($moneda->alias==$currency) {
                            $rate[$moneda->alias] = floatval(1);
                        } else {
                            $valor = $dolar * $tasa->tasaActual;
                            $rate[$moneda->alias] = floatval($valor);
                        }                    
                    }                
                }
            }
            
            $data["currency"]=trim(strtolower($currency));
            $data["status"]="success";
            $data["rates"]=$rate;
            $rs["data"]=$data;
        }

        return $rs;
    }

    /**
     * Displays a single Tasa model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tasa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tasa();

        if ($model->load(Yii::$app->request->post())) {
            date_default_timezone_set("America/Caracas");
            $fechat = date('Ymd H:i:s',time());
            $valor = $this->actionActualizaMoneda($model->idMoneda);
            
            if ($valor) {
                $model->save();
                return $this->redirect(['index']);    
            }            
        }

        return $this->render('create', [
            'model' => $model,
            'principal' => $this->actionRetornarMoneda(),
        ]);
    }

    /**
     * Updates an existing Tasa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            date_default_timezone_set("America/Caracas");
            $fechat = date('Ymd',time());
            $valor = $this->actionActualizaMoneda($model->idMoneda);

            if ($valor) {
                $model->fechaOperacion=$fechat;
                $model->activo=1;
                $model->save();
                return $this->redirect(['index']);    
            }      
        }

        return $this->render('update', [
            'model' => $model,
            'principal' => $this->actionRetornarMoneda(),
        ]);
    }

    /**
     * Deletes an existing Tasa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->activo=0;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tasa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tasa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tasa::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

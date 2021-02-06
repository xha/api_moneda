<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Moneda;
use app\models\MonedaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MonedaController implements the CRUD actions for Moneda model.
 */
class MonedaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create','view','index','update','delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create','view','index','update','delete'],
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
     * Lists all Moneda models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MonedaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Moneda model.
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
     * Creates a new Moneda model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Moneda();
        $error = '';

        if ($model->load(Yii::$app->request->post())) {
            date_default_timezone_set("America/Caracas");
            $fechat = date('Ymd H:i:s',time());
            $model->alias=strtoupper($model->alias);
            $model->descripcion=strtoupper($model->descripcion);
            //$model->fechaCreacion = $fechat;
            if($model->validate()) {
                $model->save();
                return $this->redirect(['index']);
            } else {
                $error = $model->getErrors();
            }
        }

        return $this->render('create', [
            'model' => $model,
            'error' => $error,
        ]);
    }

    /**
     * Updates an existing Moneda model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $error = '';

        if ($model->load(Yii::$app->request->post())) {
            date_default_timezone_set("America/Caracas");
            $fechat = date('Ymd H:i:s',time());
            $model->alias=strtoupper($model->alias);
            $model->descripcion=strtoupper($model->descripcion);
            if($model->validate()) {
                $model->save();
                return $this->redirect(['index']);
            } else {
                $error = $model->getErrors();
            }
        }

        return $this->render('update', [
            'model' => $model,
            'error' => $error,
        ]);
    }

    /**
     * Deletes an existing Moneda model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
        $model = $this->findModel($id);
        $model->activo=0;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Moneda model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Moneda the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Moneda::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

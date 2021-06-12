<?php

namespace backend\controllers;

use common\models\Company;
use common\models\Discounts;
use common\models\EventsCategory;
use common\models\NewsCategory;
use common\models\VacanciesCategory;
use Yii;
use common\models\Vacancies;
use common\models\search\VacanciesSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VacanciesController implements the CRUD actions for Vacancies model.
 */
class VacanciesController extends Controller
{

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Vacancies models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VacanciesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Vacancies model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionApprove()
    {
        $id = $_GET['id'];
        $event = Vacancies::findOne($id);
        if (!$event)  throw new NotFoundHttpException('The requested page does not exist.');
        $event->is_approved = 1;
        $event->save(false);

        return $this->redirect('/vacancies');
    }

    public function actionDisapprove()
    {
        $id = $_GET['id'];
        $event = Vacancies::findOne($id);
        if (!$event)  throw new NotFoundHttpException('The requested page does not exist.');
        $event->is_approved = 2;
        $event->save(false);

        return $this->redirect('/vacancies');
    }
    /**
     * Creates a new Vacancies model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Vacancies();

        $category = VacanciesCategory::find()->select(['id', 'name'])->all();
        $category = ArrayHelper::map($category, 'id', 'name');

        $company = Company::find()->select(['user_id', 'organizationName'])->all();
        $company = ArrayHelper::map($company, 'user_id', 'organizationName');

        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = date('Y-m-d H:i:s');
            $model->image = json_encode($model->image);
            $model->save(false);

            return $this->redirect(['update', 'id' => $model->id]);
        }
        $model->image = json_decode($model->image);

        return $this->render('create', [
            'model' => $model,
            'category' => $category,
            'company' => $company
        ]);
    }

    /**
     * Updates an existing Vacancies model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $category = VacanciesCategory::find()->select(['id', 'name'])->all();
        $category = ArrayHelper::map($category, 'id', 'name');

        $company = Company::find()->select(['user_id', 'organizationName'])->all();
        $company = ArrayHelper::map($company, 'user_id', 'organizationName');

        if ($model->load(Yii::$app->request->post())) {
            $model->image = json_encode($model->image);
            $model->updated_at = date('Y-m-d H:i:s');
            $model->save(false);

            return $this->redirect(['update', 'id' => $model->id]);
        }
        $model->image = json_decode($model->image);

        return $this->render('update', [
            'model' => $model,
            'category' => $category,
            'company' => $company
        ]);
    }

    /**
     * Deletes an existing Vacancies model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Vacancies model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Vacancies the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vacancies::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

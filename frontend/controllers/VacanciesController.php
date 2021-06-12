<?php

namespace frontend\controllers;

use common\models\Company;
use common\models\KeyStorageItem;
use common\models\Likes;
use common\models\Vacancies;
use common\models\VacanciesCategory;
use common\models\VacanciesUsers;
use Yii;

class VacanciesController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        \Yii::$app->params['body'] = 'content-page';
        $vacancies = Vacancies::find()->where(['is_active' => 1, 'is_approved' => 1])->orderBy('created_at desc')->all();
        $vacanciesCategory = VacanciesCategory::find()->select(['id', 'name'])->all();
        $model = KeyStorageItem::find()->where(['key' => 'banner'])->one();
        $banner = json_decode($model->value, true);

        return $this->render('index', ['vacancies' => $vacancies, 'vacanciesCategory' => $vacanciesCategory, 'banner' => $banner]);
    }

    public function actionLike()
    {
        if (\Yii::$app->user->isGuest) return;
        $id = $_POST['id'];
        $res = Likes::find()->where(['user_id' => \Yii::$app->user->id, 'object_id' => $id, 'object_type' => 4])->one();
        if ($res) {
            $res->delete();
        } else {
            $like = new Likes();
            $like->user_id = \Yii::$app->user->id;
            $like->object_id = $id;
            $like->object_type = 4;
            $like->save(false);
        }
        $res = Likes::find()->where(['object_id' => $id, 'object_type' => 4])->count();

        exit(json_encode(['likes' => $res]));
    }

    public function actionSubmit()
    {
        $id = $_POST['id'];
        $res = VacanciesUsers::find()->where(['user_id' => \Yii::$app->user->id, 'vacancies_id' => $id])->one();
        if ($res) {
            $res->delete();
            exit(json_encode(['text' => 'Отправить отклик']));
        } else {
            $like = new VacanciesUsers();
            $like->user_id = \Yii::$app->user->id;
            $like->vacancies_id = $id;
            $like->save(false);
            exit(json_encode(['text' => 'Отказаться']));
        }

    }

    public function actionPage($company, $id)
    {
        $company = Company::find()->where(['slug' => $company])->one();

        if ($company) {
            $vacancy = Vacancies::findOne($id);
            if (!$vacancy) throw new \yii\web\NotFoundHttpException();

            Yii::$app->params['og']['title'] = $vacancy->title;
            Yii::$app->params['og']['image'] = $vacancy->image;
            Yii::$app->params['og']['description'] = $vacancy->excerpt;
            Yii::$app->params['og']['url'] = \Yii::getAlias('@frontendUrl') . '/vacancies/' . $vacancy->slug;

            \Yii::$app->params['body'] = 'content-page-single';
            $vacancies = Vacancies::find()->where(['is_active' => 1, 'is_approved' => 1])->andWhere(['NOT IN', 'id', [$vacancy->id]])->limit(3)->orderBy('created_at desc')->all();

            $is_active = VacanciesUsers::find()->where(['user_id' => \Yii::$app->user->id, 'vacancies_id' => $vacancy->id])->one();
            return $this->render('page', ['vacancy' => $vacancy, 'vacancies' => $vacancies, 'is_active' => $is_active]);
        } else {
            throw new \yii\web\NotFoundHttpException();
        }

    }

    public function actionSort()
    {
        $vacancies = Vacancies::find()->where(['is_active' => 1, 'is_approved' => 1]);
        $is_like = false;
        if ($_POST['sort'] == 'like') {
            $is_like = true;
            $vacancies = Vacancies::find()
                ->select(['vacancies.*', 'count(likes.id) as likes'])
                ->leftJoin('likes', 'likes.object_id = vacancies.id')
                ->where(['vacancies.is_active' => 1, 'vacancies.is_approved' => 1]);
            if ($_POST['company_id']) {
                $vacancies = $vacancies->andWhere(['vacancies.company_id' => $_POST['company_id']]);
            }
            $vacancies = $vacancies->andWhere(['likes.object_type' => 4])
                ->groupBy('vacancies.id')
                ->orderBy('likes desc')
                ->all();
        } elseif ($_POST['sort'] == 'category') {
            $vacancies = $vacancies->andWhere(['category_id' => $_POST['category']]);
        }

        if ($_POST['sort'] == 'online') {
            if ($_POST['val'] == 'false') {
                $vacancies->andWhere(['is_online' => 1]);
            }
        }

        if ($_POST['company_id'] && !$is_like) {
            $vacancies = $vacancies->andWhere(['company_id' => $_POST['company_id']]);
        }

        if (!$is_like) {
            $vacancies = $vacancies->orderBy('created_at desc');
            if ($_POST['is_main']) {
                $vacancies = $vacancies->limit(6);
            }
            $vacancies = $vacancies->all();
        }

        if ($vacancies) {
            $html = '';
            foreach ($vacancies as $key => $item) {
                $html .= $this->renderPartial('item', ['item' => $item]);
            }
        }
        return $html;
    }

}

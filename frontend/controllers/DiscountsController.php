<?php

namespace frontend\controllers;

use common\models\Company;
use common\models\Discounts;
use common\models\DiscountsCategory;
use common\models\DiscountsUsers;
use common\models\KeyStorageItem;
use common\models\Likes;
use Yii;

class DiscountsController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        \Yii::$app->params['body'] = 'content-page';
        $discounts = Discounts::find()->where(['is_active' => 1, 'is_approved' => 1])->orderBy('created_at desc')->all();
        $discountsCategory = DiscountsCategory::find()->select(['id', 'name'])->all();
        $model = KeyStorageItem::find()->where(['key' => 'banner'])->one();
        $banner = json_decode($model->value, true);

        return $this->render('index', ['discounts' => $discounts, 'discountsCategory' => $discountsCategory, 'banner' => $banner]);
    }

    public function actionLike()
    {
        if (\Yii::$app->user->isGuest) return;
        $id = $_POST['id'];
        $res = Likes::find()->where(['user_id' => \Yii::$app->user->id, 'object_id' => $id, 'object_type' => 3])->one();
        if ($res) {
            $res->delete();
        } else {
            $like = new Likes();
            $like->user_id = \Yii::$app->user->id;
            $like->object_id = $id;
            $like->object_type = 3;
            $like->save(false);
        }
        $res = Likes::find()->where(['object_id' => $id, 'object_type' => 3])->count();

        exit(json_encode(['likes' => $res]));
    }

    public function actionSubmit()
    {
        $id = $_POST['id'];
        $res = DiscountsUsers::find()->where(['user_id' => \Yii::$app->user->id, 'discounts_id' => $id])->one();
        if ($res) {
            $res->delete();
            exit(json_encode(['text' => 'Учавствовать']));
        } else {
            $like = new DiscountsUsers();
            $like->user_id = \Yii::$app->user->id;
            $like->discounts_id = $id;
            $like->save(false);
            exit(json_encode(['text' => 'Отказаться']));
        }

    }

    public function actionPage($company, $id)
    {
        $company = Company::find()->where(['slug' => $company])->one();

        if ($company) {
            $discount = Discounts::findOne($id);
            if (!$discount) throw new \yii\web\NotFoundHttpException();

            Yii::$app->params['og']['title'] = $discount->title;
            Yii::$app->params['og']['image'] = $discount->image;
            Yii::$app->params['og']['description'] = $discount->excerpt;
            Yii::$app->params['og']['url'] = \Yii::getAlias('@frontendUrl') . '/discounts/' . $discount->slug;

            \Yii::$app->params['body'] = 'content-page-single';
            $discounts = Discounts::find()->where(['is_active' => 1, 'is_approved' => 1])->andWhere(['NOT IN', 'id', [$discount->id]])->limit(3)->orderBy('created_at desc')->all();

            $is_active = DiscountsUsers::find()->where(['user_id' => \Yii::$app->user->id, 'discounts_id' => $discount->id])->one();
            return $this->render('page', ['discount' => $discount, 'discounts' => $discounts, 'is_active' => $is_active]);
        } else {
            throw new \yii\web\NotFoundHttpException();
        }

    }

    public function actionSort()
    {
        $is_like = false;
        $discounts = Discounts::find()->where(['is_active' => 1, 'is_approved' => 1]);

        if ($_POST['sort'] == 'like') {
            $is_like = true;
            $discounts = Discounts::find()
                ->select(['discounts.*', 'count(likes.id) as likes'])
                ->leftJoin('likes', 'likes.object_id = discounts.id')
                ->where(['discounts.is_active' => 1, 'discounts.is_approved' => 1]);
            if ($_POST['company_id']) {
                $discounts = $discounts->andWhere(['discounts.company_id' => $_POST['company_id']]);
            }
            $discounts = $discounts->andWhere(['likes.object_type' => 3])
                ->groupBy('discounts.id')
                ->orderBy('likes desc')
                ->all();
        } elseif ($_POST['sort'] == 'category') {
            $discounts = $discounts->andWhere(['category_id' => $_POST['category']]);
        }

        if ($_POST['sort'] == 'online') {
            if ($_POST['val'] == 'false') {
                $discounts->andWhere(['is_online' => 1]);
            }
        }

        if ($_POST['company_id'] && !$is_like) {
            $discounts = $discounts->andWhere(['company_id' => $_POST['company_id']]);
        }

        if (!$is_like) {
            $discounts = $discounts->orderBy('created_at desc');
            if ($_POST['is_main']) {
                $discounts = $discounts->limit(6);
            }
            $discounts = $discounts->all();
        }


        if ($discounts) {
            $html = '';
            foreach ($discounts as $key => $item) {
                $html .= $this->renderPartial('item', ['item' => $item]);
            }
        }
        return $html;
    }

}

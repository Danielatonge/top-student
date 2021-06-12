<?php

namespace frontend\controllers;

use common\models\Company;
use common\models\KeyStorageItem;
use common\models\Likes;
use common\models\News;
use common\models\NewsCategory;
use Yii;

class NewsController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        \Yii::$app->params['body'] = 'content-page';
        $news = News::find()->where(['is_active' => 1, 'is_approved' => 1])->orderBy('created_at desc')->all();
        $newsCategory = NewsCategory::find()->select(['id', 'name'])->all();

        $gallery = KeyStorageItem::find()->where(['key' => 'gallery'])->one();
        $gallery = json_decode($gallery->value, true);

        $video_gallery = KeyStorageItem::find()->where(['key' => 'video_gallery'])->one();
        $video_gallery = json_decode($video_gallery->value, true);
        $model = KeyStorageItem::find()->where(['key' => 'banner'])->one();
        $banner = json_decode($model->value, true);
        return $this->render('index', ['news' => $news, 'newsCategory' => $newsCategory, 'banner' => $banner, 'gallery' => $gallery, 'video_gallery' => $video_gallery]);
    }

    public function actionLike()
    {
        if (\Yii::$app->user->isGuest) return;
        $id = $_POST['id'];
        $res = Likes::find()->where(['user_id' => \Yii::$app->user->id, 'object_id' => $id, 'object_type' => 1])->one();
        if ($res) {
            $res->delete();
        } else {
            $like = new Likes();
            $like->user_id = \Yii::$app->user->id;
            $like->object_id = $id;
            $like->object_type = 1;
            $like->save(false);
        }
        $res = Likes::find()->where(['object_id' => $id, 'object_type' => 1])->count();

        exit(json_encode(['likes' => $res]));
    }


    public function actionPage($company, $id)
    {
        $company = Company::find()->where(['slug' => $company])->one();

        if ($company) {
            $new = News::findOne($id);
            if (!$new) throw new \yii\web\NotFoundHttpException();

            Yii::$app->params['og']['title'] = $new->title;
            Yii::$app->params['og']['image'] = $new->image;
            Yii::$app->params['og']['description'] = $new->excerpt;
            Yii::$app->params['og']['url'] = \Yii::getAlias('@frontendUrl') . '/news/' . $new->slug;

            \Yii::$app->params['body'] = 'content-page-single';
            $news = News::find()->where(['is_active' => 1, 'is_approved' => 1])->andWhere(['NOT IN', 'id', [$new->id]])->limit(3)->orderBy('created_at desc')->all();

            return $this->render('page', ['new' => $new, 'news' => $news]);
        } else {
            throw new \yii\web\NotFoundHttpException();
        }

    }

    public function actionSort()
    {
        $is_like = false;
        $news = News::find()->where(['is_active' => 1, 'is_approved' => 1]);

        if ($_POST['sort'] == 'like') {
            $is_like = true;
            $news = News::find()
                ->select(['news.*', 'count(likes.id) as likes'])
                ->leftJoin('likes', 'likes.object_id = news.id')
                ->where(['news.is_active' => 1, 'news.is_approved' => 1]);
            if ($_POST['company_id']) {
                $news = $news->andWhere(['news.company_id' => $_POST['company_id']]);
            }
            $news = $news->andWhere(['likes.object_type' => 1])
                ->groupBy('news.id')
                ->orderBy('likes desc')
                ->all();
        } elseif ($_POST['sort'] == 'category') {
            $news = $news->andWhere(['category_id' => $_POST['category']]);
        }

        if ($_POST['company_id'] && !$is_like) {
            $news = $news->andWhere(['company_id' => $_POST['company_id']]);
        }

        if (!$is_like) {
            $news = $news->orderBy('created_at desc');
            if ($_POST['is_main']) {
                $news = $news->limit(6);
            }
            $news = $news->all();
        }

        if ($news) {
            $html = '';
            foreach ($news as $key => $item) {
                $html .= $this->renderPartial('item', ['item' => $item]);
            }
        }
        return $html;
    }

}

<?php

namespace frontend\controllers;

use common\models\Company;
use common\models\Events;
use common\models\EventsCategory;
use common\models\EventsUsers;
use common\models\KeyStorageItem;
use common\models\Likes;
use Yii;

class EventsController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        \Yii::$app->params['body'] = 'content-page';
        $date = date('Y-m-d');
        $events = Events::find()->where(['is_active' => 1, 'is_approve' => 1, 'closed' => 0])->andWhere(['>=', 'date_start', $date])->orderBy('date_start asc')->all();
        $eventsCategory = EventsCategory::find()->select(['id', 'name'])->orderby('order asc')->all();
        $model = KeyStorageItem::find()->where(['key' => 'banner'])->one();
        $banner = json_decode($model->value, true);

        return $this->render('index', ['events' => $events, 'eventsCategory' => $eventsCategory, 'banner' => $banner]);
    }

    public function actionLike()
    {
        if (\Yii::$app->user->isGuest) return;
        $id = $_POST['id'];
        $res = Likes::find()->where(['user_id' => \Yii::$app->user->id, 'object_id' => $id, 'object_type' => 2])->one();
        if ($res) {
            $res->delete();
        } else {
            $like = new Likes();
            $like->user_id = \Yii::$app->user->id;
            $like->object_id = $id;
            $like->object_type = 2;
            $like->save(false);
        }
        $res = Likes::find()->where(['object_id' => $id, 'object_type' => 2])->count();

        exit(json_encode(['likes' => $res]));
    }

    public function actionSubmit()
    {
        $id = $_POST['id'];
        $res = EventsUsers::find()->where(['user_id' => \Yii::$app->user->id, 'event_id' => $id])->one();
        if ($res) {
            $res->delete();
            exit(json_encode(['text' => 'Учавствовать']));
        } else {
            $like = new EventsUsers();
            $like->user_id = \Yii::$app->user->id;
            $like->event_id = $id;
            $like->save(false);
            exit(json_encode(['text' => 'Отказаться']));
        }

    }

    public function actionPage($company, $id)
    {
        $company = Company::find()->where(['slug' => $company])->one();

        if ($company) {
            $event = Events::findOne($id);
            if (!$event) throw new \yii\web\NotFoundHttpException();
            Yii::$app->params['og']['title'] = $event->title;
            Yii::$app->params['og']['image'] = $event->image;
            Yii::$app->params['og']['description'] = $event->excerpt;
            Yii::$app->params['og']['url'] = \Yii::getAlias('@frontendUrl') . '/events/' . $event->slug;

            \Yii::$app->params['body'] = 'content-page-single';
            $events = Events::find()->where(['is_active' => 1, 'is_approve' => 1, 'closed' => 0])->andWhere(['NOT IN', 'id', [$event->id]])->limit(3)->orderBy('created_at desc')->all();

            $is_active = EventsUsers::find()->where(['user_id' => \Yii::$app->user->id, 'event_id' => $event->id])->one();
            return $this->render('page', ['event' => $event, 'events' => $events, 'is_active' => $is_active]);
        } else {
            throw new \yii\web\NotFoundHttpException();
        }

    }

    public function actionSort()
    {
        $date = date('Y-m-d');
        $is_like = false;
        $events = Events::find()->where(['is_active' => 1, 'is_approve' => 1, 'closed' => 0])->andWhere(['>=', 'date_start', $date]);

        if ($_POST['sort'] == 'like') {
            $is_like = true;
            $events = Events::find()
                ->select(['events.*', 'count(likes.id) as likes'])
                ->leftJoin('likes', 'likes.object_id = events.id')
                ->where(['events.is_active' => 1, 'events.is_approve' => 1, 'events.closed' => 0, 'events.closed_registration' => 0])
                ->andWhere(['likes.object_type' => 2])
                ->andWhere(['>=', 'events.date_start', $date]);
            if ($_POST['company_id']) {
                $events->andWhere(['events.company_id' => $_POST['company_id']]);
            }
            $events = $events->groupBy('events.id')
                ->orderBy('likes desc')
                ->all();
        }  elseif ($_POST['sort'] == 'category') {
            $events->andWhere(['category_id' => $_POST['category']]);
        }

       if ($_POST['sort'] == 'online') {
            if ($_POST['val'] == 'false') {
                $events->andWhere(['is_online' => 1]);
            }
        }

        if ($_POST['company_id'] && !$is_like) {
            $events->andWhere(['company_id' => $_POST['company_id']]);
        }
        
        if (!$is_like) {
           $events->orderBy('date_start asc');
            if ($_POST['is_main']) {
               $events->limit(6);
            }
            $events = $events->all();
        }

        if ($events) {
            $html = '';
            foreach ($events as $key => $item) {
                $html .= $this->renderPartial('item', ['item' => $item]);
            }
        }

        return $html;
    }

}

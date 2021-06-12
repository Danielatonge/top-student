<?php

namespace backend\controllers;

use common\models\Student;
use common\models\Emails;
use Yii;
use common\models\KeyStorageItem;
/**
 * Site controller
 */
class SiteController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->layout = Yii::$app->user->isGuest || !Yii::$app->user->can('loginToBackend') ? 'base' : 'common';

        return parent::beforeAction($action);
    }

    public function actionPartners()
    {
        $model  =  KeyStorageItem::find()->where(['key' => 'card-banner'])->one();
        if (!$model) {
            $model = new KeyStorageItem();
            $model->key = 'card-banner';
            $model->value = '';
            $model->save(false);
        }

        if ($_POST) {
            $model->value = json_encode($_POST['DynamicModel']);
            $model->save(false);
        }

        $data = json_decode($model->value);
//        echo '<pre>';
//        print_r($data);
//        echo '</pre>';
//        exit();
        return $this->render('partner', ['model' => $model, 'data' => $data]);
    }
    public function actionBanner()
    {
        $model  =  KeyStorageItem::find()->where(['key' => 'banner'])->one();
        if (!$model) {
            $model = new KeyStorageItem();
            $model->key = 'banner';
            $model->value = '';
            $model->save(false);
        }

        if ($_POST) {
            $model->value = json_encode($_POST['DynamicModel']);
            $model->save(false);
        }

        $data = json_decode($model->value);
//        echo '<pre>';
//        print_r($data);
//        echo '</pre>';
//        exit();
        return $this->render('banner', ['model' => $model, 'data' => $data]);
    }
    public function actionAbout()
    {
        $model  =  KeyStorageItem::find()->where(['key' => 'about'])->one();

        if ($_POST) {
            $model->value = json_encode($_POST['DynamicModel']);
            $model->save(false);
        }

        $data = json_decode($model->value);

        return $this->render('about', ['model' => $model, 'data' => $data]);
    }

    public function actionSeo()
    {
        $seo = KeyStorageItem::find()->where(['key' => 'app.seo'])->one();

        if ($_POST) {
            $_seo = $_POST['Seo'];

            $seo->value = json_encode($_seo);
            $seo->save(false);
        }

        return $this->render('seo', ['seo' => json_decode($seo->value),]);
    }

    public function actionGallery()
    {
        $model  =  KeyStorageItem::find()->where(['key' => 'gallery'])->one();

        if ($_POST) {
            $model->value = json_encode($_POST['DynamicModel']);
            $model->save(false);
        }

        $data = json_decode($model->value);

        return $this->render('gallery', ['model' => $model, 'data' => $data]);
    }

    public function actionVideoGallery()
    {
        $model  =  KeyStorageItem::find()->where(['key' => 'video_gallery'])->one();

        if ($_POST) {
            $model->value = json_encode($_POST['DynamicModel']);
            $model->save(false);
        }

        $data = json_decode($model->value);

        return $this->render('video_gallery', ['model' => $model, 'data' => $data]);
    }

    public function actionExport()
    {
        $emails = Emails::find()->select('email')->asArray()->all();
        if ($emails) {
            $f = fopen('php://memory', 'w');
            foreach ($emails as $key => $item) {
                fputcsv($f, $item, ';');
            }
            fseek($f, 0);
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename="subscribers_topstudents.csv";');
            fpassthru($f);
            exit();
        } else {
            $this->redirect('/');
        }
    }
}

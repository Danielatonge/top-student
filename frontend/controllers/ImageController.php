<?php

namespace frontend\controllers;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ImageController extends \yii\web\Controller
{
    public function actionIndex($path)
    {
        $response = \Yii::$app->response;
        $response->format = Response::FORMAT_RAW;
        $response->headers->set('Content-Type', 'image/jpeg');
        $path = str_replace('', '', '1/'. $path);
        $full_path = \Yii::getAlias('@storage'). '/web/source/' . $path;
        if (file_exists($full_path)) {
            $crop = $_GET['crop'] ? $_GET['crop'] : 'crop-center';
            $blur = $_GET['blur'] ? $_GET['blur'] : 0;
            $q = $_GET['q'] ? $_GET['q'] : 90;

            \Yii::$app->glide->outputImage($path, ['w' => $_GET['w'], 'h' => $_GET['h'], 'fm' => 'jpg', 'blur' => $blur, 'q' => $q, 'fit' => $crop]);
            die();
        } else {
            \Yii::$app->response->statusCode = 404;
            return;
        }
    }

}

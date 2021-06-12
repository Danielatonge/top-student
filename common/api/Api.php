<?php

namespace common\api;

use backend\models\Logs;
use common\models\User;

class Api
{
    private $method;
    private $body;
    private $headers;

    public function __construct($body, $headers, $method = false)
    {
        $this->body = $body;
        $this->method = $method;
        $this->headers = $headers;
    }

    public function getUserByToken($token)
    {
        return User::find()->where(['access_token' => $token])->one();
    }

    public function getUserByLogin($login)
    {
        return User::find()->where(['username' => $login])->one();
    }

    public function getBody()
    {
        $body = json_decode($this->body, true);
        if (!$body) {
            exit(json_encode($this->error('422', ['message' => 'Empty or not valid json'])));
        }

        return $body;
    }

    public function vkData($token)
    {
        if (isset($token['access_token'])) {
            $params = array(
                'uids' => $token['user_id'],
                'fields' => 'email',
                'access_token' => $token['access_token'],
                'v' => '5.59'
            );
        }
        $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);

        $vk_id = $userInfo['response'][0]['id'];
        $vk_name = $userInfo['response'][0]['first_name'];
        $vk_surname = $userInfo['response'][0]['last_name'];
        if (!$vk_id) {
            return redirect('/');
        }
        $user = User::find()->where(['vk_id' => $vk_id])->one();
        if (!$user) {
            $user = \Yii::$app->account->createUserModel([
                'type' => 2,
                'name' => $vk_name,
                'surname' => $vk_surname,
                'username' => Inflector::slug($vk_name . '_' . $vk_surname),
                'email' => Inflector::slug($vk_name . '_' . $vk_surname),
                'vk_id' => $vk_id,
                'password' => rand(1111111, 9999999),

            ]);
        }

        return $user->email;
    }

    public function fbData($token)
    {

        return $user;
    }


    private function checkNumericInArray($data)
    {
        foreach ($data as $key => $item) {
            if (is_numeric($item)) {
                $data[$key] = (float)$item;
            } elseif (is_string($item)) {
                $data[$key] = nl2br($item);
//                    $data[$key] = preg_replace('~[\r\n]+~', '',  $data[$key]);
                $data[$key] = str_replace(array("\r\n", "\r"), '', $data[$key]);;
            }
            if (is_array($item)) {
                $data[$key] = $this->checkNumericInArray($item);
            }
        }
        return $data;
    }

    public function response($statusCode, $data)
    {
        if ($data) {
            foreach ($data as $key => $item) {
                if ($key == 'phone' || $key == 'status') continue;
                if (is_numeric($item)) {
                    $data[$key] = (float)$item;
                } elseif (is_string($item)) {
                    $data[$key] = nl2br($item);
//                    $data[$key] = preg_replace('~[\r\n]+~', '',  $data[$key]);
                    $data[$key] = str_replace(array("\r\n", "\r"), '', $data[$key]);;
                }

                if (is_array($item)) {
                    $data[$key] = $this->checkNumericInArray($item);
                }
            }
        }

        \Yii::$app->response->statusCode = $statusCode;

        $this->log([
            'status_code' => (int)$statusCode,
            'url' => (string)(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
            'response' => json_encode($data),
            'body' => json_encode($this->body),
            'headers' => json_encode($this->headers),
            'method' => $this->method
        ]);
        return $data;
    }

    private function log($params)
    {
        $log = new Logs();

        $log->status_code = $params['status_code'];
        $log->url = $params['url'];
        $log->response = $params['response'];
        $log->body = $params['body'];
        $log->headers = $params['headers'];
        $log->method = $params['method'];
        $log->token = $_GET['token'];

        $log->save(false);
    }


    private function error($statusCode, $params = array())
    {
        \Yii::$app->response->statusCode = $statusCode;

        $this->log([
            'status_code' => (int)$statusCode,
            'url' => (string)(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
            'response' => json_encode($params),
            'body' => json_encode($this->body),
            'headers' => json_encode($this->headers),
            'method' => $this->method
        ]);

        return ['error' => $params];

    }


    public function load($model, $body)
    {
        if ($body) {
            foreach ($body as $key => $item) {
                if ($model->hasAttribute($key)) {
                    $model->{$key} = $item;
                }
            }
        }

        return $model;
    }
}

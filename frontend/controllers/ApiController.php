<?php

namespace frontend\controllers;

use common\api\Api;
use common\api\DiscountsApi;
use common\api\EventsApi;
use common\api\UserApi;
use common\api\VacanciesApi;
use common\api\NewsApi;
use common\models\Company;
use common\models\Discounts;
use common\models\Events;
use common\models\Likes;
use common\models\Student;
use common\models\User;
use common\models\UserToken;
use Yii;
use yii\web\Response;


class ApiController extends \yii\web\Controller
{
    private $api;
    private $body;
    private $method;
    protected $user;
    protected $user_model;
    public $events;
    public $vacancies;
    public $news;
    public $discounts;
    private $token;

    public function beforeAction($action)
    {
        $headers = Yii::$app->request->headers;
        $this->enableCsrfValidation = false;
        $this->token = $_REQUEST['token'];
        $this->method = \Yii::$app->request->method;
        $this->body = json_decode(file_get_contents('php://input'), true);
        $this->api = new Api($this->body, $_SERVER, $this->method);
        $this->user = $this->api->getUserByToken($this->token);
        $this->user_model = new UserApi();
        $this->events = new EventsApi($this->user);
        $this->vacancies = new VacanciesApi($this->user);
        $this->news = new NewsApi($this->user);
        $this->discounts = new DiscountsApi($this->user);

        if (Yii::$app->getRequest()->getMethod() === 'OPTIONS') {
            Yii::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Origin', '*');
            Yii::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Methods', 'GET,DELETE,HEAD,OPTIONS,POST,PUT');
            Yii::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Headers', '*');
            Yii::$app->response->statusCode = 204;
            Yii::$app->end();
        } else {
            \Yii::$app->response->format = Response::FORMAT_JSON;
        }

        return parent::beforeAction($action);
    }

    public function actionLike()
    {
        if ($this->checkMethod('Post')) {
            if (!$user = $this->api->getUserByToken($this->token)) return $this->api->response('403', ['token' => 'Token not valid']);
            $like = Likes::find()
                ->where(['user_id' => $this->user->id, 'object_id' => $this->body['object_id'], 'object_type' => $this->body['object_type']])->one();
            if ($this->body['type'] && !$like) {
                $like = new Likes();

                $like->user_id = (int)$this->user->id;
                $like->object_type = (int)$this->body['object_type'] ? $this->body['object_type'] : '';
                $like->object_id = (int)$this->body['object_id'] ? $this->body['object_id'] : '';
                if (!$like->validate()) {
                    $error = $like->getErrors();
                    if ($error) return $this->api->response('422', ['status' => 'error', 'message' => $error]);
                }
                $like->save(false);
            } else {
                if ($like) {
                    $like->delete();
                }
            }
            return $this->api->response('201', ['status' => 'success']);
        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }
    }

    public function actionEvents()
    {
        if ($this->checkMethod('Get')) {
            if (!$user = $this->api->getUserByToken($this->token)) return $this->api->response('403', ['token' => 'Token not valid']);
            $response = $this->events->getEvents($this->user, $_GET);

            return $this->api->response('200', ['status' => 'success', 'data' => $response]);
        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }
    }

    public function actionEventOne($id)
    {
        if ($this->checkMethod('Get')) {
            if (!$user = $this->api->getUserByToken($this->token)) return $this->api->response('403', ['token' => 'Token not valid']);
            $response = $this->events->getEventOne($this->user, $id);
            $code = $response ? '200' : '404';
            $status = $response ? 'success' : 'not found';
            return $this->api->response($code, ['status' => $status, 'data' => $response]);
        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }
    }

    public function actionDiscountsOne($id)
    {
        if ($this->checkMethod('Get')) {
            if (!$user = $this->api->getUserByToken($this->token)) return $this->api->response('403', ['token' => 'Token not valid']);
            $response = $this->discounts->getOne($this->user, $id);
            $code = $response ? '200' : '404';
            $status = $response ? 'success' : 'not found';
            return $this->api->response($code, ['status' => $status, 'data' => $response]);
        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }
    }

    public function actionVacanciesOne($id)
    {
        if ($this->checkMethod('Get')) {
            if (!$user = $this->api->getUserByToken($this->token)) return $this->api->response('403', ['token' => 'Token not valid']);
            $response = $this->vacancies->getOne($this->user, $id);
            $code = $response ? '200' : '404';
            $status = $response ? 'success' : 'not found';
            return $this->api->response($code, ['status' => $status, 'data' => $response]);
        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }
    }

    public function actionNewsOne($id)
    {
        if ($this->checkMethod('Get')) {
            if (!$user = $this->api->getUserByToken($this->token)) return $this->api->response('403', ['token' => 'Token not valid']);
            $response = $this->news->getOne($this->user, $id);
            $code = $response ? '200' : '404';
            $status = $response ? 'success' : 'not found';
            return $this->api->response($code, ['status' => $status, 'data' => $response]);
        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }
    }


    public function actionEventsAdd()
    {
        if ($this->checkMethod('Post')) {
            if (!$user = $this->api->getUserByToken($this->token)) return $this->api->response('403', ['token' => 'Token not valid']);
            if (!$this->body['event_id']) return $this->api->response('422', ['id' => 'event_id  - required']);
           $response = $this->events->join($this->body);

            return $this->api->response('201', ['status' => 'success', 'response' => $response]);
        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }
    }

    public function actionVacanciesAdd()
    {
        if ($this->checkMethod('Post')) {
            if (!$user = $this->api->getUserByToken($this->token)) return $this->api->response('403', ['token' => 'Token not valid']);
            if (!$this->body['vacancy_id']) return $this->api->response('422', ['id' => 'vacancy_id - required']);
            $response = $this->vacancies->join($this->body);

            return $this->api->response('201', ['status' => 'success', 'response' => $response]);
        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }
    }

    public function actionVacancies()
    {
        if ($this->checkMethod('Get')) {
            if (!$user = $this->api->getUserByToken($this->token)) return $this->api->response('403', ['token' => 'Token not valid']);
            $response = $this->vacancies->getVacancies($this->user, $_GET);

            return $this->api->response('201', ['status' => 'success', 'data' => $response]);
        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }
    }

    public function actionNews()
    {
        if ($this->checkMethod('Get')) {
            if (!$user = $this->api->getUserByToken($this->token)) return $this->api->response('403', ['token' => 'Token not valid']);
            $response = $this->news->getNews($this->user, $_GET);

            return $this->api->response('201', ['status' => 'success', 'data' => $response]);
        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }
    }

    public function actionRemoveEvent()
    {
        if ($this->checkMethod('Post')) {
            if (!$user = $this->api->getUserByToken($this->token)) return $this->api->response('403', ['token' => 'Token not valid']);
            if (!$this->body['id']) return $this->api->response('422', ['id' => 'id - required']);
            $event = Events::findOne($this->body['id']);
            if (!$event) $this->api->response('404', ['error' => 'Event not found']);
            $event->is_active = 0;
            $event->save(false);

            return $this->api->response('201', ['status' => 'success']);
        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }
    }

    public function actionUserEdit()
    {
        if ($this->checkMethod('Post')) {
            if (!$user = $this->api->getUserByToken($this->token)) return $this->api->response('403', ['token' => 'Token not valid']);
            $user_modal = $user->type == 1 ? Company::find()->where(['user_id' => $user->id])->one() : Student::find()->where(['user_id' => $user->id])->one();
            if ($this->body) {
                foreach ($this->body as $key => $item) {
                    if ($user_modal->hasAttribute($key)) {
                        $user_modal->{$key} = $item;
                    }
                }
            }
            if (!$user_modal->validate()) {
                $error = $user_modal->getErrors();
                return $this->api->response('422', $error);
            }
            $user_modal->save(false);

            unset($user_modal->user_id);
            $user_modal->id = $user->id;


            return $this->api->response('201', ['status' => 'success', 'object' => $user_modal]);
        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }
    }

    public function actionRemoveDiscount()
    {
        if ($this->checkMethod('Post')) {
            if (!$user = $this->api->getUserByToken($this->token)) return $this->api->response('403', ['token' => 'Token not valid']);
            if (!$this->body['id']) return $this->api->response('422', ['id' => 'id - required']);
            $discount = Discounts::findOne($this->body['id']);
            if (!$discount) $this->api->response('404', ['error' => 'Event not found']);
            $discount->is_active = 0;
            $discount->save(false);

            return $this->api->response('201', ['status' => 'success']);
        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }
    }


    public function actionDiscounts()
    {
        if ($this->checkMethod('Get')) {
            if (!$user = $this->api->getUserByToken($this->token)) return $this->api->response('404', ['token' => 'Token not valid']);
            $response = $this->discounts->getDiscounts($this->user, $_GET);

            return $this->api->response('201', ['status' => 'success', 'data' => $response]);
        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }
    }

    public function actionEventsCategory()
    {
        if ($this->checkMethod('Get')) {
            if (!$user = $this->api->getUserByToken($this->token)) return $this->api->response('404', ['token' => 'Token not valid']);
            $response = $this->events->getEventsCategory();

            return $this->api->response('201', ['status' => 'success', 'data' => $response]);
        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }
    }

    public function actionVacanciesCategory()
    {
        if ($this->checkMethod('Get')) {
            if (!$user = $this->api->getUserByToken($this->token)) return $this->api->response('404', ['token' => 'Token not valid']);
            $response = $this->vacancies->getVacanciesCategory();

            return $this->api->response('201', ['status' => 'success', 'data' => $response]);
        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }
    }

    public function actionNewsCategory()
    {
        if ($this->checkMethod('Get')) {
            if (!$user = $this->api->getUserByToken($this->token)) return $this->api->response('404', ['token' => 'Token not valid']);
            $response = $this->news->getNewsCategory();

            return $this->api->response('201', ['status' => 'success', 'data' => $response]);
        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }
    }


    public function actionDiscountsCategory()
    {
        if ($this->checkMethod('Get')) {
            if (!$user = $this->api->getUserByToken($this->token)) return $this->api->response('404', ['token' => 'Token not valid']);
            $response = $this->discounts->getDiscountsCategory();

            return $this->api->response('201', ['status' => 'success', 'data' => $response]);
        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }
    }

    public function actionCreateEvent()
    {
        if ($this->checkMethod('Post')) {
            if (!$user = $this->api->getUserByToken($this->token)) return $this->api->response('404', ['token' => 'Token not valid']);
            $response = $this->events->createEvent($this->body);
            if ($response['error']) return $this->api->response('422', ['status' => 'error', 'message' => $response['error']]);

            return $this->api->response('201', ['status' => 'success', 'data' => $response]);
        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }
    }

    public function actionCreateDiscount()
    {
        if ($this->checkMethod('Post')) {
            if (!$user = $this->api->getUserByToken($this->token)) return $this->api->response('404', ['token' => 'Token not valid']);
            $response = $this->discounts->createDiscount($this->body);
            if ($response['error']) return $this->api->response('422', ['status' => 'error', 'message' => $response['error']]);

            return $this->api->response('201', ['status' => 'success', 'data' => $response]);
        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }
    }

    public function actionRestorePassword()
    {
        if ($this->checkMethod('Post')) {
            $body = $this->body;
            if (!$user = $this->api->getUserByLogin($body['email'])) return $this->api->response('404', ['token' => 'Token not valid']);
            UserToken::deleteAll(['user_id' => $user->id]);
            $reset_token = UserToken::create($user->id, 'reset_password', 1 * 60 * 60);

            \Yii::$app->email->restorePassword($user, $reset_token);

            return $this->api->response('201', ['status' => 'success', 'code' => $reset_token->token]);
        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }
    }

    public function actionSetPassword()
    {
        if ($this->checkMethod('Post')) {
            $body = $this->body;

            if (!$user = $this->api->getUserByLogin($body['email'])) return $this->api->response('404', ['token' => 'Token not valid']);
            if (!$body['password'] || !$body['code']) return $this->api->response('422', ['error' => 'New password and code required']);

            if (!$reset_token = UserToken::use($body['code'], 'reset_password', $user->id)) return $this->api->response('422', ['code' => 'Token expired or out of date']);
            UserToken::deleteAll(['user_id' => $user->id]);

            $user->password_hash = Yii::$app->getSecurity()->generatePasswordHash($body['password']);
            $user->access_token = md5(sha1($body['login'] . $body['password'] . time() . rand(0, 99999)));
            $user->save(false);

            if ($user->type == 1) {
                $model = Company::find()->where(['user_id' => $user->id])->one();
            } elseif ($user->type == 2) {
                $model = Student::find()->where(['user_id' => $user->id])->one();
            }
            // PUT it in new func
            unset($model->user_id);
            $model->id = $user->id;

            return $this->api->response('201', ['status' => 'success', 'token' => $user->access_token, 'object' => $model]);
        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }
    }

    public function actionStart()
    {
        if ($this->checkMethod('Post')) {
            $body = $this->body;

            if (!$user = $this->api->getUserByToken($body['token'])) return $this->api->response('404', ['token' => 'Token not valid']);

            if ($user->type == 1) {
                $model = Company::find()->where(['user_id' => $user->id])->one();
            } elseif ($user->type == 2) {
                $model = Student::find()->where(['user_id' => $user->id])->one();
            }
            // PUT it in new func
            unset($model->user_id);
            $model->id = $user->id;

            return $this->api->response('201', ['status' => 'success', 'object' => $model]);
        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }

    }

    public function actionAuthBySocials()
    {
        if ($this->checkMethod('Post')) {
            $body = $this->body;
            if (!$body['token'] || !$body['type']) return $this->api->response('422', ['login' => 'token and type are required']);
            $token = $body;
            switch ($type = $body['type']) {
                case "1" :
                {
                    $login = $this->api->vkData($token);
                    break;
                }
                case "2" :
                {
                    $login = $this->api->fbData($token);
                    break;
                }
                default :
                {
                    return $this->api->response('422', ['type' => 'Incorrect socials type']);
                }
            }

            $user = User::find()->where(['username' => $login])->one();
            if (!$user) {
                $user = new User();
                $user->username = $login;
                $user->email = $login;
                $user->status = 2;
                $user->type = 2;
                $password = rand(11111, 555555);
                $user->setPassword($password);
                $user->auth_key = Yii::$app->getSecurity()->generatePasswordHash($password);

                $user->access_token = md5(sha1($login . $password . time() . rand(0, 99999)));
                if (!$user->validate()) {
                    $error = $user->getErrors();
                    return $this->api->response('422', $error);
                }
                $user->save(false);
                $model = new Student();
                $model->user_id = $user->id;
                $model->email = $login;
                $model->save(false);
            }

            if ($user->type == 1 && !$model) {
                $model = Company::find()->where(['user_id' => $user->id])->one();
            } elseif ($user->type == 2 && !$model) {
                $model = Student::find()->where(['user_id' => $user->id])->one();
            }
            unset($model->user_id);
            $model->id = $user->id;

            return $this->api->response('200', ['status' => 'success', 'token' => $user->access_token, 'object' => $model]);
        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }
    }

    public function actionAuth()
    {
        if ($this->checkMethod('Post')) {
            $body = $this->body;

            if (!$body['email'] || !$body['password']) return $this->api->response('422', ['login' => 'Login and password are required']);
            $user = User::find()->where(['username' => $body['email']])->one();
            if (!$user) return $this->api->response('404', ['login' => 'User not found']);

            if (Yii::$app->getSecurity()->validatePassword($body['password'], $user->password_hash)) {
                if ($user->type == 1) {
                    $model = Company::find()->where(['user_id' => $user->id])->one();
                } elseif ($user->type == 2) {
                    $model = Student::find()->where(['user_id' => $user->id])->one();
                }
                // PUT it in new func
                unset($model->user_id);
                $model->id = $user->id;
                return $this->api->response('201', ['status' => 'success', 'token' => $user->access_token, 'object' => $model]);
            } else {
                return $this->api->response('422', ['message' => 'Wrong password']);
            }

        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }
    }

    public function actionRegistration()
    {
        if ($this->checkMethod('Post')) {
            $body = $this->body;

//            $this->user->validateUser($body);
            //to user api class
            if ($check = $this->user_model->checkEmail($body['email'])) {
                return $this->api->response('422', ['email' => 'Email already exists']);
            }
            if ($check = $this->user_model->checkPassword($body)) {
                return $this->api->response('422', ['password' => $check]);
            }
            if ($body['type'] == 1) {
                $model = new Company();
            } elseif ($body['type'] == 2) {
                $model = new Student();
            } else {
                return $this->api->response('422', ['type' => 'Invalid type']);
            }

            $user = new User();
            $user->username = $body['email'];
            $user->email = $body['email'];
            $user->status = 2;
            $user->type = $body['type'];
            $user->setPassword($body['password']);
            $user->auth_key = Yii::$app->getSecurity()->generatePasswordHash($body['password']);
            //to api class
            $user->access_token = md5(sha1($body['email'] . $body['password'] . time() . rand(0, 99999)));
            if (!$user->validate()) {
                $error = $user->getErrors();
                return $this->api->response('422', $error);
            }

            if (!$user->save(false)) return $this->api->response('405', ['message' => 'user create error. see logs.']);

            $model = $this->api->load($model, $body);
            $model->user_id = $user->id;

            if (!$model->validate()) {
                $error = $model->getErrors();
                return $this->api->response('422', $error);
            }

            $model->save(false);
            unset($model->user_id);
            $model->id = $user->id;

            return $this->api->response('201', ['status' => 'success', 'token' => $user->access_token, 'object' => $model]);

        } else {
            return $this->api->response('405', ['message' => 'Method Not Allowed']);
        }
    }

    public function checkMethod($method)
    {
        if (Yii::$app->request->{'is' . $method}) {
            $status = true;
            $this->method = $method;
        } else {
            $status = false;
        }
        return $status;
    }
}

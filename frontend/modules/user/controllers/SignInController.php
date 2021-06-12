<?php

namespace frontend\modules\user\controllers;

use common\commands\SendEmailCommand;
use common\models\User;
use common\models\EventsUsers;
use common\models\VacanciesUsers;
use common\models\UserToken;
use frontend\modules\user\models\LoginForm;
use frontend\modules\user\models\PasswordResetRequestForm;
use frontend\modules\user\models\ResetPasswordForm;
use frontend\modules\user\models\SignupForm;
use frontend\modules\user\models\ResendEmailForm;
use Yii;
use yii\authclient\AuthAction;
use yii\base\Exception;
use yii\base\InvalidArgumentException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use common\api\UserApi;

/**
 * Class SignInController
 * @package frontend\modules\user\controllers
 * @author Eugene Terentev <eugene@terentev.net>
 */
class SignInController extends \yii\web\Controller
{

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'oauth' => [
                'class' => AuthAction::class,
                'successCallback' => [$this, 'successOAuthCallback']
            ]
        ];
    }
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        \Yii::$app->params['body'] = 'account-page';

        return parent::beforeAction($action);
    }
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'signup', 'login', 'login-by-pass', 'request-password-reset', 'reset-password', 'oauth', 'activation', 'resend-email'
                        ],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => [
                            'signup', 'login', 'request-password-reset', 'reset-password', 'oauth', 'activation', 'resend-email'
                        ],
                        'allow' => false,
                        'roles' => ['@'],
                        'denyCallback' => function () {
                            return Yii::$app->controller->redirect(['/user/default/index']);
                        }
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post']
                ]
            ]
        ];
    }

    /**
     * @return array|string|Response
     */
    public function actionLogin()
    {
        $user = User::findByUsername($_POST['email']);
        if (!$user) return json_encode(['error' =>['email' => 'Пользователь с таким email не найден!']]);

        if (Yii::$app->getSecurity()->validatePassword($_POST['password'], $user->password_hash)) {
            Yii::$app->user->login($user, 3600 * 24 * 30);
            return json_encode(['success' => 'success']);
        } else {
            return json_encode( ['error' =>['password' => 'Неверный логин или пароль', 'email' => 'Неверный логин или пароль']]);
        }
    }

    /**
     * @param $token
     * @return array|string|Response
     * @throws ForbiddenHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionLoginByPass($token)
    {
        if (!$this->module->enableLoginByPass) {
            throw new NotFoundHttpException();
        }

        $user = UserToken::use($token, UserToken::TYPE_LOGIN_PASS);

        if ($user === null) {
            throw new ForbiddenHttpException();
        }

        Yii::$app->user->login($user);
        return $this->goHome();
    }

    /**
     * @return Response
     */
    private function out($array) {
        exit(json_encode(['error' => $array]));
    }
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * @return string|Response
     */
    public function actionSignup()
    {
        $data = $_POST;
        $api = new UserApi();
        if ($check = $api->checkUser($data['email'])) {
            $this->out(['email' => 'Пользователь с такой почтой уже зарегистрирован!']);
        }
        if ($check = $api->checkPassword($data)) {
            $this->out(['password' => $check]);
        }
        $model = \Yii::$app->account->createUserModel($data);
        if (!is_object($model)) {
            if ($model['error'])  $this->out($model['error']);
        }
        Yii::$app->getUser()->login($model, 99999999);
        
        if ($data['redirect_from']) {
            $arr = explode('/', $data['redirect_from']);
            $count = count($arr) - 1;
            $id = $arr[$count];
            $type = $arr[$count - 1];

            if ($type == 'events' ) {
                $event = new EventsUsers();
                $event->user_id = $model->id;
                $event->event_id = $id;
                $event->save(false);
            } elseif($type == 'vacancies') {
                $vacancy = new VacanciesUsers();
                $vacancy->user_id = $model->id;
                $vacancy->vacancies = $id;
                $vacancy->save(false);
            }
        }
        return 1;
        exit(json_encode(1));
    }

    /**
     * @param $token
     * @return Response
     * @throws BadRequestHttpException
     */
    public function actionActivation($token)
    {
        $token = UserToken::find()
            ->byType(UserToken::TYPE_ACTIVATION)
            ->byToken($token)
            ->notExpired()
            ->one();

        if (!$token) {
            throw new BadRequestHttpException;
        }

        $user = $token->user;
        $user->updateAttributes([
            'status' => User::STATUS_ACTIVE
        ]);
        $token->delete();
        Yii::$app->getUser()->login($user);
        Yii::$app->getSession()->setFlash('alert', [
            'body' => Yii::t('frontend', 'Your account has been successfully activated.'),
            'options' => ['class' => 'alert-success']
        ]);

        return $this->goHome();
    }

    /**
     * @return string|Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('alert', [
                    'body' => Yii::t('frontend', 'Check your email for further instructions.'),
                    'options' => ['class' => 'alert-success']
                ]);

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('alert', [
                    'body' => Yii::t('frontend', 'Sorry, we are unable to reset password for email provided.'),
                    'options' => ['class' => 'alert-danger']
                ]);
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * @param $token
     * @return string|Response
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('alert', [
                'body' => Yii::t('frontend', 'New password was saved.'),
                'options' => ['class' => 'alert-success']
            ]);
            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionResendEmail()
    {
        $model = new ResendEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('alert', [
                    'body' => Yii::t('frontend', 'Check your email for further instructions.'),
                    'options' => ['class' => 'alert-success']
                ]);

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('alert', [
                    'body' => Yii::t('frontend', 'Sorry, we are unable to resend activation link for email provided.'),
                    'options' => ['class' => 'alert-danger']
                ]);
            }
        }

        return $this->render('resend-email', [
            'model' => $model,
        ]);
    }
}

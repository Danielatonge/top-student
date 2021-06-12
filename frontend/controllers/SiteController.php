<?php

namespace frontend\controllers;

use cheatsheet\Time;
use common\models\Company;
use common\models\Discounts;
use common\models\DiscountsCategory;
use common\models\Emails;
use common\models\Events;
use common\models\EventsCategory;
use common\models\KeyStorageItem;
use common\models\News;
use common\models\NewsCategory;
use common\models\User;
use common\models\UserToken;
use common\models\Vacancies;
use common\models\VacanciesCategory;
use common\sitemap\UrlsIterator;
use Sitemaped\Element\Urlset\Urlset;
use Sitemaped\Sitemap;
use Yii;
use yii\filters\PageCache;
use yii\helpers\Inflector;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => PageCache::class,
                'only' => ['sitemap'],
                'duration' => Time::SECONDS_IN_AN_HOUR,
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
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ],
            'set-locale' => [
                'class' => 'common\actions\SetLocaleAction',
                'locales' => array_keys(Yii::$app->params['availableLocales'])
            ]
        ];
    }

    public function actionParse()
    {
        $d = Vacancies::find()->all();

        foreach ($d as $key => $item) {
            $item->text = strip_tags($item->text);
               $item->save(false);
        }
    }

    public function actionSendRestoreMessage()
    {
//        $user = \Yii::$app->user->identity;
//        $link = Yii::getAlias('@frontendUrl') . '/approve/' . $user->approve_email_code;
//        $message = 'Для подтверждения почты на сайте topstudents.ru перейдите по ссылке ' . $link;
//        $email = $user->email;
//        $res = \Yii::$app->mailer->compose()
//            ->setFrom('hello-topstudents@yandex.ru')
//            ->setTo($email)
//            ->setSubject('Подтверждение профиля на topstudents.ru')
//            ->setHtmlBody($message)
//            ->send();

        $this->redirect('/profile');
    }
    public function actionApproveEmail($token)
    {
        $user = User::find()->where(['approve_email_code' => $token])->one();

        if ($user) {
            $user->approve_email_code = '';
            $user->approve_email = 1;
            $user->save(false);
            return $this->redirect('/profile?message=Почта успешно подтверждена!');
        } else {
            return $this->redirect('/');
        }
    }

    public function actionRestore()
    {
        $email = $_POST['email'];
        $user = User::find()->where(['username' => $email])->one();
        if (!$user) return;

        UserToken::deleteAll(['user_id' => $user->id]);
        $token = UserToken::create($user->id, 'restore', '3600');
        $url = Yii::getAlias('@frontendUrl') . '/restore/' . $token->token;
        $this->restorePassByEmail($url, $email);
    }

    public function actionSetNewPass($token)
    {
        $user = UserToken::check($token, 'restore');

        if (!$user) {
            return redirect('/404');
        }

        return $this->render('restore', ['token' => $token]);
    }

    public function actionInfo()
    {
        $words = [
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'idea' => 'Идея',
            'phone' => 'Телефон',
            'email' => 'Email'
        ];
        $data = $_POST;
        if ($data['idea']) {
            $subject = 'Форма обратной связи: Преложить идею';
        } else {
            $subject = 'Форма обратной связи: Стать партнером';
        }
        $admin = 'info@topstudents.ru';
        $message = '<h1>Заявка с формы обратной связи</h1>';
        foreach ($data as $key => $item) {
            $message .= $words[$key] . ' - ' . $item . '<br>';
        }

        $res = \Yii::$app->mailer->compose()
            ->setFrom('hello-topstudents@yandex.ru')
            ->setTo($admin)
            ->setSubject($subject)
            ->setHtmlBody($message)
            ->send();

        exit(json_encode(['message' => 'Спасибо, мы ответим вам в ближайшее время!']));
    }

    public function actionEmails()
    {
        $email = Emails::find()->where(['email' => $_POST['email']])->one();
        if ($email) exit(json_encode(['message' => 'Вы уже подписаны на нашу рассылку!']));

        $email = new Emails;
        $email->email = $_POST['email'];
        $email->save(false);

        exit(json_encode(['message' => 'Вы успешно подписались на нашу рассылку!']));
    }

    public function actionSaveNewPass()
    {
        if (Yii::$app->request->post('token')) {
            $user = UserToken::check(Yii::$app->request->post('token'), 'restore');
            if ($user) {
                UserToken::remove(Yii::$app->request->post('token'));

                $user->setPassword(Yii::$app->request->post('password'));

                Yii::$app->getUser()->login($user);

                return redirect('/profile');
            } else {
                return redirect('/');
            }
        }
    }

    public function restorePassByEmail($link, $email)
    {
        $message = 'Для восстановления пароля на сайте topstudents.ru перейдите по ссылке ' . $link . ' , ссылка действительная 1 час.';
        $res = \Yii::$app->mailer->compose()
            ->setFrom('hello-topstudents@yandex.ru')
            ->setTo($email)
            ->setSubject('Восстановление пароля')
            ->setHtmlBody($message)
            ->send();

        return $res;
    }

    public function actionSearch()
    {
        $search = $_GET['s'];

        \Yii::$app->params['body'] = 'content-page';
        $date = date('Y-m-d');
        $events = Events::find()->where(['is_active' => 1, 'is_approve' => 1, 'closed' => 0])->andWhere(['like', 'title', $search])->andWhere(['>=', 'date_start', $date])->orderBy('date_start asc')->all();
        $news = News::find()->where(['is_active' => 1, 'is_approved' => 1])->andWhere(['LIKE', 'title', $search])->orderBy('created_at desc')->all();
        $discounts = Discounts::find()->where(['is_active' => 1, 'is_approved' => 1])->andWhere(['LIKE', 'title', $search])->orderBy('created_at desc')->all();
        $vacancies = Vacancies::find()->where(['is_active' => 1, 'is_approved' => 1])->andWhere(['LIKE', 'title', $search])->orderBy('created_at desc')->all();
        $eventsCategory = EventsCategory::find()->select(['id', 'name'])->orderby('order asc')->all();
        $discountsCategory = DiscountsCategory::find()->select(['id', 'name'])->orderby('order asc')->all();
        $vacanciesCategory = VacanciesCategory::find()->select(['id', 'name'])->orderby('order asc')->all();
        $newsCategory = NewsCategory::find()->select(['id', 'name'])->orderby('order asc')->all();

        return $this->render('search', [
            'events' => $events,
            'news' => $news,
            'discounts' => $discounts,
            'vacancies' => $vacancies,
            'eventsCategory' => $eventsCategory,
            'discountsCategory' => $discountsCategory,
            'vacanciesCategory' => $vacanciesCategory,
            'newsCategory' => $newsCategory,
        ]);
    }

    public function actionUploadFile()
    {
        return $this->uploadFile($_FILES, 'file', 'preview');
    }

    public function actionUploadCrop()
    {
        return $this->uploadFile($_FILES, 'croppedImage', 'preview');
    }

    private function uploadFile($file, $key, $path = 'events')
    {
        $uploaddir = \Yii::getAlias('@storage') . '/web/source/1/' . $path . '/';
        $name = md5(rand(0, 9999) . time()) . '.png';

        if ($file[$key]['type'] != 'image/jpeg' && $file[$key]['type'] != 'image/png') return false;
        $uploadfile = $uploaddir . $name;
        if (move_uploaded_file($file[$key]['tmp_name'], $uploadfile)) {
            $url = \Yii::getAlias('@storageUrl') . '/source/1/' . $path . '/' . $name;

            return $url;
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionGenerate()
    {
        $user = News::find()->all();
        foreach ($user as $key => $item) {
            $item->slug = Inflector::slug($item->title);
            $item->save(false);
        }
        $user = Vacancies::find()->all();
        foreach ($user as $key => $item) {
            $item->slug = Inflector::slug($item->title);
            $item->save(false);
        }
        $user = Discounts::find()->all();
        foreach ($user as $key => $item) {
            $item->slug = Inflector::slug($item->title);
            $item->save(false);
        }
    }

//
    public function actionCompany($company)
    {
        $company = Company::find()->where(['slug' => $company])->one();
        if (!$company) throw new \yii\web\NotFoundHttpException();

        \Yii::$app->params['body'] = 'content-page';
        $date = date('Y-m-d');
        $events = Events::find()->where(['is_active' => 1, 'company_id' => $company->user_id, 'is_approve' => 1, 'closed' => 0])->andWhere(['>=', 'date_start', $date])->orderBy('date_start asc')->all();
//        $events = Events::find()->where(['is_active' => 1, 'company_id' => $company->user_id,  'is_approve' =>1, 'closed' => 0])->orderBy('created_at desc')->all();
        $news = News::find()->where(['is_active' => 1, 'company_id' => $company->user_id, 'is_approved' => 1])->orderBy('created_at desc')->all();
        $discounts = Discounts::find()->where(['is_active' => 1, 'company_id' => $company->user_id, 'is_approved' => 1])->orderBy('created_at desc')->all();
        $vacancies = Vacancies::find()->where(['is_active' => 1, 'company_id' => $company->user_id, 'is_approved' => 1])->orderBy('created_at desc')->all();
        $eventsCategory = EventsCategory::find()->select(['id', 'name'])->orderby('order asc')->all();
        $discountsCategory = DiscountsCategory::find()->select(['id', 'name'])->orderby('order asc')->all();
        $vacanciesCategory = VacanciesCategory::find()->select(['id', 'name'])->orderby('order asc')->all();
        $newsCategory = NewsCategory::find()->select(['id', 'name'])->orderby('order asc')->all();

        return $this->render('company', [
            'company' => $company,
            'events' => $events,
            'news' => $news,
            'discounts' => $discounts,
            'vacancies' => $vacancies,
            'eventsCategory' => $eventsCategory,
            'discountsCategory' => $discountsCategory,
            'vacanciesCategory' => $vacanciesCategory,
            'newsCategory' => $newsCategory,
        ]);

    }

    public function actionPolicy()
    {
        return $this->render('policy');
    }

    public function actionFbDeactive()
    {
        return $this->render('policy');
    }

    public function actionFb()
    {
        $client_id = '379131016840288';
        $client_secret = '7c7f79f32c4e894db30db11ee2cd4800';
        $redirect_uri = \Yii::getAlias('@frontendUrl') . '/fbAuth';
        if (isset($_GET['code'])) {
            $result = false;

            $params = array(
                'client_id' => $client_id,
                'redirect_uri' => $redirect_uri,
                'client_secret' => $client_secret,
                'code' => $_GET['code']
            );

            $url = 'https://graph.facebook.com/oauth/access_token';

            $tokenInfo = null;
            $token = json_decode(file_get_contents($url . '?' . http_build_query($params)), true);

            if (count($token) > 0 && isset($token['access_token'])) {
                $params = array('access_token' => $token['access_token']);

                $userInfo = json_decode(file_get_contents('https://graph.facebook.com/me' . '?' . urldecode(http_build_query($params))), true);

                $vk_id = $userInfo['id'];
                $name = explode(' ', $userInfo['name']);
                $vk_name = $name[0];
                $vk_surname = $name[1];

                if (!$vk_id) {
                    return redirect('/');
                }
                $user = User::find()->where(['vk_id' => $vk_id])->one();
                if ($user) {

                } else {
                    $user = \Yii::$app->account->createUserModel([
                        'type' => 2,
                        'name' => $vk_name,
                        'surname' => $vk_surname,
                        'username' => Inflector::slug($vk_name . '_' . $vk_surname),
                        'email' => '',
                        'vk_id' => $vk_id,
                        'password' => rand(1111111, 9999999),

                    ]);
                    if (!$user) return redirect('/');
                }

                \Yii::$app->user->login($user, 3600 * 24 * 30);
                return redirect('/profile');
            }
        }
    }

    public function actionVk()
    {
        if (isset($_GET['code'])) {
            $params = array(
                'client_id' => 7630081,
                'client_secret' => '21aAj6z2ag736dOj56Ga',
                'code' => $_GET['code'],
                'redirect_uri' => 'https://topstudents.ru/vkAuth',
                'v' => '5.59'
            );

            $token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);
            if (isset($token['access_token'])) {
                $params = array(
                    'uids' => $token['user_id'],
                    'fields' => 'email,photo_big',
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
            if ($user) {

            } else {
                $user = \Yii::$app->account->createUserModel([
                    'type' => 2,
                    'name' => $vk_name,
                    'surname' => $vk_surname,
                    'username' => Inflector::slug($vk_name . '_' . $vk_surname),
                    'email' => '',
                    'vk_id' => $vk_id,
                    'password' => rand(1111111, 9999999),

                ]);
                if (!$user) return redirect('/');
            }

            \Yii::$app->user->login($user, 3600 * 24 * 30);
            return redirect('/profile');
        }
    }

    public function actionIndex()
    {
        \Yii::$app->params['body'] = 'content-page';
        $date = date('Y-m-d');
        $events = Events::find()->where(['is_active' => 1, 'is_approve' => 1, 'closed' => 0])->andWhere(['>=', 'date_start', $date])->orderBy('date_start asc')->all();
        $news = News::find()->where(['is_active' => 1, 'is_approved' => 1])->orderBy('created_at desc')->all();
        $discounts = Discounts::find()->where(['is_active' => 1, 'is_approved' => 1])->orderBy('created_at desc')->all();
        $vacancies = Vacancies::find()->where(['is_active' => 1, 'is_approved' => 1])->orderBy('created_at desc')->all();
        $eventsCategory = EventsCategory::find()->select(['id', 'name'])->orderby('order asc')->all();
        $discountsCategory = DiscountsCategory::find()->select(['id', 'name'])->orderby('order asc')->all();
        $vacanciesCategory = VacanciesCategory::find()->select(['id', 'name'])->orderby('order asc')->all();
        $newsCategory = NewsCategory::find()->select(['id', 'name'])->orderby('order asc')->all();

        $model = KeyStorageItem::find()->where(['key' => 'banner'])->one();
        $banner = json_decode($model->value, true);
        return $this->render('index', [
            'banner' => $banner,
            'events' => $events,
            'news' => $news,
            'discounts' => $discounts,
            'vacancies' => $vacancies,
            'eventsCategory' => $eventsCategory,
            'discountsCategory' => $discountsCategory,
            'vacanciesCategory' => $vacanciesCategory,
            'newsCategory' => $newsCategory,
        ]);
    }

    public function actionAbout()
    {
        $model = KeyStorageItem::find()->where(['key' => 'about'])->one();
        $data = json_decode($model->value, true);

        return $this->render('about', ['data' => $data]);
    }


    /**
     * @param string $format
     * @param bool $gzip
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionSitemap($format = Sitemap::FORMAT_XML, $gzip = false)
    {
        $links = new UrlsIterator();
        $sitemap = new Sitemap(new Urlset($links));

        Yii::$app->response->format = Response::FORMAT_RAW;

        if ($gzip === true) {
            Yii::$app->response->headers->add('Content-Encoding', 'gzip');
        }

        if ($format === Sitemap::FORMAT_XML) {
            Yii::$app->response->headers->add('Content-Type', 'application/xml');
            $content = $sitemap->toXmlString($gzip);
        } else if ($format === Sitemap::FORMAT_TXT) {
            Yii::$app->response->headers->add('Content-Type', 'text/plain');
            $content = $sitemap->toTxtString($gzip);
        } else {
            throw new BadRequestHttpException('Unknown format');
        }

        $linksCount = $sitemap->getCount();
        if ($linksCount > 50000) {
            Yii::warning(\sprintf('Sitemap links count is %d'), $linksCount);
        }

        return $content;
    }
}

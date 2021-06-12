<?php

namespace frontend\modules\user\controllers;

use common\models\Company;
use common\models\Discounts;
use common\models\DiscountsCategory;
use common\models\Events;
use common\models\EventsCategory;
use common\models\EventsUsers;
use common\models\News;
use common\models\User;
use common\models\NewsCategory;
use common\models\Student;
use common\models\Vacancies;
use common\models\VacanciesCategory;
use common\models\VacanciesUsers;
use Intervention\Image\ImageManagerStatic;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Inflector;

class DefaultController extends Controller
{
    /**
     * @return array
     */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        \Yii::$app->params['body'] = 'account-page';

        return parent::beforeAction($action);
    }

    public function actions()
    {
        return [
            'avatar-upload' => [
                'class' => UploadAction::class,
                'deleteRoute' => 'avatar-delete',
                'on afterSave' => function ($event) {
                    /* @var $file \League\Flysystem\File */
                    $file = $event->file;
                    $img = ImageManagerStatic::make($file->read())->fit(215, 215);
                    $file->put($img->encode());
                }
            ],
            'avatar-delete' => [
                'class' => DeleteAction::class
            ]
        ];
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
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    /**
     * @return string|\yii\web\Response
     */


    public function actionEvents()
    {
        $user = \Yii::$app->user->identity;
        if ($user->type == 1) {
            $events = Events::find()->where(['company_id' => $user->id, 'is_active' => 1])->orderBy('id desc')->all();
            return $this->render('company/events', [
                'user' => $user,
                'events' => $events
            ]);
        } elseif ($user->type == 2) {
            $events =  Events::find()
                ->leftJoin('events_users', 'events_users.event_id = events.id')
                ->where(['events.is_active' => 1])
                ->andWhere(['events_users.user_id' => $user->id])
                ->orderBy('events.id desc')
                ->all();

            return $this->render('student/events', [
                'user' => $user,
                'events' => $events
            ]);
        }
    }

    public function actionEventsDelete()
    {
        $id = $_GET['id'];
        $user = \Yii::$app->user->identity;
        if ($user->type == 2)  throw new NotFoundHttpException;
        $event = Events::find()->where(['company_id' => $user->id, 'id' => $id])->one();
        if (!$event) throw new NotFoundHttpException;
        $event->is_active = 0;
        $event->save(false);

        return $this->redirect('/profile/events');
    }

    public function actionDiscountsDelete()
    {
        $id = $_GET['id'];
        $user = \Yii::$app->user->identity;
        if ($user->type == 2)  throw new NotFoundHttpException;
        $event = Discounts::find()->where(['company_id' => $user->id, 'id' => $id])->one();
        if (!$event) throw new NotFoundHttpException;
        $event->is_active = 0;
        $event->save(false);

        return $this->redirect('/profile/discounts');
    }

    public function actionVacanciesDelete()
    {
        $id = $_GET['id'];
        $user = \Yii::$app->user->identity;
        if ($user->type == 2)  throw new NotFoundHttpException;
        $event = Vacancies::find()->where(['company_id' => $user->id, 'id' => $id])->one();
        if (!$event) throw new NotFoundHttpException;
        $event->is_active = 0;
        $event->save(false);

        return $this->redirect('/profile/vacancies');
    }

    public function actionNewsDelete()
    {
        $id = $_GET['id'];
        $user = \Yii::$app->user->identity;
        if ($user->type == 2)  throw new NotFoundHttpException;
        $event = News::find()->where(['company_id' => $user->id, 'id' => $id])->one();
        if (!$event) throw new NotFoundHttpException;
        $event->is_active = 0;
        $event->save(false);

        return $this->redirect('/profile/news');
    }

    public function actionVacanciesCreate()
    {
        $user = \Yii::$app->user->identity;
        if ($user->type == 2)  throw new NotFoundHttpException;
        $category = VacanciesCategory::find()->where(['is_active' => 1])->all();

        if ($_POST) {

            $event = new Vacancies();
            foreach ($_POST as $key => $item) {
                if ($event->hasAttribute($key)) {
                    $event->{$key} = strip_tags($item);
                }
            }
            $event->address = json_encode($event->address);
            $event->metro = json_encode($event->metro);
            $event->coords = json_encode($event->coords);

            $event->company_id = \Yii::$app->user->id;
            $event->category_id = $_POST['category'];
            $event->image = $_POST['image_file'];
            $event->preview = $_POST['preview'];
            $event->is_online = $_POST['online'];
            $event->slug =  Inflector::slug($event->title);
            $event->save(false);

            return $this->redirect('/profile/vacancies');
        }

        return $this->render('company/vacancies-add', [
            'user' => $user,
            'category' => $category
        ]);
    }

    public function actionNewsCreate()
    {
        $user = \Yii::$app->user->identity;
        if ($user->type == 2)  throw new NotFoundHttpException;
        $category = NewsCategory::find()->where(['is_active' => 1])->all();

        if ($_POST) {

            $event = new News();
            foreach ($_POST as $key => $item) {
                if ($event->hasAttribute($key)) {
                    $event->{$key} = strip_tags($item);
                }
            }
            $event->gallery = json_encode($_POST['DynamicModel']['gallery']);
            $event->company_id = \Yii::$app->user->id;
            $event->date_start = date('Y-m-d H:i:s');
            $event->created_at = date('Y-m-d H:i:s');
            $event->category_id = $_POST['category'];
            $event->image = $_POST['image_file'];
            $event->preview = $_POST['preview'];
            $event->slug =  Inflector::slug($event->title);

            $event->save(false);

            return $this->redirect('/profile/news');
        }

        return $this->render('company/news-add', [
            'user' => $user,
            'category' => $category
        ]);
    }

    public function actionDiscountsCreate()
    {
        $user = \Yii::$app->user->identity;
        if ($user->type == 2)  throw new NotFoundHttpException;
        $category = DiscountsCategory::find()->where(['is_active' => 1])->all();

        if ($_POST) {

            $event = new Discounts();
            foreach ($_POST as $key => $item) {
                if ($event->hasAttribute($key)) {
                    $event->{$key} = strip_tags($item);
                }
            }
            $event->free = $_POST['free'] == 'on' ? 1 : 0;
            $event->address = json_encode($event->address);
            $event->metro = json_encode($event->metro);
            $event->coords = json_encode($event->coords);

            $event->gallery = json_encode($_POST['DynamicModel']['gallery']);
            $event->company_id = \Yii::$app->user->id;
            $event->category_id = $_POST['category'];
            $event->image = $_POST['image_file'];
            $event->preview = $_POST['preview'];
            $event->is_online = $_POST['online'];
            $event->slug =  Inflector::slug($event->title);
            $event->save(false);

            return $this->redirect('/profile/discounts');
        }

        return $this->render('company/discounts-add', [
            'user' => $user,
            'category' => $category
        ]);
    }

    public function actionEventsCreate()
    {
        $user = \Yii::$app->user->identity;
        if ($user->type == 2)  throw new NotFoundHttpException;
        $category = EventsCategory::find()->where(['is_active' => 1])->all();

        if ($_POST) {
            $event = new Events();
            foreach ($_POST as $key => $item) {
                if ($event->hasAttribute($key)) {
                    $event->{$key} = strip_tags($item);
                }
            }
            $event->address = json_encode($event->address);
            $event->metro = json_encode($event->metro);
            $event->coords = json_encode($event->coords);
            $event->date_start = date('Y-m-d H:i:s', strtotime($event->date_start));
            $event->slug =  Inflector::slug($event->title);
            $event->company_id = \Yii::$app->user->id;
            $event->category_id = $_POST['category'];
            $event->is_online = $_POST['online'];
            $event->image = $_POST['image_file'];
            $event->preview = $_POST['preview'];
            $event->save(false);

            return $this->redirect('/profile/events');
        }

        return $this->render('company/events-add', [
            'user' => $user,
            'category' => $category
        ]);
    }

    public function actionEventsEdit()
    {
        $id = $_GET['id'];
        $user = \Yii::$app->user->identity;
        if ($user->type == 2)  throw new NotFoundHttpException;
        $category = EventsCategory::find()->where(['is_active' => 1])->all();
        $event = Events::findOne($id);
        if (!$event) throw new NotFoundHttpException;

        if ($_POST) {
            foreach ($_POST as $key => $item) {
                if ($event->hasAttribute($key)) {
                    $event->{$key} = strip_tags($item);
                }
            }
            $event->free  = $_POST['free'] == 'on' ? 1 : 0;
            if ($event->free) {
                $event->price = '';
                $event->price_sale = '';
            }
            $event->address = json_encode($_POST['address']);
            $event->metro = json_encode($_POST['metro']);
            $event->coords = json_encode($_POST['coords']);
            $event->date_start = date('Y-m-d H:i:s', strtotime($event->date_start));
            $event->closed_registration = $_POST['closed_registration'] ? 1 : 0;
            $event->closed = $_POST['closed'] ? 1 : 0;
            $event->category_id = $_POST['category'];
            $event->is_online = $_POST['online'];
            $event->image = $_POST['image_file'];
            $event->preview = $_POST['preview'];
            $event->save(false);

            return $this->redirect('/profile/events');
        }

        return $this->render('company/events-edit', [
            'user' => $user,
            'event' => $event,
            'category' => $category
        ]);
    }

    public function actionDiscountsEdit()
    {
        $id = $_GET['id'];
        $user = \Yii::$app->user->identity;
        if ($user->type == 2)  throw new NotFoundHttpException;
        $category = DiscountsCategory::find()->where(['is_active' => 1])->all();
        $sale = Discounts::findOne($id);
        if (!$sale) throw new NotFoundHttpException;

        if ($_POST) {
            foreach ($_POST as $key => $item) {
                if ($sale->hasAttribute($key)) {
                    $sale->{$key} = strip_tags($item);
                }
            }
            $sale->free = $_POST['free'] == 'on' ? 1 : 0;
            if ($sale->free) {
                $sale->sales = '';
            }
            $sale->address = json_encode($sale->address);
            $sale->metro = json_encode($sale->metro);
            $sale->coords = json_encode($sale->coords);

            $sale->category_id = $_POST['category'];
            $sale->is_online = $_POST['online'];
            $sale->image = $_POST['image_file'];
            $sale->preview = $_POST['preview'];
            $sale->gallery = json_encode($_POST['DynamicModel']['gallery']);

            $sale->save(false);

            return $this->redirect('/profile/discounts');
        }

        return $this->render('company/discounts-edit', [
            'user' => $user,
            'sale' => $sale,
            'category' => $category
        ]);
    }

    public function actionDiscounts()
    {
        $user = \Yii::$app->user->identity;
        if ($user->type == 2)  throw new NotFoundHttpException;
        $sales = Discounts::find()->where(['company_id' => $user->id, 'is_active' => 1])->orderBy('id desc')->all();
        if ($user->type == 1) {
            return $this->render('company/discounts', [
                'user' => $user,
                'sales' => $sales
            ]);
        } elseif ($user->type == 2) {
            throw new NotFoundHttpException;
        }
    }

    public function actionVacancies()
    {
        $user = \Yii::$app->user->identity;
        if ($user->type == 1) {
            $vacancies = Vacancies::find()->where(['company_id' => $user->id, 'is_active' => 1])->orderBy('id desc')->all();
            return $this->render('company/vacancy', [
                'vacancies' => $vacancies,
                'user' => $user,
            ]);
        } elseif ($user->type == 2) {
            $vacancies =  Vacancies::find()
                ->leftJoin('vacancies_users', 'vacancies_users.vacancies_id = vacancies.id')
                ->where(['vacancies.is_active' => 1])
                ->andWhere(['vacancies_users.user_id' => $user->id])
                ->orderBy('vacancies.id desc')
                ->all();

            return $this->render('student/vacancy', [
                'user' => $user,
                'vacancies' => $vacancies
            ]);
        }
    }

    public function actionVacanciesEdit()
    {
        $id = $_GET['id'];
        $user = \Yii::$app->user->identity;
        if ($user->type == 2)  throw new NotFoundHttpException;
        $category = VacanciesCategory::find()->where(['is_active' => 1])->all();
        $vacancy = Vacancies::findOne($id);
        if (!$vacancy) throw new NotFoundHttpException;

        if ($_POST) {
            foreach ($_POST as $key => $item) {
                if ($vacancy->hasAttribute($key)) {
                    $vacancy->{$key} = strip_tags($item);
                }
            }
            $vacancy->address = json_encode($vacancy->address);
            $vacancy->metro = json_encode($vacancy->metro);
            $vacancy->coords = json_encode($vacancy->coords);

            $vacancy->category_id = $_POST['category'];
            $vacancy->is_online = $_POST['online'];
            $vacancy->image = $_POST['image_file'];
            $vacancy->preview = $_POST['preview'];
            $vacancy->save(false);

            return $this->redirect('/profile/vacancies');
        }

        return $this->render('company/vacancies-edit', [
            'user' => $user,
            'vacancy' => $vacancy,
            'category' => $category
        ]);
    }

    public function actionNews()
    {
        $user = \Yii::$app->user->identity;
        if ($user->type == 1) {
            $news = News::find()->where(['company_id' => $user->id, 'is_active' => 1])->orderBy('id desc')->all();
            return $this->render('company/news', [
                'user' => $user,
                'news' => $news
            ]);
        } elseif ($user->type == 2) {
            throw new NotFoundHttpException;
        }
    }

    public function actionNewsEdit()
    {
        
        $id = $_GET['id'];
        $user = \Yii::$app->user->identity;
        if ($user->type == 2)  throw new NotFoundHttpException;
        $category = NewsCategory::find()->where(['is_active' => 1])->all();
        $vacancy = News::findOne($id);
        if (!$vacancy) throw new NotFoundHttpException;

        if ($_POST) {
            foreach ($_POST as $key => $item) {
                if ($vacancy->hasAttribute($key)) {
                    $vacancy->{$key} = strip_tags($item);
                }
            }
            $vacancy->category_id = $_POST['category'];
            $vacancy->updated_at = date('Y-m-d H:i:s');
            $vacancy->gallery = json_encode($_POST['DynamicModel']['gallery']);
            $vacancy->image = $_POST['image_file'];
            $vacancy->preview = $_POST['preview'];
            $vacancy->save(false);

            return $this->redirect('/profile/news');
        }

        return $this->render('company/news-edit', [
            'user' => $user,
            'news' => $vacancy,
            'category' => $category
        ]);
    }

    public function actionIndex()
    {
        $user = \Yii::$app->user->identity;

        if ($_POST) {
            $data = $_POST;
            if ($user->type == 1) {
                if ($data['password'] && $data['passwordConfirmation']) {
                    if ($data['password'] == $data['passwordConfirmation']) {
                        $user->setPassword($data['password']);
                    }
                }
                if ($data['username'] && ($data['username'] != $user->username)) {
                    $check = User::find()->where(['username' => $data['username']])->one();
                    if ($check) {
                        return $this->redirect('/profile?error=Указаный логин уже занят другом пользователем!');
                    }
                    $user->username = $data['username'];
                    $user->email = $data['email'];
                    $user->approve_email_code = md5(time() . $user->username . time() . $user->email);
                    $user->save(false);
                    \Yii::$app->account->sendApproveMessage($user);
                }
                $model = Company::find()->where(['user_id' => $user->id])->one();
                $model->organizationName = $data['name'];
                $model->email = $data['email'];
                $model->phoneNumber = $data['phone'];
                $model->description =  strip_tags($data['description']);
                $model->website = $data['website'];
                $model->slug = Inflector::slug($data['slug']);
                $model->logoImage = $data['logoImage'];
                $model->address = $data['address'];
                $model->filials = json_encode($data['filials']);
                $model->vkProfile = $data['vkProfile'];
                $model->instagramProfile = $data['instagramProfile'];
                $model->save(false);
            } elseif ($user->type == 2) {
                if ($data['password'] && $data['passwordConfirmation']) {
                    if ($data['password'] == $data['passwordConfirmation']) {
                        $user->setPassword($data['password']);
                    }
                }

                $model = Student::find()->where(['user_id' => $user->id])->one();
                $model->lastName = $data['lastName'];
                $model->firstName = $data['firstName'];
                $model->patronymic = $data['patronymic'];
                $model->university = $data['university'];
                $model->email = $data['email'];
                $model->phoneNumber = $data['phoneNumber'];
                $model->vkProfile = $data['vkProfile'];
                $model->save(false);
            }
            return $this->refresh();
        }
        if ($user->type == 1) {
            return $this->render('company/index', [
                'user' => $user,
            ]);
        } elseif ($user->type == 2) {
            return $this->render('student/index', [
                'user' => $user,
            ]);
        }
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

    public function actionExport()
    {
        $id = $_GET['id'];
        $type = $_GET['type'];
        if ($id) {
            if ($type == 'events') {
                $students = Student::find()->select(['student.*'])
                    ->leftJoin('events_users', 'events_users.user_id = student.user_id')
                    ->where(['events_users.event_id' => $id])
                    ->asArray()
                    ->all();
            } elseif ($type == 'discounts') {
                $students = Student::find()->select(['student.*'])
                    ->leftJoin('discounts_users', 'discounts_users.user_id = student.user_id')
                    ->where(['discounts_users.discounts_id' => $id])
                    ->asArray()
                    ->all();
            } elseif ($type == 'vacancies') {
                $students = Student::find()->select(['student.*'])
                    ->leftJoin('vacancies_users', 'vacancies_users.user_id = student.user_id')
                    ->where(['vacancies_users.vacancies_id' => $id])
                    ->asArray()
                    ->all();
            }


            if ($students) {
                $f = fopen('php://memory', 'w');
                foreach ($students as $key => $item) {
                    fputs($f, chr(0xEF) . chr(0xBB) . chr(0xBF));
                    fputcsv($f, $item, ';');
                }
                rewind($f);
                $output = stream_get_contents($f);
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . $type . '_'  . $id . '.csv";');
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
                echo "\xEF\xBB\xBF"; // UTF-8 BOM
                echo $output;
                exit();
            } else {
                $this->redirect('/profile');
            }
        }
    }

    public function actionDisapprove()
    {
        $user = \Yii::$app->user->identity;
        $id = $_GET['id'];
        $type = $_GET['type'];
        if ($type == 'vacancies') {
            $model = VacanciesUsers::find()->where(['user_id' => $user->id, 'vacancies_id' => $id])->one();
            $model->delete();
        } elseif ($type == 'events') {
            $model = EventsUsers::find()->where(['user_id' => $user->id, 'event_id' => $id])->one();
            $model->delete();
        }

        return $this->redirect('/profile/' . $type);

    }
}

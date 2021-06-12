<?php


namespace frontend\components;

use common\models\Student;
use common\models\Company;
use Yii;
use common\models\User;
use yii\base\Component;
use yii\helpers\Inflector;

class Account extends Component
{

    public function createUserModel($data)
    {
        $user = new User();
        $user->username = $data['email'] ? $data['email'] : $data['username'];
        $user->email = $data['email'];
        $user->status = 2;
        $user->vk_id = (string) $data['vk_id'];
        $user->type = $data['type'];
        $user->setPassword($data['password']);
        $user->auth_key = Yii::$app->getSecurity()->generatePasswordHash($data['password']);

        $user->access_token = md5(sha1($data['email'] . $data['password'] . time() . rand(0, 99999)));
        if (!$user->validate()) {
            $data['error'] = $user->getErrors();
            return $data;
        }
        $user->approve_email_code = md5(time() . $user->username . time() . $user->email);
        $user->save(false);

        $this->createUserProfile($data, $user);

        if (!$data['vk_id']) {
            $user->approve_email_code = md5(time() . $user->username . time() . $user->email);
            $user->save(false);
            $this->sendApproveMessage($user);
        }

        return $user;
    }

    public function sendApproveMessage($user)
    {
//        $link = Yii::getAlias('@frontendUrl') . '/approve/' . $user->approve_email_code;
//        $message = 'Для подтверждения почты на сайте topstudents.ru перейдите по ссылке ' . $link;
//        $email = $user->email;
//        $res = \Yii::$app->mailer->compose()
//            ->setFrom('hello-topstudents@yandex.ru')
//            ->setTo($email)
//            ->setSubject('Подтверждение профиля на topstudents.ru')
//            ->setHtmlBody($message)
//            ->send();

//        return $res;
        return 1;
    }

    private function createUserProfile($data, $user)
    {
        if ($data['type'] == 2) {
            $model = new Student();
            $model->firstName = $data['name'];
            $model->lastName = $data['surname'];
            $model->patronymic = $data['lastName'];
            $model->university = $data['university'];
            $model->phoneNumber = $data['phone'];
            $model->email = $data['email'];
            if ($data['vk_id']) {
                $model->vkProfile = 'https://vk.com/id' .  $data['vk_id'];
            } else {
                $model->vkProfile = $data['vkProfile'];
            }
        } elseif ($data['type'] == 1) {
            $model = new Company();
            $model->organizationName = $data['name'];
            $model->slug = Inflector::slug($data['name']);
            $model->email = $data['email'];
            $model->phoneNumber = $data['phone'];
            $model->website = $data['website'];
        }

        $model->user_id = $user->id;
        $res = $model->save(false);

    }

}

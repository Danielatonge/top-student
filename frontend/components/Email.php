<?php


namespace frontend\components;

use common\models\UserToken;
use Yii;
use yii\base\Component;


class Email extends Component
{


    public function restorePassword($user, $token)
    {
        $token  = $token->token;
        $message = 'Код для восстановления паролья на сайте topstudents.ru - ' . $token;
        $to = $user->email;
        $subject = 'Восстановление пароля на сайте topstudents.ru';

        return $this->sendMail($to, $subject, $message);

    }

    public function sendMail($to, $subject, $body, $from = 'hello-topstudents@yandex.ru')
    {
//        return  \Yii::$app->mailer->compose()
//            ->setFrom($from)
//            ->setTo($to)
//            ->setSubject($subject)
//            ->setHtmlBody($body)
//            ->send();

        return 1;
    }
}

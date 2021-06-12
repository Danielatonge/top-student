<?php
namespace common\api;

use common\models\User;
use common\models\Student;
use common\models\Company;

class UserApi
{
    public function validateUser($body) {

    }
    public function checkUser($login)
    {
        $user = User::find()->where(['username' => $login])->one();

        return $user ? true : false;
    }

    public function checkEmail($email)
    {
        $user = User::find()->where(['email' => $email])->one();

        return $user ? true : false;
    }

    public function checkPassword($body)
    {
        $password = trim($body['password']);

        if ($password) {
            if (strlen($password)  < 6) {
                return 'Длина пароль должна быть больше 5 символов';
            }
        } else {
            return 'Введите пароль';
        }
    }
}

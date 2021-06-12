<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $lastName
 * @property string|null $firstName
 * @property string|null $patronymic
 * @property string|null $university
 * @property string|null $email
 * @property string|null $phoneNumber
 * @property string|null $vkProfile
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['lastName', 'firstName', 'patronymic', 'university', 'email', 'phoneNumber', 'vkProfile'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'lastName' => 'Last Name',
            'firstName' => 'First Name',
            'patronymic' => 'Patronymic',
            'university' => 'University',
            'email' => 'Email',
            'phoneNumber' => 'Phone Number',
            'vkProfile' => 'Vk Profile',
        ];
    }
}

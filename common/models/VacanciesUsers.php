<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vacancies_users".
 *
 * @property int $id
 * @property int $user_id
 * @property int $vacancies_id
 */
class VacanciesUsers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vacancies_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'vacancies_id'], 'required'],
            [['user_id', 'vacancies_id'], 'integer'],
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
            'vacancies_id' => 'Vacancies ID',
        ];
    }
}

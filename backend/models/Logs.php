<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "logs".
 *
 * @property int $id
 * @property string $datetime
 * @property int $status_code
 * @property int $url
 * @property int|null $request
 * @property int|null $response
 * @property string|null $body
 * @property string|null $headers
 */
class Logs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['datetime'], 'safe'],
            [['status_code'], 'integer'],
            [['body', 'headers', 'method', 'token', 'url',  'response'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'datetime' => 'Дата  создания',
            'status_code' => 'Код ответа',
            'url' => 'Адрес запроса',
            'request' => 'Тело запроса',
            'response' => 'Тело ответа',
            'body' => 'Тело ответа',
            'headers' => 'Заголовки',
            'token' => "Токен авторизации",
            'method' => "Метод запроса",
        ];
    }

}

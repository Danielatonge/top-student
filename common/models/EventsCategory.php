<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "events_category".
 *
 * @property int $id
 * @property string|null $name
 * @property string $text
 * @property int $is_active
 */
class EventsCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'events_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['is_active', 'order'], 'integer'],
            [['name', 'text'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'text' => 'Описание',
            'is_active' => 'Активна',
        ];
    }
}

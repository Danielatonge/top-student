<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "discounts_category".
 *
 * @property int $id
 * @property string $name
 * @property string|null $text
 * @property int $is_active
 */
class DiscountsCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'discounts_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['text'], 'string'],
            [['is_active', 'order'], 'integer'],
            [['name'], 'string', 'max' => 255],
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

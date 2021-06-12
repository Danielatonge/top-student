<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "discounts_users".
 *
 * @property int $id
 * @property int $user_id
 * @property int $discounts_id
 */
class DiscountsUsers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'discounts_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'discounts_id'], 'required'],
            [['user_id', 'discounts_id'], 'integer'],
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
            'discounts_id' => 'Discounts ID',
        ];
    }
}

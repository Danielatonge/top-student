<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property int $user_id
 * @property string $organizationName
 * @property string|null $description
 * @property string $email
 * @property string|null $phoneNumber
 * @property string|null $website
 * @property string|null $vkProfile
 * @property string|null $instagramProfile
 * @property string|null $logoImage
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'slug', 'organizationName', 'email'], 'required'],
            [['user_id'], 'integer'],
            [['address', 'filials', 'description'], 'safe'],
            [['organizationName', 'slug',  'email', 'phoneNumber', 'website', 'vkProfile', 'instagramProfile', 'logoImage'], 'string', 'max' => 255],
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
            'organizationName' => 'Organization Name',
            'description' => 'Description',
            'email' => 'Email',
            'phoneNumber' => 'Phone Number',
            'website' => 'Website',
            'vkProfile' => 'Vk Profile',
            'instagramProfile' => 'Instagram Profile',
            'logoImage' => 'Logo Image',
        ];
    }
}

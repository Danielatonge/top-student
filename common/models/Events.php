<?php

namespace common\models;

use Laminas\EventManager\Event;
use Yii;
use common\models\EventsUsers;
/**
 * This is the model class for table "events".
 *
 * @property int $id
 * @property int $company_id
 * @property int $category_id
 * @property string $title
 * @property string|null $address
 * @property string|null $image
 * @property string|null $text
 * @property string|null $date_start
 * @property string|null $date_end
 * @property int $created_at
 * @property string $updated_at
 * @property int $is_active
 * @property int $is_approve
 */
class Events extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'category_id', 'title', 'created_at', 'slug'], 'required'],
            [['company_id', 'category_id', 'is_active', 'is_approve', 'is_online', 'multi_day', 'closed', '	closed_registration', 'food', 'free'], 'integer'],
            [['date_start', 'date_end', 'updated_at', 'created_at', 'text', 'org_description'], 'safe'],
            [['title',  'image', 'encouraging', 'price', 'price_sale', 'link', 'slug', 'preview', 'organizationName', 'org_description', 'website', 'phone', 'vk'], 'string', 'max' => 255],
        ];
    }

    public function checkUser()
    {
        return EventsUsers::find()->where(['event_id' => $this->id, 'user_id' => \Yii::$app->user->id])->one();
    }
    public function getParentSlug()
    {
        $parent = Company::find()->where(['user_id' => $this->company_id])->one();

        if ($parent) return $parent->slug;
    }

    public function isLike($user_id)
    {
        return Likes::find()->where(['user_id' => $user_id, 'object_id' =>$this->id, 'object_type' => 2])->count();
    }

    public static function isLiked($event, $user)
    {
        return Likes::find()->where(['user_id' => $user->id, 'object_id' => $event['id'], 'object_type' => 2])->one();
    }

    public static function isJoin($event, $user)
    {
        return EventsUsers::find()->where(['user_id' => $user->id, 'event_id' => $event['id']])->one();
    }

    public function getCompanyData()
    {
        return Company::find()->where(['user_id' => $this->company_id])->one();
    }

    public function getExcerpt($l = 100) {
        $l =150;
        $new = mb_substr($this->text, 0, $l);

        if (strlen(strip_tags($this->text)) > $l) {
            return $this->strip_tags_content($new) .'..';
        } else {
            return $this->strip_tags_content($this->text);
        }
    }
    public function getExcerptTitle() {
        $new  = iconv_substr (strip_tags($this->title), 0 , 45 , 'UTF-8');

        if (mb_strlen(strip_tags($this->title)) > 45) {
            return $new .'..';
        } else {
            return $this->title;
        }
    }

    private function strip_tags_content($text) {

        return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', strip_tags($text));

    }

    public function getAllMetro()
    {
        $metro = json_decode($this->metro, true);

        if (is_array($metro) && $metro[0]) {
            $name = $metro[0];
            if (count($metro) > 1) {
                $name .= ' +' . (count($metro) -1);
            }
            return $name;
        }
    }

    public function getStatus()
    {
        if ($this->is_approve == 1) {
            return 'Одобрено';
        } elseif ($this->is_approve == 2) {
            return 'Отклонено';
        } elseif ($this->is_approve == 0) {
            return 'Новая заявка';
        }
    }

    public function getAddress()
    {
        $address =  str_replace('Москва,', '', $this->address);
        $address =  str_replace('Москва ,', '', $address);
        $address =  str_replace('Москва', '', $address);

        return $address;
    }


    public function getAction()
    {
        $html = '<div class="table-grid">';
        switch ($this->is_approve) {
            case  0 :
            {
                $html .= '<a role="button" data-id="'. $this->id .'" href="' . Yii::getAlias('@backendUrl') . '/events/approve?id=' . $this->id . '" class="btn btn-table btn-success">Одобрить</a>';
                $html .= '<a role="button" data-id="'. $this->id .'" href="' . Yii::getAlias('@backendUrl') . '/events/disapprove?id=' . $this->id . '" class="btn btn-table btn-danger">Отклонить</a>';
                break;
            }
            case  1 :
            {
                $html .= '<a class="btn btn-table btn-warning" role="button">Одобрено</a><a role="button" data-id="'. $this->id .'" href="' . Yii::getAlias('@backendUrl') . '/events/disapprove?id=' . $this->id . '" class="btn btn-table btn-danger">Отклонить</a>';
                break;
            }
            case  2 :
            {
                $html .= '<a class="btn btn-table btn-danger" role="button">Отклонено</a>';
                break;
            }
        };

        $html .= '</div>';
        return $html;
    }

    public function getLike() {
        return Likes::find()->where(['object_id' => $this->id, 'object_type' => 2])->count();
    }

    public function getFirstCategory() {
        $cat = EventsCategory::findOne($this->category_id);

        return $cat->name;
    }

    public function getCompany() {
        $cat = Company::find()->where(['user_id' => $this->company_id])->one();
        if ($cat) {
            return $cat->organizationName;
        }
    }

    public function getCompanyName() {
        $cat = Company::find()->where(['user_id' => $this->company_id])->one();

        if ($cat) {
            return $cat->organizationName;
        }
    }

    public function getBooking()
    {
        return (int) EventsUsers::find()->where(['event_id' => $this->id])->count();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Компания',
            'category_id' => 'Категория',
            'title' => 'Заголовок',
            'address' => 'Адрес',
            'image' => 'Изображение',
            'text' => 'Текст',
            'date_start' => 'Дата начала',
            'date_end' => 'Дата конца',
            'created_at' => 'Созданно',
            'updated_at' => 'Обновленно',
            'is_active' => 'Активно',
            'is_approve' => 'Подтверждено',
        ];
    }
}

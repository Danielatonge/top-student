<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "discounts".
 *
 * @property int $id
 * @property int $company_id
 * @property string $title
 * @property int|null $category_id
 * @property int $type
 * @property string $sales
 * @property string|null $address
 * @property string|null $text
 * @property string|null $website
 * @property int|null $phone
 * @property int $is_active
 * @property int $is_approved
 */
class Discounts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'discounts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'title', 'slug'], 'required'],
            [['company_id', 'category_id', 'type', 'phone', 'is_active', 'is_approved', 'is_online', 'free', 'sale_type'], 'integer'],
            [['address', 'text', 'metro'], 'string'],
            [['created_at', 'updated_at', 'image', 'gallery', 'org_description', 'vk'], 'safe'],
            [['title', 'sales', 'website' , 'slug', 'promocode', 'preview'], 'string', 'max' => 255],
        ];
    }
    public function getAddress()
    {
        $address =  str_replace('Москва,', '', $this->address);
        $address =  str_replace('Москва ,', '', $address);
        $address =  str_replace('Москва', '', $address);

        return $address;
    }
    public function getSaleTypeName()
    {
        if ($this->sale_type == 1) {
//            return 'руб.'
        }
    }
    public static function isLiked($event, $user)
    {
        return Likes::find()->where(['user_id' => $user->id, 'object_id' => $event['id'], 'object_type' => 3])->one();
    }
    public function isLike($user_id)
    {
        return Likes::find()->where(['user_id' => $user_id, 'object_id' =>$this->id, 'object_type' => 3])->count();
    }
    public function getCompanyName() {
        $cat = Company::find()->where(['user_id' => $this->company_id])->one();

        if ($cat) {
            return $cat->organizationName;
        }
    }
    public function getCompanyData()
    {
        return Company::find()->where(['user_id' => $this->company_id])->one();
    }

    public function getAllMetro()
    {
        $metro = json_decode($this->metro, true);
        if (is_array($metro)) {
            $name = $metro[0];
            if (count($metro) > 1) {
                $name .= ' +' . (count($metro) -1);
            }
            return $name;
        }
    }

    public function getParentSlug()
    {
        $parent = Company::find()->where(['user_id' => $this->company_id])->one();

        if ($parent) return $parent->slug;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Компания',
            'title' => 'Заголовок',
            'category_id' => 'Категория',
            'type' => 'Тип',
            'sales' => 'Скидка',
            'address' => 'Адрес',
            'image' => 'Изображение',
            'text' => 'Текст',
            'website' => 'Сайт',
            'phone' => 'Телефон',
            'is_active' => 'Активна',
            'is_approved' => 'Подтверждена',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }
    public function getExcerptTitle() {
        $new  = iconv_substr (strip_tags($this->title), 0 , 45 , 'UTF-8');;

        if (mb_strlen(strip_tags($this->title)) > 45) {
            return $new .'..';
        } else {
            return $this->title;
        }
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

    private function strip_tags_content($text) {

        return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', strip_tags($text));

    }

    public function getStatus()
    {
        if ($this->is_approved == 1) {
            return 'Одобрено';
        } elseif ($this->is_approved == 2) {
            return 'Отклонено';
        } elseif ($this->is_approved == 0) {
            return 'Новая заявка';
        }
    }


    public function getAction()
    {
        $html = '<div class="table-grid">';
        switch ($this->is_approved) {
            case  0 :
            {
                $html .= '<a role="button" data-id="'. $this->id .'" href="' . Yii::getAlias('@backendUrl') . '/discounts/approve?id=' . $this->id . '" class="btn btn-table btn-success">Одобрить</a>';
                $html .= '<a role="button" data-id="'. $this->id .'" href="' . Yii::getAlias('@backendUrl') . '/discounts/disapprove?id=' . $this->id . '" class="btn btn-table btn-danger">Отклонить</a>';
                break;
            }
            case  1 :
            {
                $html .= '<a class="btn btn-table btn-warning" role="button">Одобрено</a><a role="button" data-id="'. $this->id .'" href="' . Yii::getAlias('@backendUrl') . '/discounts/disapprove?id=' . $this->id . '" class="btn btn-table btn-danger">Отклонить</a>';
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
        return Likes::find()->where(['object_id' => $this->id, 'object_type' => 3])->count();
    }

    public function getFirstCategory() {
        $cat = DiscountsCategory::findOne($this->category_id);

        return $cat->name;
    }

    public function getCompany() {
        $cat = Company::findOne($this->company_id);

        return $cat->organizationName;
    }

    public function getBooking()
    {
        return (int) DiscountsUsers::find()->where(['discounts_id' => $this->id])->count();
    }
}

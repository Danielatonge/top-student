<?php

namespace common\models;

use Yii;
use common\models\VacanciesUsers;
/**
 * This is the model class for table "vacancies".
 *
 * @property int $id
 * @property string $title
 * @property int $company_id
 * @property string $company_name
 * @property string|null $salary
 * @property string|null $text
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $image
 * @property int $is_active
 * @property int $is_approved
 */
class Vacancies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vacancies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'company_id', 'company_name', 'category_id' , 'slug'], 'required'],
            [['company_id', 'is_active', 'is_approved', 'category_id', 'is_online'], 'integer'],
            [['text', 'coords', 'metro'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'company_name', 'salary', 'slug',  'phone', 'image', 'preview'], 'string', 'max' => 255],
        ];
    }
    public function getCompanyName() {
        $cat = Company::find()->where(['user_id' => $this->company_id])->one();

        if ($cat) {
            return $cat->organizationName;
        }
    }
    public function checkUser()
    {
        return VacanciesUsers::find()->where(['vacancies_id' => $this->id, 'user_id' => \Yii::$app->user->id])->one();
    }

    public function getParentSlug()
    {
        $parent = Company::find()->where(['user_id' => $this->company_id])->one();

        if ($parent) return $parent->slug;
    }
    public static function isLiked($event, $user)
    {
        return Likes::find()->where(['user_id' => $user->id, 'object_id' => $event['id'], 'object_type' => 4])->one();
    }
    public function isLike($user_id)
    {
        return Likes::find()->where(['user_id' => $user_id, 'object_id' =>$this->id, 'object_type' => 4])->count();
    }
    public static function isJoin($event, $user)
    {
        return VacanciesUsers::find()->where(['user_id' => $user->id, 'vacancies_id' => $event['id']])->one();
    }
    public function getAddress()
    {
        $address =  str_replace('Москва,', '', $this->address);
        $address =  str_replace('Москва ,', '', $address);
        $address =  str_replace('Москва', '', $address);

        return $address;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'company_id' => 'Компания',
            'category_id' => 'Категория',
            'company_name' => 'Название компании',
            'salary' => 'Зарплата',
            'text' => 'Текст',
            'address' => 'Адрес',
            'phone' => 'Телефон',
            'image' => 'Изображение',
            'is_active' => 'Активна',
            'is_approved' => 'Подтверждена',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено'
        ];
    }
    public function getExcerptTitle() {
        $new  = iconv_substr ($this->strip_tags_content($this->title), 0 , 45 , 'UTF-8');;

        if (mb_strlen(strip_tags($this->title)) > 45) {
            return $this->strip_tags_content($new) .'..';
        } else {
            return $this->title;
        }
    }
    private function strip_tags_content($text) {

        return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', strip_tags($text));

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

    public function getAllMetro()
    {
        $metro = json_decode($this->metro, true);
        if ($metro[0]) {
            $name = $metro[0];
            if (count($metro) > 1) {
                $name .= ' +' . (count($metro) -1);
            }
            return $name;
        }
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
                $html .= '<a role="button" data-id="'. $this->id .'" href="' . Yii::getAlias('@backendUrl') . '/vacancies/approve?id=' . $this->id . '" class="btn btn-table btn-success">Одобрить</a>';
                $html .= '<a role="button" data-id="'. $this->id .'" href="' . Yii::getAlias('@backendUrl') . '/vacancies/disapprove?id=' . $this->id . '" class="btn btn-table btn-danger">Отклонить</a>';
                break;
            }
            case  1 :
            {
                $html .= '<a class="btn btn-table btn-warning" role="button">Одобрено</a><a role="button" data-id="'. $this->id .'" href="' . Yii::getAlias('@backendUrl') . '/vacancies/disapprove?id=' . $this->id . '" class="btn btn-table btn-danger">Отклонить</a>';
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
        return Likes::find()->where(['object_id' => $this->id, 'object_type' => 4])->count();
    }

    public function getFirstCategory() {
        $cat = VacanciesCategory::findOne($this->category_id);

        return $cat->name;
    }

    public function getCompany() {
        $cat = Company::findOne($this->company_id);

        return $cat->organizationName;
    }

    public function getBooking()
    {
        return (int) VacanciesUsers::find()->where(['vacancies_id' => $this->id])->count();
    }
}

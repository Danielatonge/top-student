<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property int $category_id
 * @property string $title
 * @property string|null $text
 * @property string|null $image
 * @property string $rules
 * @property string|null $date_start
 * @property string|null $date_end
 * @property string $created_at
 * @property string $updated_at
 * @property int $company_id
 * @property int $is_active
 * @property int $is_approved
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'title', 'rules', 'created_at', 'slug', 'company_id'], 'required'],
            [['category_id', 'company_id', 'is_active', 'is_approved'], 'integer'],
            [['text'], 'string'],
            [['date_start', 'date_end', 'created_at', 'updated_at', 'gallery'], 'safe'],
            [['title', 'image', 'rules', 'slug', 'preview'], 'string', 'max' => 255],
        ];
    }

    public static function isLiked($event, $user)
    {
        return Likes::find()->where(['user_id' => $user->id, 'object_id' => $event['id'], 'object_type' =>1])->one();
    }

    public function isLike($user_id)
    {
        return Likes::find()->where(['user_id' => $user_id, 'object_id' =>$this->id, 'object_type' => 1])->count();
    }

    public function getCompanyName() {
        $cat = Company::find()->where(['user_id' => $this->company_id])->one();

        if ($cat) {
            return $cat->organizationName;
        }
    }
    public function getParentSlug()
    {
        $parent = Company::find()->where(['user_id' => $this->company_id])->one();

        if ($parent) return $parent->slug;
    }
    public function getCompanyData()
    {
        return Company::find()->where(['user_id' => $this->company_id])->one();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'title' => 'Заголовок',
            'text' => 'Описание',
            'image' => 'Изображение',
            'rules' => 'Правила',
            'date_start' => 'Дата начала',
            'date_end' => 'Дата окончания',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
            'company_id' => 'Компания',
            'is_active' => 'Активна',
            'is_approved' => 'Одобрена',
        ];
    }

    public function getExcerpt($l = 140) {
        $l = 250;
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

    public function getExcerptTitle() {
        $new  = iconv_substr ($this->title, 0 , 45 , 'UTF-8');;

        if (mb_strlen($this->title) > 45) {
            return $new .'..';
        } else {
            return $this->title;
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
                $html .= '<a role="button" data-id="'. $this->id .'" href="' . Yii::getAlias('@backendUrl') . '/news/approve?id=' . $this->id . '" class="btn btn-table btn-success">Одобрить</a>';
                $html .= '<a role="button" data-id="'. $this->id .'" href="' . Yii::getAlias('@backendUrl') . '/news/disapprove?id=' . $this->id . '" class="btn btn-table btn-danger">Отклонить</a>';
                break;
            }
            case  1 :
            {
                $html .= '<a class="btn btn-table btn-warning" role="button">Одобрено</a><a role="button" data-id="'. $this->id .'" href="' . Yii::getAlias('@backendUrl') . '/news/disapprove?id=' . $this->id . '" class="btn btn-table btn-danger">Отклонить</a>';
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
        return Likes::find()->where(['object_id' => $this->id, 'object_type' => 1])->count();
    }

    public function getFirstCategory() {
        $cat = NewsCategory::findOne($this->category_id);

        return $cat->name;
    }

    public function getCompany() {
        $cat = Company::findOne($this->company_id);

        return $cat->organizationName;
    }
}

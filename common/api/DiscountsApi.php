<?php


namespace common\api;
use common\models\DiscountsCategory;
use common\models\DiscountsCategoryCategory;
use common\models\Events;
use common\models\User;
use common\models\Student;
use common\models\Company;
use common\models\Discounts;
use common\models\Likes;

class DiscountsApi
{
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function getOne($user, $id)
    {
        $data = Discounts::find()->where(['is_active' => 1, 'is_approved' => 1])->where(['id' => $id])->asArray()->all();
        $categories = $this->getCategoryMap();
        $company = $this->getCompanyMap();

        if ($data)
        {
            foreach ($data as $key => $item)
            {
                if ($item['image']) {
                    $image = json_decode($item['image'], true);
                    $data[$key]['image'] = str_replace('\\', '/', $image['base_url'] . $image['path']);
                }
                if ($categories[$item['category_id']]) {
                    $data[$key]['category_name'] = $categories[$item['category_id']]['name'];
                }
                $data[$key]['metro'] = json_decode($data[$key]['metro']);
                if (!is_array($data[$key]['metro'])) {
                    $data[$key]['metro'] = array('');
                }
                $data[$key]['address'] = json_decode($data[$key]['address']);
                if (!is_array($data[$key]['address'])) {
                    $data[$key]['address'] = array('');
                }
                $data[$key]['coords'] = json_decode($data[$key]['coords']);
                if (!is_array($data[$key]['coords'])) {
                    $data[$key]['coords'] = array('');
                }

                $data[$key]['like'] = Discounts::isLiked($item, $user) ? true : false;
                $data[$key]['likes'] = Likes::find()->where(['object_type' => 3, 'object_id' => $item['id']])->count();
                if ($company[$item['company_id']]) {
                    $_company = [];
                    foreach ($company[$item['company_id']] as $index => $c) {
                        $_company[$index . 'Сompany'] = $c;
                    }
                    $data[$key] = array_merge($data[$key], $_company);
                }
            }
        }

        return $data[0];
    }

    public function getDiscounts($user, $params)
    {
        $search = $params['search'];
        $offset = $params['offset'] ? $params['offset'] : 0;
        $limit = $params['limit'] ? $params['limit'] : 0;
        $category_id = $params['category'] ? $params['category'] : 0;
        $likes = $params['sort'] == 'like' ? 1 : 0;
        $data = Discounts::find()->where(['is_active' => 1, 'is_approved' => 1]);
        $categories = $this->getCategoryMap();
        $company = $this->getCompanyMap();

        if ($category_id) {
            $data = $data->andWhere(['category_id' => $category_id]);
        }
        if ($search) {
            $data = $data->andWhere(['LIKE','title', $search]);
        }
        $data = $data->orderBy('id desc');
        if (!$likes) {
            if ($offset) {
                $data = $data->offset($offset);
            }
            if ($limit) {
                $data = $data->limit($limit);
            }
        }

        $data = $data->asArray()->all();
        if ($data)
        {
            foreach ($data as $key => $item)
            {
                if ($item['image']) {
                    $image = json_decode($item['image'], true);
                    $data[$key]['image'] = str_replace('\\', '/', $image['base_url'] . $image['path']);
                }
                if ($categories[$item['category_id']]) {
                    $data[$key]['category_name'] = $categories[$item['category_id']]['name'];
                }
                $data[$key]['metro'] = json_decode($data[$key]['metro']);
                if (!is_array($data[$key]['metro'])) {
                    $data[$key]['metro'] = array('');
                }
                $data[$key]['address'] = json_decode($data[$key]['address']);
                if (!is_array($data[$key]['address'])) {
                    $data[$key]['address'] = array('');
                }
                $data[$key]['coords'] = json_decode($data[$key]['coords']);
                if (!is_array($data[$key]['coords'])) {
                    $data[$key]['coords'] = array('');
                }

                $data[$key]['like'] = Discounts::isLiked($item, $user) ? true : false;
                $data[$key]['likes'] = Likes::find()->where(['object_type' => 3, 'object_id' => $item['id']])->count();
                if ($company[$item['company_id']]) {
                    $_company = [];
                    foreach ($company[$item['company_id']] as $index => $c) {
                        $_company[$index . 'Сompany'] = $c;
                    }
                    $data[$key] = array_merge($data[$key], $_company);
                }
                $data[$key]['link'] = \Yii::getAlias('@frontendUrl'). '/'. $data[$key]['slugСompany'] .'/discounts/'. $data[$key]['id'];
            }
        }
        if ($likes) {
            usort($data, function($a, $b) {
                return strcmp($a['likes'], $b['likes']);
            });
            $data = array_reverse($data);
            if ($offset || $limit) {
                if (!$offset) $offset = 0;
                if ($limit) {
                    $data = array_values(array_slice($data, $offset, $limit, true));
                } else {
                    $data = array_values(array_slice($data, $offset));
                }
            }
        }
        return $data;
    }

    public function createDiscount($data)
    {
        if ($data) {
            $discount = new Discounts();
            foreach ($data as $key => $item) {
                if ($discount->hasAttribute($key)) {
                    $discount->{$key} = $item;
                }
            }
            if (!$discount->validate()) {
                $error = $discount->getErrors();
                return ['error' => $error];
            }
        }
        if ($discount->save(false)) {
            return Discounts::find()->where(['id' => $discount->id])->asArray()->one();
        } else {
            return ['error' => 'server error'];
        }
    }

    public function getCompanyMap()
    {
        $cats =  Company::find()->asArray()->all();
        $output = [];
        foreach ($cats as $key => $item) {
            unset($item['filials']);
            $output[$item['user_id']] = $item;
            unset( $output[$item['user_id']]['id']);
            unset( $output[$item['user_id']]['user_id']);
        }

        return $output;
    }

    public function getDiscountsCategory()
    {
        return DiscountsCategory::find()->where(['is_active' => 1])->asArray()->all();
    }

    public function getCategoryMap()
    {
        $cats =  DiscountsCategory::find()->asArray()->all();
        $output = [];
        foreach ($cats as $key => $item) {
            $output[$item['id']] = $item;
        }

        return $output;
    }

}

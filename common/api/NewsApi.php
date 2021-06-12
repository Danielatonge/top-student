<?php


namespace common\api;
use common\models\EventsCategory;
use common\models\News;
use common\models\NewsCategory;
use common\models\Likes;
use common\models\Company;

class NewsApi
{
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function getOne($user, $id)
    {
        $data = News::find()->where(['is_active' => 1, 'is_approved' => 1])->where(['id' => $id])->asArray()->all();
        $company = $this->getCompanyMap();
        $categories = $this->getCategoryMap();

        if ($data) {
            foreach ($data as $key => $item) {
                $data[$key]['date_start'] =  date('d.m.Y', strtotime($item['date_start']));
                if ($item['image']) {
                    $image = json_decode($item['image'], true);
                    $data[$key]['image'] = str_replace('\\', '/', $image['base_url'] . $image['path']);
                }
                if ($categories[$item['category_id']]) {
                    $data[$key]['category_name'] = $categories[$item['category_id']]['name'];
                }
                $data[$key]['metro'] = json_decode($data[$key]['metro']);
                $data[$key]['address'] = json_decode($data[$key]['address']);
                $data[$key]['coords'] = json_decode($data[$key]['coords']);
                $data[$key]['like'] = News::isLiked($item, $user) ? true : false;
                $data[$key]['likes'] = Likes::find()->where(['object_type' => 1, 'object_id' => $item['id']])->count();
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

    public function getNews($user, $params)
    {
        $search = $params['search'];
        $offset = $params['offset'] ? $params['offset'] : 0;
        $limit = $params['limit'] ? $params['limit'] : 0;
        $likes = $params['sort'] == 'like' ? 1 : 0;
        $category_id = $params['category'] ? $params['category'] : 0;
        $data = News::find()->where(['is_active' => 1, 'is_approved' => 1]);
        $company = $this->getCompanyMap();
        $categories = $this->getCategoryMap();

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

        if ($data) {
            foreach ($data as $key => $item) {
                $data[$key]['date_start'] =  date('d.m.Y', strtotime($item['date_start']));
                if ($item['image']) {
                    $image = json_decode($item['image'], true);
                    $data[$key]['image'] = str_replace('\\', '/', $image['base_url'] . $image['path']);
                }
                if ($categories[$item['category_id']]) {
                    $data[$key]['category_name'] = $categories[$item['category_id']]['name'];
                }
                $data[$key]['metro'] = json_decode($data[$key]['metro']);
                $data[$key]['address'] = json_decode($data[$key]['address']);
                $data[$key]['coords'] = json_decode($data[$key]['coords']);
                $data[$key]['like'] = News::isLiked($item, $user) ? true : false;
                $data[$key]['likes'] = Likes::find()->where(['object_type' => 1, 'object_id' => $item['id']])->count();
                if ($company[$item['company_id']]) {
                    $_company = [];
                    foreach ($company[$item['company_id']] as $index => $c) {
                        $_company[$index . 'Сompany'] = $c;
                    }
                    $data[$key] = array_merge($data[$key], $_company);
                }
                $data[$key]['link'] = \Yii::getAlias('@frontendUrl'). '/'. $data[$key]['slugСompany'] .'/news/'. $data[$key]['id'];
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
    public function getNewsCategory()
    {
        return NewsCategory::find()->where(['is_active' => 1])->asArray()->all();
    }
    public function getCategoryMap()
    {
        $cats =  NewsCategory::find()->asArray()->all();
        $output = [];
        foreach ($cats as $key => $item) {
            $output[$item['id']] = $item;
        }

        return $output;
    }
}

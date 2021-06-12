<?php


namespace common\api;
use common\models\Vacancies;
use common\models\VacanciesCategory;
use common\models\Likes;
use common\models\Company;
use common\models\VacanciesUsers;

class VacanciesApi
{
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function getOne($user, $id)
    {
        $data = Vacancies::find()->where(['is_active' => 1, 'is_approved' => 1])->where(['id' => $id])->asArray()->all();
        $categories = $this->getCategoryMap();
        $company = $this->getCompanyMap();

        if ($data) {
            foreach ($data as $key => $item) {
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
                $data[$key]['like'] = Vacancies::isLiked($item, $user) ? true : false;
                $data[$key]['join'] = Vacancies::isJoin($item, $user) ? true : false;
                $data[$key]['likes'] = Likes::find()->where(['object_type' => 4, 'object_id' => $item['id']])->count();
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

    public function getVacancies($user, $params)
    {
        $search = $params['search'];
        $offset = $params['offset'] ? $params['offset'] : 0;
        $limit = $params['limit'] ? $params['limit'] : 0;
        $type = $params['type'] == 'user' ? '1' : 0;
        $likes = $params['sort'] == 'like' ? 1 : 0;
        if ($type) {
            $list = VacanciesUsers::find()->select(['vacancies_id'])->where(['user_id' => $user->id])->column();
        }

        $category_id = $params['category'] ? $params['category'] : 0;
        $data = Vacancies::find()->where(['is_active' => 1, 'is_approved' => 1]);
        $categories = $this->getCategoryMap();
        $company = $this->getCompanyMap();

        if ($category_id) {
            $data = $data->andWhere(['category_id' => $category_id]);
        }
        if ($search) {
            $data = $data->andWhere(['LIKE','title', $search]);
        }
        if ($list) {
            $data = $data->andWhere(['IN','id', $list]);
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
                $data[$key]['like'] = Vacancies::isLiked($item, $user) ? true : false;
                $data[$key]['join'] = Vacancies::isJoin($item, $user) ? true : false;
                $data[$key]['likes'] = Likes::find()->where(['object_type' => 4, 'object_id' => $item['id']])->count();
                if ($company[$item['company_id']]) {
                    $_company = [];
                    foreach ($company[$item['company_id']] as $index => $c) {
                        $_company[$index . 'Сompany'] = $c;
                    }
                    $data[$key] = array_merge($data[$key], $_company);
                }
                $data[$key]['link'] = \Yii::getAlias('@frontendUrl'). '/'. $data[$key]['slugСompany'] .'/vacancies/'. $data[$key]['id'];
            }
        }
        if ($likes) {
            usort($data, function($a, $b) {
                return strcmp($a['likes'], $b['likes']);
            });
            $data = array_reverse($data);
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
        }

        return $data;
    }

    public function join($data)
    {
        $check = VacanciesUsers::find()->where(['user_id' =>  $this->user->id, 'vacancies_id' => $data['vacancy_id']])->one();
        if ($check) {
            $check->delete();
            $res = false;
        } else {
            $res = new VacanciesUsers();
            $res->user_id = (int)  $this->user->id;
            $res->vacancies_id = (int) $data['vacancy_id'];
            $res->save(false);
            $res = true;
        }

        return $res;
    }

    public function getVacanciesCategory()
    {
        return VacanciesCategory::find()->where(['is_active' => 1])->asArray()->all();
    }

    public function getCategoryMap()
    {
        $cats =  VacanciesCategory::find()->asArray()->all();
        $output = [];
        foreach ($cats as $key => $item) {
            $output[$item['id']] = $item;
        }

        return $output;
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

    public function createVacancy($data)
    {
        if ($data) {
            $event = new Vacancies();
            foreach ($data as $key => $item) {
                if ($event->hasAttribute($key)) {
                    $event->{$key} = $item;
                }
            }
            if (!$event->validate()) {
                $error = $event->getErrors();
                return ['error' => $error];
            }
        }
        if ($event->save(false)) {
            return Vacancies::find()->where(['id' => $event->id])->asArray()->one();
        } else {
            return ['error' => 'server error'];
        }
    }
}

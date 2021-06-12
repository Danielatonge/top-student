<?php

namespace common\api;

use common\models\Events;
use common\models\EventsCategory;
use common\models\Likes;
use common\models\Company;
use common\models\EventsUsers;

class EventsApi
{
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function getEventOne($user, $id)
    {
        $data = Events::find()->where(['is_active' => 1, 'is_approve' => 1, 'closed' => 0])->where(['id' => $id])->asArray()->all();
        $categories = $this->getCategoryMap();
        $company = $this->getCompanyMap();

        if ($data) {
            foreach ($data as $key => $item) {
                $data[$key]['date_start'] = date('d.m.Y', strtotime($item['date_start']));
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
                $data[$key]['like'] = Events::isLiked($item, $user) ? true : false;

                $data[$key]['join'] = Events::isJoin($item, $user) ? true : false;
                $data[$key]['likes'] = Likes::find()->where(['object_type' => 2, 'object_id' => $item['id']])->count();
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

    public function getEvents($user, $params)
    {
        $date = date('Y-m-d');

        $search = $params['search'];
        $offset = $params['offset'] ? $params['offset'] : 0;
        $limit = $params['limit'] ? $params['limit'] : 0;
        $type = $params['type'] == 'user' ? '1' : 0;
        $likes = $params['sort'] == 'like' ? 1 : 0;
        if ($type) {
            $list = EventsUsers::find()->select(['event_id'])->where(['user_id' => $user->id])->column();
        }

        $id = $params['id'];
        $category_id = $params['category'] ? $params['category'] : 0;
        $data = Events::find()->where(['is_active' => 1, 'is_approve' => 1, 'closed' => 0])->andWhere(['>=', 'date_start', $date]);
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

        $data = $data->orderBy('date_start asc');
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
                if ($data[$key]['link'] && $data[$key]['closed_registration']) {
                    $data[$key]['object_link'] = $data[$key]['link'];
                }
                $data[$key]['like'] = Events::isLiked($item, $user) ? true : false;

                $data[$key]['join'] = Events::isJoin($item, $user) ? true : false;

                $data[$key]['likes'] = Likes::find()->where(['object_type' => 2, 'object_id' => $item['id']])->count();
                if ($company[$item['company_id']]) {
                    $_company = [];
                    foreach ($company[$item['company_id']] as $index => $c) {
                        $_company[$index . 'Сompany'] = $c;
                    }
                    $data[$key] = array_merge($data[$key], $_company);
                }
                $data[$key]['link'] = \Yii::getAlias('@frontendUrl'). '/'. $data[$key]['slugСompany'] .'/events/'. $data[$key]['id'];
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

    public function join($data)
    {
        $check = EventsUsers::find()->where(['user_id' => $this->user->id, 'event_id' => $data['event_id']])->one();
        if ($check) {
            $check->delete();
            $res = false;
        } else {
            $res = new EventsUsers();
            $res->user_id = (int)  $this->user->id;
            $res->event_id = (int) $data['event_id'];
            $res->save(false);
            $res = true;
        }

        return $res;
    }

    public function getEventsCategory()
    {
        return EventsCategory::find()->where(['is_active' => 1])->asArray()->all();
    }


    public function getCategoryMap()
    {
        $cats =  EventsCategory::find()->asArray()->all();
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

    public function createEvent($data)
    {
        if ($data) {
            $event = new Events();
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
            return Events::find()->where(['id' => $event->id])->asArray()->one();
        } else {
            return ['error' => 'server error'];
        }
    }
}

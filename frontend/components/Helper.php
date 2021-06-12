<?php


namespace frontend\components;

use common\models\UserToken;
use Yii;
use yii\base\Component;
use common\models\KeyStorageItem;

class Helper extends Component
{
    public function putSEO($id = 0, $page_type = false)
    {
        $seo = KeyStorageItem::find()->where(['key' => 'app.seo'])->one();

        if ($seo) {
            $seo = json_decode($seo->value);
            if ($seo) {
                $html = '';

                foreach ($seo as $key => $item) {
                    if ($item) {
                        if ($key != 'title') {
                            $_key = $key;
                            $key = str_replace('twitter_', 'twitter:', $key);
                            $key = str_replace('og_', 'og:', $key);
                            $key = str_replace('fb_', 'fb:', $key);

                            if ($page_seo->{$_key}) {
                                $html .= "<meta property='" . $key . "' content='" . $page_seo->{$_key} . "' />";
                            } else {
                                $html .= "<meta property='" . $key . "' content='" . $item . "' />";
                            }
                        } else {
                            if ($page_seo->title) {
                                Yii::$app->view->params['seo_title'] = $page_seo->title;
                                $html .= "<title>" . $page_seo->title  .  "</title>";
                            } else {
                                Yii::$app->view->params['seo_title'] = $item;
                                $html .= "<title>" . $item  .  "</title>";
                            }
                        }
                    } elseif ($key == 'og_url' && !$page_seo->og_url) {
                        $key = str_replace('og_', 'og:', $key);
                        $html .= "<meta property='" . $key . "' content='" . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']
                            . explode('?', $_SERVER['REQUEST_URI'], 2)[0] . "' />";
                    }
                }
            }

            return $html;
        }
    }

    public function getMetro($value = false)
    {
        $json = file_get_contents('https://api.superjob.ru/2.0/suggest/town/4/metro/all/');
        $json = json_decode($json, true);
        $html = '';

        if ($json) {
            foreach ($json['objects'] as $key => $item)
            {
                if ($item['title'] == $value )  {
                    $checked = 'selected ';
                } else {
                    $checked = '';
                }
                $html .= '<option '.  $checked  . '  value="' . $item['title'] .'">' . $item['title'] .'</option>';
            }
        }

        return $html;
    }

    public function getMetroSelect()
    {
        $json = file_get_contents('https://api.superjob.ru/2.0/suggest/town/4/metro/all/');
        $json = json_decode($json, true);
        $html = '<select class="custom-select" name="metro[]"><option></option>';

        if ($json) {
            foreach ($json['objects'] as $key => $item)
            {
                $html .= '<option value="' . $item['title'] .'">' . $item['title'] .'</option>';
            }
        }

        $html .='</select>';

        return $html;
    }
}

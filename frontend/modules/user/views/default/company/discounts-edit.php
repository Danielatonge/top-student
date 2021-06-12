<?php

use common\base\MultiModel;
use trntv\filekit\widget\Upload;
use yii\bootstrap4\ActiveForm;
use yii\web\JsExpression;

$model = new MultiModel([
    'models' => [
        'pageData' => new \yii\base\DynamicModel([
            'gallery',
        ]),
    ]
]);
$model = $model->getModel('pageData');
$model->gallery = json_decode($sale->gallery);
?>
<script>
    var selectMetro =  '<?php    echo \Yii::$app->helper->getMetroSelect()   ?>'
</script>
<div class="row">
    <div class="col-md-12">
        <h1>Личный кабинет организации</h1>
    </div>
    <div class="col-md-2 sidebar">
        <?php if ($user->userInfo->logoImage) : ?>
            <div class="sidebar__logo">
                <img src="<?php echo $user->userInfo->logoImage; ?>">
            </div>
        <?php endif; ?>
        <div class="sidebar__links">
            <span><?php echo $user->userInfo->organizationName;  ?></span>
            <?php if ($user->userInfo->vkProfile) :
                $vk = str_replace('https://', '',  $user->userInfo->vkProfile);
                $vk = str_replace('http://', '',  $vk);
                ?>
                <a target="_blank" href="https://<?php echo $vk;  ?>"><?php echo $vk;  ?></a>
            <?php endif; ?>
        </div>
        <div class="sidebar__menu">
            <ul>
                <li><a href="/profile/events">Мероприятия</a></li>
                <li class="active"><a href="/profile/discounts">Скидки</a></li>
                <li><a href="/profile/vacancies">Вакансии</a></li>
                <li><a href="/profile/news">Новости</a></li>
                <li><a href="/profile">Профиль</a></li>
                <li><a href="/logout">Выйти</a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-10 account__box">
        <div class="main-menu-mobile">
            <a href="/profile/events"><span>Мероприятия</span></a>
            <a href="/profile/discounts"><span>Скидки</span></a>
            <a href="/profile/vacancies"><span>Вакансии</span></a>
            <a href="/profile/news"><span>Новости</span></a>
        </div>
        <div class="small-title-box small-title-box-form">
            <h2><?php echo $sale->title ?></h2>
        </div>
        <div class="element__box">
            <?php $form = ActiveForm::begin(
                ['options' => [
                    'enctype' => 'multipart/form-data', 'id' => 'dynamic-form-1',
                    'class' => 'form-page',
                    'method' => 'post'],
                ]); ?>
            <div class="form-input">
                <label>Название</label>
                <input maxlength="45" type="text" placeholder="Введите название cкидки" required value="<?php echo $sale->title ?>"
                       name="title">
                <label class="error-input"></label>
            </div>
            <div class="form-input">
                <label>Категория</label>
                <select class="custom-select" name="category" required>
                    <?php foreach ($category as $key => $item) : ?>
                        <option <?php if ($item->id == $sale->category_id) echo ' selected '; ?>
                                value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-input ">
                <label>Онлайн</label>
                <select class="custom-select" name="online" required>
                    <option value="0">Нет</option>
                    <option <?php if($sale->is_online): ?> selected="selected" <?php endif; ?> value="1">Да</option>
                </select>
            </div>
            <?php
            $address = json_decode($sale->address, true);
            $metro = json_decode($sale->metro, true);
            $coords = json_decode($sale->coords, true);
            ?>
            <div <?php if ($sale->is_online) :?> style="display: none" <?php endif; ?> class="address-wrapper">
                <div class="row address-box">
                    <?php if ($address) : ?>
                        <?php foreach ($address as $key => $item) : ?>
                            <div class="col-md-6">
                                <div class="form-input">
                                    <label>Метро</label>
                                    <select class="custom-select" name="metro[]">
                                        <option></option>
                                        <?php echo \Yii::$app->helper->getMetro( $metro[$key]); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-input">
                                    <label>Адрес (без метро)</label>
                                    <input type="text" placeholder="Введите адрес" value="<?php echo $item ?>"
                                           name="address[]">
                                    <input type="hidden" value="<?php echo $coords[$key] ?>" name="coords[]">
                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="col-md-6">
                            <div class="form-input">
                                <label>Адрес (без метро)</label>
                                <input type="text" placeholder="Введите адрес" name="address[]">
                                <input type="hidden" name="coords[]">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-input">
                                <label>Метро</label>
                                <select class="custom-select" name="metro[]">
                                    <option></option>
                                    <?php echo \Yii::$app->helper->getMetro(); ?>
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="file-repeater"> + Добавить адрес</div>
            </div>
            <div class="form-input" style="margin-top: 10px">
                <label class="control control-checkbox">
                    Бесплатно
                    <input type="checkbox" <?php if ($sale->free) echo ' checked ' ?> name="free"/>
                    <div class="control_indicator"></div>
                </label>
            </div>
            <div class="form-input">
                <label>Скидка <span>(укажите %)</span></label>
                <input value="<?php echo $sale->sales ?>" <?php if ($sale->free): echo ' disabled '; else : echo 'required';  endif;?> maxlength="22" placeholder="Введите скидку" name="sales">
            </div>
            <div class="form-input">
                <label>Тип скидки</span></label>
                <select class="custom-select" name="sale_type" required>
                    <option value="0">%</option>
                    <option <?php if($sale->sale_type == 1): ?> selected="selected" <?php endif; ?> value="1">руб.</option>
                    <option <?php if($sale->sale_type == 2): ?> selected="selected" <?php endif; ?> value="2">Текстовая акция</option>
                </select>
            </div>
            <div class="form-input ">
                <label>Скидка предоставляется</label>
                <div class="checkbox-box">
                    <label class="control control-checkbox">
                        По студенческому билету
                        <input <?php if ($sale->type == 2) echo ' checked ' ?> type="radio" name="type" value="2">
                        <div class="control_indicator"></div>
                    </label>
                    <label class="control control-checkbox">
                        Промокод TopStudents
                        <input <?php if ($sale->type == 1) echo ' checked ' ?> type="radio" name="type" value="1"
                                                                               />
                        <div class="control_indicator"></div>
                    </label>
                </div>
            </div>

            <div <?php if ($sale->type == 2) : ?> style="display: none" <?php endif; ?>  class="form-input">
                <label>Промокод</label>
                <input value="<?php echo $sale->promocode ?>" placeholder="Введите скидку" name="promocode">
            </div>


            <div class="form-input">
                <label>Описание скидки</label>
                <textarea required placeholder="Введите описания скидки"
                          name="text"><?php echo $sale->text ?></textarea>
            </div>
            <div class="form-input">
                <label>Название организации</label>
                <input type="text" placeholder="Введите адрес сайта"
                       value="<?php echo \Yii::$app->user->identity->userInfo->organizationName ?>"
                       name="organizationName">
            </div>
            <div class="form-input">
                <label>Описание организации</label>
                <textarea required placeholder="Введите описание организации"
                          name="org_description"><?php echo \Yii::$app->user->identity->userInfo->description ?></textarea>
            </div>
            <div class="form-input">
                <label>Сайт</label>
                <input type="text" placeholder="Введите адрес сайта"
                       value="<?php echo \Yii::$app->user->identity->userInfo->website ?>" name="website">
            </div>
            <div class="form-input">
                <label>Телефон организации</label>
                <input type="text" placeholder="Введите телефон"
                       value="<?php echo \Yii::$app->user->identity->userInfo->phoneNumber ?>" name="phone">
            </div>
            <div class="form-input">
                <label>Вконтакте организации</label>
                <input type="text" placeholder="Введите ссылку на соц сети"
                       value="<?php echo \Yii::$app->user->identity->userInfo->vkProfile ?>" name="vk">
            </div>
            <div class="form-input">
                <label>Загрузить фото скидки</label>
                <div class="file-btn">Изменить обложку</div>
                <input style="display: none" type="file" name="image">
                <input  type="text" class="hidden-preview-input" value="<?php echo $sale->preview ?>" required  name="preview">
                <input type="hidden" value="<?php echo $sale->image ?>" name="image_file">
                <img class="profile-image" src="<?php echo $sale->preview ?>"
                     id="image_cropper" <?php if (!$sale->preview) : ?> style="display: none;" <?php endif; ?> ">
                <div style="display: none" class="crop-image">Обрезать</div>
            </div>
            <div class="form-input">
                <label>Добавить фотографии</label>
                <?php echo $form->field($model, 'gallery')->widget(
                    Upload::class,
                    [
                        'url' => ['/storage/upload'],
                        'maxFileSize' => 5000000, // 5 MiB,
                        'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
                        'maxNumberOfFiles' => 10,
                    ])->label(false);
                ?>
            </div>
            <div class="form-input-submit">
                <button type="submit">Сохранить изменения</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<style>
    .select2-container {
        width: 100% !important;
    }
</style>

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
$model->gallery = json_decode($news->gallery);
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
        <div class="account__box_buttons account__box_buttons-form">
            <a href="#" class="btn account__box_buttons-btn btn-red b">Добавить скидку</a>
            <a href="/profile/discounts" class="btn account__box_buttons-btn btn-white">Скидки организации</a>
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
                <input maxlength="45" type="text" placeholder="Введите название cкидки" required name="title">
                <label class="error-input"></label>
            </div>
            <div class="form-input">
                <label>Категория</label>
                <select class="custom-select" name="category" required>
                    <?php foreach ($category as $key => $item) : ?>
                        <option value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-input ">
                <label>Онлайн</label>
                <select class="custom-select" name="online" required>
                    <option value="0">Нет</option>
                    <option value="1">Да</option>
                </select>
            </div>
            <div class="address-wrapper">
                <div class="row address-box">
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
                </div>
                <div class="file-repeater"> + Добавить адрес</div>
            </div>
            <div class="form-input" style="margin-top: 10px">
                <label class="control control-checkbox">
                    Бесплатно
                    <input type="checkbox"  name="free"/>
                    <div class="control_indicator"></div>
                </label>
            </div>
            <div class="form-input">
                <label>Скидка <span>(укажите %)</span></label>
                <input required maxlength="22" placeholder="Введите скидку" name="sales">
            </div>
            <div class="form-input">
                <label>Тип скидки</span></label>
                <select class="custom-select" name="sale_type" required>
                    <option value="0">%</option>
                    <option value="1">руб.</option>
                    <option value="2">Текстовая акция</option>
                </select>
            </div>
            <div class="form-input ">
                <label>Скидка предоставляется</label>
                <div class="checkbox-box">
                    <label class="control control-checkbox">
                        По студенческому билету
                        <input type="radio" name="type"  checked="checked" value="2">
                        <div class="control_indicator"></div>
                    </label>
                    <label class="control control-checkbox">
                        Промокод TopStudents
                        <input type="radio" name="type" value="1"/>
                        <div class="control_indicator"></div>
                    </label>

                </div>
            </div>
            <div style="display: none"  class="form-input">
                <label>Промокод</label>
                <input required value="TopStudents" placeholder="Введите скидку" name="promocode">
            </div>
            <div class="form-input">
                <label>Описание скидки</label>
                <textarea required placeholder="Введите описания скидки" name="text"></textarea>
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
                <div class="file-btn">Добавить обложку</div>
                <input style="display: none" type="file" name="image">
                <input  type="text" class="hidden-preview-input" required  name="preview">
                <input type="hidden" name="image_file">
                <img class="profile-image" id="image_cropper" style="display: none;" ">
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
                <button type="submit">Опубликовать скидку</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

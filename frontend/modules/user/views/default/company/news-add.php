<?php

use common\base\MultiModel;
use yii\bootstrap4\ActiveForm;
use yii\web\JsExpression;
use trntv\filekit\widget\Upload;
use kartik\select2\Select2;

$model = new MultiModel([
    'models' => [
        'pageData' => new \yii\base\DynamicModel([
            'gallery',
        ]),
    ]
]);
$model = $model->getModel('pageData');
?>
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
                <li><a href="/profile/discounts">Скидки</a></li>
                <li><a href="/profile/vacancies">Вакансии</a></li>
                <li class="active"><a href="/profile/news">Новости</a></li>
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
            <a href="#" class="btn account__box_buttons-btn btn-red b">Добавить новость</a>
            <a href="/profile/news" class="btn account__box_buttons-btn btn-white">Новости организации</a>
        </div>
        <div class="element__box">
            <?php $form = ActiveForm::begin(
                ['options' => [
                    'enctype' => 'multipart/form-data', 'id' => 'dynamic-form-1',
                    'class' => 'form-page',
                    'method' => 'post'],
                ]); ?>
            <!--            <form class="form-page" method="POST" enctype="multipart/form-data">-->
            <div class="form-input">
                <label>Название новости</label>
                <input maxlength="45" type="text" placeholder="Введите название новости" required name="title">
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
            <div class="form-input">
                <label>Текст статьи</label>
                <textarea required placeholder="Введите описания скидки" name="text"></textarea>
            </div>

            <div class="form-input">
                <label>Загрузить фото к статье</label>
                <div class="file-btn">Добавить обложку</div>
                <input style="display: none" type="file" name="image">
                <input  type="text" class="hidden-preview-input"  required  name="preview">
                <input type="hidden" name="image_file">
                <img class="profile-image" id="image_cropper" style="display: none;" ">
                <div style="display: none" class="crop-image">Обрезать</div>
            </div>
            <div class="form-input">
                <label>Загрузить фото к статье</label>
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
                <button type="submit">Опубликовать новость</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

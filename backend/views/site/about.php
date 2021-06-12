<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use trntv\yii\datetime\DateTimeWidget;
use common\base\MultiModel;
use trntv\filekit\widget\Upload;
use yii\web\JsExpression;


$this->title = 'Страница - О нас';

$model = new MultiModel([
    'models' => [
        'banner' => new \yii\base\DynamicModel([
            'text', 'link', 'image', 'fb','vk','tw',
            'site_title', 'site_description'
        ]),
    ]
]);

$model = $model->getModel('banner');
$fields = $model->fields();
foreach ($fields as $key => $item) {
    if (isset($data->{$item})) {
        $model->{$item} = $data->{$item};
    }
}
?>
<div class="page-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],
        'id' => 'dynamic-form-1',
    ]); ?>
    <div class="nav-tabs-custom nav-tabs-in">
        <div class="tab-content">
            <div class="active tab-pane" id="contentPage">
                <div class="nav-tabs-custom margin-minus-10">
                    <div class="tab-content">
                        <div class="row">
                            <div class="col-md-6">
                                <style>
                                    textarea {
                                        height: 300px !important;
                                    }
                                </style>
                                <?= $form->field($model, 'text')->textarea()->label('Текст') ?>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'link')->textInput()->label('Ссылка YouTube') ?>
                            </div>

                            <div class="col-md-12">
                                <?php echo $form->field($model, 'image')->widget(
                                    Upload::class,
                                    [
                                        'url' => ['/file/storage/upload'],
                                        'maxFileSize' => 5000000, // 5 MiB,
                                        'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
                                    ])->label('Изображение');
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="form-group margin-top-30">
        <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>

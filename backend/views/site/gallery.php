<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use common\base\MultiModel;
use trntv\filekit\widget\Upload;
use yii\web\JsExpression;

$this->title = 'Фото галерея';

$model = new MultiModel([
    'models' => [
        'error' => new \yii\base\DynamicModel([
            'gallery'
        ]),
    ]
]);


$model = $model->getModel('error');
$model->gallery = $data->gallery;

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

                        <div class="active tab-pane" id="firstBlock">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php echo $form->field($model, 'gallery')->widget(
                                        Upload::class,
                                        [
                                            'url' => ['/file/storage/upload'],
                                            'maxFileSize' => 5000000, // 5 MiB,
                                            'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
                                            'maxNumberOfFiles' => 12
                                        ])->label(false);
                                    ?>
                                </div>
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


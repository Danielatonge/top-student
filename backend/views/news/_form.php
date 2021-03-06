<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\web\JsExpression;
use trntv\filekit\widget\Upload;
use kartik\datetime\DateTimePicker;
/**
 * @var yii\web\View $this
 * @var common\models\News $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="news-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?php echo $form->errorSummary($model); ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->field($model, 'category_id')->dropDownList($category) ?>
                </div>
                <div class="col-md-12">
                    <?php echo $form->field($model, 'text')->textarea(['class' => 'tinymce']) ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->field($model, 'image')->widget(
                        Upload::class,
                        [
                            'url' => ['/file/storage/upload'],
                            'maxFileSize' => 5000000, // 5 MiB,
                            'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
                        ]);
                    ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->field($model, 'rules')->textarea(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->field($model, 'date_start')->widget(
                        DateTimePicker::class,
                        [
                            'type' => DateTimePicker::TYPE_INLINE,
                            'pluginOptions' => [
                                'format' => 'yyyy-mm-dd HH:mm:ss',
                                'showMeridian' => true,
                                'todayBtn' => true,
                            ]
                        ]
                    ) ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->field($model, 'date_end')->widget(
                        DateTimePicker::class,
                        [
                            'type' => DateTimePicker::TYPE_INLINE,
                            'pluginOptions' => [
                                'format' => 'yyyy-mm-dd HH:mm:ss',
                                'showMeridian' => true,
                                'todayBtn' => true,
                            ]
                        ]
                    ) ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->field($model, 'company_id')->dropDownList($company) ?>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <?php echo $form->field($model, 'is_active')->checkbox() ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->field($model, 'is_approved')->checkbox() ?>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <?php echo Html::submitButton('??????????????????', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

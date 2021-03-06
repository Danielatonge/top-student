<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\web\JsExpression;
use trntv\filekit\widget\Upload;
use kartik\datetime\DateTimePicker;
/**
 * @var yii\web\View $this
 * @var common\models\Vacancies $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="vacancies-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="card-body row">
                <div class="col-md-12">
                    <?php echo $form->errorSummary($model); ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->field($model, 'category_id')->dropDownList($category) ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->field($model, 'company_id')->dropDownList($company) ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->field($model, 'salary')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-12">
                    <?php echo $form->field($model, 'text')->textarea(['class' => 'tinymce']) ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
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
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <?php echo $form->field($model, 'is_active')->checkbox() ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->field($model, 'is_approved')->checkbox() ?>
                </div>
            </div>
            <div class="card-footer">
                <?php echo Html::submitButton('??????????????????', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>

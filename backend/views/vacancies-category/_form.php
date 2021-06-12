<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\NewsCategory $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="news-category-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?php echo $form->errorSummary($model); ?>
                </div>
                <div class="col-md-12">
                    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-12">
                    <?php echo $form->field($model, 'text')->textarea(['maxlength' => true]) ?>
                </div>
                <div class="col-md-12">
                    <?php echo $form->field($model, 'is_active')->checkbox() ?>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <?php echo Html::submitButton('Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

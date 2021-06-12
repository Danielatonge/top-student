<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\models\Logs $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="logs-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="card-body">
                <?php echo $form->errorSummary($model); ?>

                <?php echo $form->field($model, 'datetime')->textInput() ?>
                <?php echo $form->field($model, 'status_code')->textInput() ?>
                <?php echo $form->field($model, 'url')->textInput() ?>
                <?php echo $form->field($model, 'response')->textInput() ?>
                <?php echo $form->field($model, 'body')->textarea(['rows' => 6]) ?>
                <?php echo $form->field($model, 'headers')->textarea(['rows' => 6]) ?>
                
            </div>
            <div class="card-footer">
                <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>

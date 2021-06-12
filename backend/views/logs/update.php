<?php

/**
 * @var yii\web\View $this
 * @var backend\models\Logs $model
 */

$this->title = 'Update Logs: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="logs-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

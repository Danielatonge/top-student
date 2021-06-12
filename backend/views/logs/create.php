<?php

/**
 * @var yii\web\View $this
 * @var backend\models\Logs $model
 */

$this->title = 'Create Logs';
$this->params['breadcrumbs'][] = ['label' => 'Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logs-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

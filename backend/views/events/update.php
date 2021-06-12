<?php

/**
 * @var yii\web\View $this
 * @var common\models\Events $model
 */

$this->title = 'Обновить мероприятие: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Мероприятие', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="events-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'category' => $category,
        'company'  => $company
    ]) ?>

</div>

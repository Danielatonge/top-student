<?php

/**
 * @var yii\web\View $this
 * @var common\models\EventsCategory $model
 */

$this->title = 'Создать категорию';
$this->params['breadcrumbs'][] = ['label' => 'Категории мероприятий', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="events-category-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

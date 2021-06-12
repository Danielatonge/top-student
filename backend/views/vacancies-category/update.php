<?php

/**
 * @var yii\web\View $this
 * @var common\models\VacanciesCategory $model
 */

$this->title = 'Обновить категорию: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории вакансий', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="vacancies-category-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

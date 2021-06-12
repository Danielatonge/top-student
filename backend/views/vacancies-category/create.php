<?php

/**
 * @var yii\web\View $this
 * @var common\models\VacanciesCategory $model
 */

$this->title = 'Создать категорию';
$this->params['breadcrumbs'][] = ['label' => 'Категории вакансий', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vacancies-category-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

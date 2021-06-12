<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var common\models\search\VacanciesSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Вакансии';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vacancies-index">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
        </div>

        <div class="card-body p-0">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
            <?php echo GridView::widget([
                'layout' => "{items}\n{pager}",
                'options' => [
                    'class' => ['gridview', 'table-responsive'],
                ],
                'tableOptions' => [
                    'class' => ['table', 'text-nowrap', 'table-striped', 'table-bordered', 'mb-0'],
                ],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'label' => 'Статус',
                        'format' => 'html',
                        'content' => function ($model) {
                            return $model->getStatus();
                        }
                    ],
                    [
                        'label' => 'Действие',
                        'format' => 'html',
                        'value' => function ($model) {
                            return $model->getAction();
                        }
                    ],
                    'title',

                    [
                        'label' => 'Категория',
                        'format' => 'html',
                        'content' => function ($model) {
                            return $model->firstCategory;
                        }
                    ],
                    [
                        'label' => 'Организация',
                        'format' => 'html',
                        'content' => function ($model) {
                            return $model->company;
                        }
                    ],
                    'address',
                    [
                        'label' => 'Количество участников',
                        'format' => 'html',
                        'content' => function ($model) {
                            return $model->booking;
                        }
                    ],
                    
                    ['class' => \common\widgets\ActionColumn::class],
                ],
            ]); ?>
    
        </div>
        <div class="card-footer">
            <?php echo getDataProviderSummary($dataProvider) ?>
        </div>
    </div>

</div>

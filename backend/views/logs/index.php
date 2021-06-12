<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var backend\models\search\LogsSearchModel $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Логи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logs-index">
    <div class="card">
                <div class="card-header">
                    <?php echo Html::a('Очистить все', ['clear'], ['class' => 'btn btn-success']) ?>
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

//                    'id',
                    'datetime',
                    'status_code',
                    'url:url',
                    'token',
                    'method',
                    // 'response',
                    // 'body:ntext',
                    // 'headers:ntext',

                    ['class' => \common\widgets\ActionColumn::class,
                        'template' => '{view} {delete}'
                    ],
                ],
            ]); ?>
    
        </div>
        <div class="card-footer">
            <?php echo getDataProviderSummary($dataProvider) ?>
        </div>
    </div>

</div>

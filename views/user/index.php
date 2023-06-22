<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered',
            'id' => 'table',
            'data-toggle' => 'table',
            'data-search' => 'true',
            'data-filter-control' => 'true',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'username',
                'label' => 'username',
                'format' => 'text',
                'headerOptions' => [
                    'data-field' => 'username',
                    'data-filter-control' => 'input',
                    'data-sortable' => 'true',
                ]
            ],
            [
                'attribute' => 'first_name',
                'label' => 'first_name',
                'format' => 'text',
                'headerOptions' => [
                    'data-field' => 'first_name',
                    'data-filter-control' => 'input',
                    'data-sortable' => 'true',
                ]
            ],
            //'created_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

</div>
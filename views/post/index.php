<?php

use app\models\Post;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->can('createPostPermission')): ?>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
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
            'id',
            'title',
            'body:ntext',
            [
                'label' => 'Author',
                'attribute' => 'author.first_name',
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Post $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                'visibleButtons' => [
                    'update' => function ($model, $key, $index) {
                        return \Yii::$app->user->can('updatePostPermission', ['post_id' => $model->id]);
                    },
                    'delete' => function ($model, $key, $index) {
                        return \Yii::$app->user->can('deletePostPermission', ['post_id' => $model->id]);
                    },
                ],
            ],
        ],
    ]); ?>


</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\RoleForm $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="role-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'name' => $model->name], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'name' => $model->name], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description:ntext',
            [
                'attribute' => 'permissions',
                'format' => 'html',
                'value' => function ($model) {
                    $html = '';
                    foreach ($model->permissions as $permission){
                        $html .= "<span class='badge bg-secondary'>$permission</span> ";
                    }
                    return $html;
                },
                //'visible' => \Yii::$app->user->can('posts.owner.view'),
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>

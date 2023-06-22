<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\RoleForm $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>
<style>
    .form-check {
        width: 250px;
        float:left;
    }
</style>
<div class="role-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'parent')->dropDownList($model->getRoles(), ['prompt'=>'Select Parent role']) ?>
    <?= $form->field($model, 'permissions')->checkboxList($model->getPermissions()) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

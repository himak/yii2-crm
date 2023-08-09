<?php

use app\enums\Status;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')
        ->dropDownList([
            '0' => 'Deactivated',
            '1' => 'Active'
        ],
        ['prompt'=>'Select status']
    )?>

    <?= $form->field($model, 'role')
        ->dropDownList([
            'USER' => 'USER',
            'ADMIN' => 'ADMIN',
        ],
        ['prompt'=>'Select role']
    )?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

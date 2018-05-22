<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Изменение пароля';
$this->params['breadcrumbs'][] = ['label' => 'Профиль', 'url' => '/profile'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-update-password">
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <div class="form-account-container">
                <h1><?= Html::encode($this->title) ?></h1>
                <?php $form = ActiveForm::begin(['id' => 'update-password-form']); ?>

                    <?= $form->field($model, 'currentPassword')->passwordInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'newPassword')->passwordInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'newPasswordRepeat')->passwordInput(['maxlength' => true]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \yii\jui\DatePicker;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <div class="form-account-container">
                <h1><?= Html::encode($this->title) ?></h1>
                <p>Пожалуйста, заполните следующие поля для регистрации:</p>
                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                    <?= $form->field($model, 'username')->textInput() ?>
                
                    <?= $form->field($model, 'firstname') ?>
                
                    <?= $form->field($model, 'surname') ?>

                    <?= $form->field($model, 'email') ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>
                
                    <?= $form->field($model, 'sex_id')->dropDownList([
                            '1' => 'Мужчина',
                            '2' => 'Женщина'
                        ],
                        [
                            'prompt' => 'Укажите Ваш пол', 
                    ]) ?>
                
                    <?= $form->field($model, 'birthday')->widget(DatePicker::classname(), [
                        'language' => 'ru',
                        'dateFormat' => 'yyyy-MM-dd',
                        'clientOptions' => [ 
                            'yearRange' => '1930:2018',
                            'changeMonth' => 'true',
                            'changeYear' => 'true',
                            'firstDay' => '1',
                        ]
                    ]) ?>
                
                    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
                
                    <?= $form->field($model, 'avatar')->fileInput() ?>

                    <div class="form-group">
                        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

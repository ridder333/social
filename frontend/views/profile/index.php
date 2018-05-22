<?php

/* @var $this yii\web\View */
/* @var $user \common\models\User */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Профиль';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-index">
    <h1>Профиль пользователя <?= $user->firstname . ' ' . $user->surname ?></h1>
    
    <div class="row">
        <div class="col-sm-3 user-block">
            <a href="#">
                <img src="/images/users/<?= is_null($user->avatar) ? 'nophoto.jpg' : $user->id . '/' . $user->avatar->name ?>" alt="<?= $user->firstname . ' ' . $user->surname ?>" title="<?= $user->firstname . ' ' . $user->surname ?>" class="img-responsive avatar">
            </a>
        </div>
        <div class="col-sm-9 user-info">
            <div>Возраст: <?= date_diff(new Datetime(), new Datetime($user->birthday))->y  ?></div>
            <div>Пол: <?= $user->sex_id == 1 ? 'мужской' : 'женский' ?></div>
            <div>Дата создания аккаунта: <?= date('d.m.Y', $user->created_at) ?></div>
            <?= Html::a('Редактировать профиль', ['update'], ['class' => 'btn btn-primary']) ?><br>
            <?= Html::a('Сменить пароль', ['update-password'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    
    <h2>О себе</h2>
    <div><?= is_null($user->description) ? 'Пока что о себе нет никакой информации.' : $user->description ?></div>
    
    <h2>Все фото</h2>
    <?php $form = ActiveForm::begin(['action' => ['upload-image'], 'id' => 'form-upload-image']); ?>
        <?= $form->field($image, 'avatar')->fileInput() ?>
        <div class="form-group">
            <?= Html::submitButton('Добавить фото', ['class' => 'btn btn-primary', 'name' => 'upload-image-button']) ?>
        </div>
    <?php ActiveForm::end(); ?>
    
    <?php if (count($user->images)) { ?>
        <div class="row gallery">
            <?php foreach($user->images as $image) { ?>
                <div class="col-sm-4 user-block">
                    <div class="image-container">
                        <img src="/images/users/<?= $user->id . '/' . $image->name ?>" class="img-responsive avatar">
                        <div>
                            <?= Html::a(Html::img('/images/avatar.png'), ['update-avatar'], ['data' => [
                                    'method' => 'post',
                                    'params' => [
                                        'id' => $image->id,
                                    ]
                                ],
                                'title' => 'Сделать главным фото',
                            ]) ?>
                            
                            <?= Html::a(Html::img('/images/delete.png'), ['delete-image'], ['data' => [
                                    'method' => 'post',
                                    'confirm' => 'Вы уверены, что хотите удалить это фото?',
                                    'params' => [
                                        'id' => $image->id,
                                    ],
                                ],
                                'title' => 'Удалить фото',
                            ]) ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p>Пользователь еще не добавил фотографий.</p>
    <?php } ?>
</div>
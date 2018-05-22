<?php

/* @var $this yii\web\View */
/* @var $user \common\models\User */

use yii\helpers\Html;

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
            <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->id != $user->id) { ?>
                <?= Html::a('Написать сообщение', ['/message/' . $user->id], ['class' => 'btn btn-primary', 'name' => 'get-chat', 'data-user-id' => $user->id]) ?>
            <?php } ?>
        </div>
    </div>
    
    <h2>О себе</h2>
    <div><?= is_null($user->description) ? 'Пока что о себе нет никакой информации.' : $user->description ?></div>
    
    <h2>Все фото</h2>
    <?php if (count($user->images)) { ?>
        <div class="row gallery">
            <?php foreach($user->images as $image) { ?>
                <div class="col-sm-4 user-block">
                    <div class="image-container">
                        <img src="/images/users/<?= $user->id . '/' . $image->name ?>" class="img-responsive avatar">
                        <div></div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p>Пользователь еще не добавил фотографий.</p>
    <?php } ?>
</div>
<?php

/* @var $model \common\models\User */

?>
<div class="col-sm-3 user-block">
    <a href="/user/<?= $model->id ?>">
        <img src="/images/users/<?= is_null($model->avatar) ? 'nophoto.jpg' : $model->id . '/' . $model->avatar->name ?>" 
             alt="<?= $model->firstname . ' ' . $model->surname ?>" 
             class="img-responsive avatar">
        <div>
            <span><?= $model->firstname . ' ' . $model->surname ?></span>
        </div>
    </a>
</div>
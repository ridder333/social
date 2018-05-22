<?php

/* @var $model \common\models\User */
/* @var $authUserId integer */
/* @var $companion \common\models\User */

?>
<div class="message <?= $model->from_user_id == $authUserId ? 'message-from' : 'message-to' ?> <?= !$model->is_read && ($model->from_user_id != $authUserId) ? 'not-read' : '' ?>">
    <div class="message-author">
        <a href="/user?id=<?= $model->from_user_id == $authUserId ? $authUserId : $companion->id ?>">
            <?= $model->from_user_id == $authUserId ? 'Вы' : $companion->firstname . ' ' . $companion->surname ?>
        </a>
        <span class="not-read-label"><?= !$model->is_read && ($model->from_user_id != $authUserId) ? '(не прочитано)' : '' ?></span>
    </div>
    <?= $model->text ?>
    <div class="message-date"><?= $model->created_at ?></div>
</div>
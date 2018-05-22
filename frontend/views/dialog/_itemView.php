<?php

/* @var $dialog array */

?>
<a href="/message/<?= $dialog['companionId'] ?>">
    <div class="message">
        <div class="row">
            <div class="col-sm-3 col-lg-2 dialog-avatar">
                <img src="/images/users/<?= $dialog['companionAvatar'] ?>" 
                     alt="<?= $dialog['companionName'] ?>" 
                     title="<?= $dialog['companionName'] ?>" 
                     class="img-responsive avatar">
            </div>
            <div class="col-sm-9 col-lg-10">
                <div class="message-author">
                    <?= $dialog['companionName'] ?>
                </div>
                <?= $dialog['lastMessage'] ?>
                <div class="message-date"><?= $dialog['lastMessageTime'] ?></div>
            </div>
        </div>
    </div>
</a>
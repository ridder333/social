<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\widgets\ListView;
use kop\y2sp\ScrollPager;
use frontend\components\SocialHelper;

$this->title = 'Диалоги';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-index">
    <h1>Диалоги</h1>
    <?php if ($dataProvider->getTotalCount()) { ?>
        <div class="dialogs">
            
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => [
                    'class' => 'item',
                ],
                'itemView' => function($model, $key, $index, $widget) {
                    return $this->render('_itemView', [
                        'dialog' => SocialHelper::formatDialog($model),
                    ]);
                },
                'summary' => '',
                'pager' => [
                    'class' => ScrollPager::className(),
                    'spinnerSrc' => '/images/loading.gif',
                    'noneLeftText' => '',
                    'enabledExtensions' => [ScrollPager::EXTENSION_SPINNER, ScrollPager::EXTENSION_NONE_LEFT, ScrollPager::EXTENSION_PAGING],
                    'eventOnScroll' => 'function() {$(\'.ias-trigger a\').trigger(\'click\')}',
                ],
            ]) ?>
            
        </div>
    <?php } else { ?>
        <div>Вы еще не общались ни с одним пользователем. Найдите себе собеседника <a href="/">здесь</a>.</div>
    <?php } ?>
</div>
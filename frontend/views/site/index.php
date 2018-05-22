<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use kop\y2sp\ScrollPager;

$this->title = 'Мини социальная сеть';
?>

<div class="site-index">
    <div class="row home">
        <?= yii\widgets\ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => [
                'class' => 'item',
            ],
            'itemView' => '_userView',
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
</div>

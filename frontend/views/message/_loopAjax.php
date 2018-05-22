<?php

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $authUserId integer */
/* @var $companion \common\models\User */

use yii\widgets\ListView;

?>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_itemView',
    'itemOptions' => [
        'class' => 'item',
    ],
    'options' => [
        'tag' => false, // remove the outer container
    ],
    'viewParams' => [
        'authUserId' => $authUserId,
        'companion' => $companion,
    ],
    'layout' => '{items}',
]); ?>
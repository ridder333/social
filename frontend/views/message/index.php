<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $authUserId integer */
/* @var $companion \common\models\User */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\ListView;

$this->title = 'Чат с пользователем ' . $companion->firstname . ' ' . $companion->surname;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="message-index">
    <h1>Чат с пользователем <?= $companion->firstname . ' ' . $companion->surname ?></h1>

    <?php if ($dataProvider->getTotalCount() > $dataProvider->pagination->pageSize) { ?>    
        <div class="show-more">
            <?= Html::button('Загрузить предыдущие сообщения', [
                'class' => 'btn btn-primary btn-show-more', 
                'id' => 'show-more-messages-button', 
                'data-current-page' => Yii::$app->request->get('page', 1), 
                'data-count-page' => $pageCount,
            ]) ?>
            <p class="loading" style="display:none"><img src="/images/loading.gif" alt=""></p>
        </div>
    <?php } ?>
    
    <?php if ($dataProvider->getTotalCount()) { ?>
        <div class="chat">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'itemView' => '_itemView',
                'viewParams' => [
                    'authUserId' => $authUserId,
                    'companion' => $companion,
                ],
                'summary' => '',
            ]); ?>
        </div>
    <?php } else { ?>
        <div class="chat"></div>
        <div class="not-chat">Вы еще не общались с этим пользователем.</div>
    <?php } ?>
        
    <div class="clear"></div>
</div>

<div class="hidden" id="to_user_name"><?= $companion->firstname . ' ' . $companion->surname ?></div>

<?php $form = ActiveForm::begin(['id' => 'form-message', 'options' => ['class' => 'form-message']]); ?>              
    <?= $form->field($newMessage, 'to_user_id')->hiddenInput()->label(false) ?>            
    <?= $form->field($newMessage, 'text')->textarea(['rows' => 6]) ?>       
    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary btn-send', 'name' => 'message-button']) ?>
    </div>
<?php ActiveForm::end(); ?>
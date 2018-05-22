<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use common\models\Message;
use common\models\Dialog;
use yii\data\ActiveDataProvider;

/**
 * Message controller
 */
class MessageController extends Controller
{   
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    /**
     * Displays all messages with another user.
     * 
     * @param integer $companionId
     * @return mixed
     */
    public function actionIndex($companionId)
    {
        $authUserId = Yii::$app->user->identity->getId();
        $companion = $this->findCompanion($companionId, $authUserId);
        
        // add message
        $message = new Message();
        if ($message->load(Yii::$app->request->post())) {
            $message->from_user_id = $authUserId;
            if ($message->save()) {
                // update dialogs
                $this->updateDialogs($authUserId, $companionId, $message->id);
            }
            $this->redirect('/message/' . $companionId . '#form-message');
        }
        
        $this->processPageRequest('page');
        
        // get all messages from the user
        $messages = Message::find()->where(['or',
                                               ['and', ['from_user_id' => $companionId], ['to_user_id' => $authUserId]],
                                               ['and', ['from_user_id' => $authUserId], ['to_user_id' => $companionId]]
                                          ])
                                   ->orderBy(['id' => SORT_ASC]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $messages,
            'pagination' => [
                'pageSize' => Message::PAGE_SIZE,
            ],
        ]);
        
        $pageCount = $dataProvider->getTotalCount() <= $dataProvider->pagination->pageSize ? 
                     1 : ceil($dataProvider->getTotalCount() / $dataProvider->pagination->pageSize);
        
        // load the last page
        if (!Yii::$app->request->isAjax && !isset($_GET['page'])) {
            $_GET['page'] = $pageCount;
        }
        
        $newMessage = new Message();
        $newMessage->from_user_id = $authUserId;
        $newMessage->to_user_id = $companion->id;
        
        // mark read messages
        Message::updateAll(['is_read' => 1], ['and', ['from_user_id' => $companionId], ['to_user_id' => $authUserId]]);
        
        if (Yii::$app->request->isAjax) {
            return $this->renderPartial('_loopAjax', [
                'dataProvider' => $dataProvider,
                'authUserId' => $authUserId,
                'companion' => $companion,
            ]);
        } else {
            return $this->render('index', [
                'messages' => $messages,
                'dataProvider' => $dataProvider,
                'pageCount' => $pageCount,
                'authUserId' => $authUserId,
                'companion' => $companion,
                'newMessage' => $newMessage,
            ]);
        }
    }

    /**
     * Checks new messages.
     * 
     * @return json
     */
    public function actionCheckNewMessages()
    {
        $companionId = (int) Yii::$app->request->post('from_user_id');
        if (Yii::$app->request->isAjax && $companionId) {
            $authUserId = Yii::$app->user->identity->getId();

            $messages = Message::find()->where(['and', 
                                                   ['from_user_id' => $companionId], 
                                                   ['to_user_id' => $authUserId], 
                                                   ['is_read' => 0]
                                              ])
                                       ->asArray()
                                       ->all();

            // mark read messages
            Message::updateAll(['is_read' => 1], ['and', ['from_user_id' => $companionId], ['to_user_id' => $authUserId]]);

            print json_encode($messages);
        }
    }
    
    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * 
     * @param integer $id
     * @param integer $authUserId
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findCompanion($id, $authUserId)
    {
        $model = User::findOne($id);
        if ($model !== null && $model->id !== $authUserId) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the Message model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * 
     * @return Message the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findMessages()
    {
        if (($model = Message::find()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * Updates dialogs.
     * 
     * @param integer $authUserId
     * @param integer $companionId
     * @param integer $messageId
     */
    protected function updateDialogs($authUserId, $companionId, $messageId)
    {
        $dialog = Dialog::find()->where(['or',
                                            ['and', ['from_user_id' => $companionId], ['to_user_id' => $authUserId]],
                                            ['and', ['from_user_id' => $authUserId], ['to_user_id' => $companionId]]
                                       ])
                                ->one();
        
        if ($dialog === null) {
            // add dialog
            $dialog = new Dialog();
        }
        
        $dialog->from_user_id = $authUserId;
        $dialog->to_user_id = $companionId;
        $dialog->last_message_id = $messageId;
        $dialog->save();
    }
    
    /**
     * Process page request.
     * 
     * @param string $param
     */
    protected function processPageRequest($param = 'page')
    {
        if (Yii::$app->request->isAjax && isset($_POST[$param])) {
            $_GET[$param] = Yii::$app->request->post($param);
        }
    }
}

<?php

namespace frontend\components;

use Yii;

/**
 * Social Helper
 */
class SocialHelper {
    /**
     * Formats the data of the Dialog model.
     * 
     * @param $dialog
     * @return array
     */
    public static function formatDialog($dialog)
    {
        $authUserIsLastSender = $dialog->from_user_id == Yii::$app->user->identity->getId();
        
        $companionId = $authUserIsLastSender ? $dialog->to_user_id : $dialog->from_user_id;
        $companionName = $authUserIsLastSender ?
                         $dialog->toUser->firstname . ' ' . $dialog->toUser->surname :
                         $dialog->fromUser->firstname . ' ' . $dialog->fromUser->surname;
        $lastMessage = $dialog->message->text;
        $lastMessageTime = $dialog->updated_at;
        $companionAvatar = !empty($authUserIsLastSender ? $dialog->toUser->avatar : $dialog->fromUser->avatar) ?
                           $companionId . '/' . ($authUserIsLastSender ? $dialog->toUser->avatar->name : $dialog->fromUser->avatar->name) :
                           'nophoto.jpg';
        
        return [
            'companionId' => $companionId,
            'companionName' => $companionName,
            'lastMessage' => $lastMessage,
            'lastMessageTime' => $lastMessageTime,
            'companionAvatar' => $companionAvatar,
        ];
    }
}

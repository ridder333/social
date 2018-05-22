<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use common\models\Dialog;
use yii\data\ActiveDataProvider;

/**
 * Dialog controller
 */
class DialogController extends \yii\web\Controller
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
     * Displays a single Dialog model.
     * 
     * @return mixed
     */
    public function actionIndex()
    {
        $authUserId = Yii::$app->user->identity->getId();
        $query = Dialog::find()->where(['or', ['from_user_id' => $authUserId], ['to_user_id' => $authUserId]])
                               ->orderBy(['updated_at' => SORT_DESC]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Dialog::PAGE_SIZE,
            ],
        ]);
        
        return $this->render('index',[
            'dataProvider' => $dataProvider,
        ]);
    }

}

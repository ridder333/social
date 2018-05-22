<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use yii\web\NotFoundHttpException;

/**
 * User controller
 */
class UserController extends Controller
{   
    public function actionIndex($id)
    {
        if ($id == Yii::$app->user->id) {
            $this->redirect('/profile');
        }
        
        return $this->render('index', [
            'user' => $this->findUser($id),
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findUser($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

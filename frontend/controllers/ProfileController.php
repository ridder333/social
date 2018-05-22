<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\User;
use yii\web\NotFoundHttpException;
use frontend\models\UserUpdateForm;
use frontend\models\UpdatePasswordForm;
use common\models\Image;
use frontend\models\UploadImageForm;

/**
 * Profile controller
 */
class ProfileController extends Controller
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
     * Displays a single User model.
     * 
     * @return mixed
     */
    public function actionIndex()
    {
        $image = new UploadImageForm();
        
        return $this->render('index', [
            'user' => $this->findUser(),
            'image' => $image,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * 
     * @return mixed
     */
    public function actionUpdate()
    {
        $user = $this->findUser();
        $model = new UserUpdateForm($user);
        
        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->session->setFlash('success', 'Данные успешно изменены.');
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Updates the password in the existing User model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * 
     * @return mixed
     */
    public function actionUpdatePassword()
    {
        $user = $this->findUser();
        $model = new UpdatePasswordForm($user);
 
        if ($model->load(Yii::$app->request->post()) && $model->updatePassword()) {
            Yii::$app->session->setFlash('success', 'Пароль успешно изменен.');
            return $this->redirect(['index']);
        } else {
            return $this->render('updatePassword', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Updates the avatar in the existing User model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * 
     * @return mixed
     */
    public function actionUpdateAvatar()
    {
        $imageId = Yii::$app->request->post('id', null);
        if ($imageId > 0) {
            $imageUserId = $this->findImage($imageId)->user->id;
            $user = $this->findUser();
            
            if ($imageUserId == Yii::$app->user->identity->getId() && $imageId != $user->avatar_id) {
                $user->avatar_id = $imageId;
                if ($user->save()) {
                    Yii::$app->session->setFlash('success', 'Главное фото успешно изменено.');
                }
            }
        }
        
        return $this->redirect(['index']);        
    }
    
    /**
     * Creates a new Image model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * 
     * @return mixed
     */
    public function actionUploadImage()
    {
        $model = new UploadImageForm();
        
        if ($model->load(Yii::$app->request->post())) {
            if ($model->upload()) {
                Yii::$app->session->setFlash('success', 'Фото успешно добавлено.');
            }
        }
        
        return $this->redirect(['index']);
    }
    
    /**
     * Deletes an existing Image model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @return mixed
     */
    public function actionDeleteImage()
    {
        $imageId = Yii::$app->request->post('id', null);
        if ($imageId > 0) {
            $image = $this->findImage($imageId);
            $imageName = $image->name;
            $image->delete();
            unlink(User::IMG_PATH . Yii::$app->user->identity->getId() . '/' . $imageName);
            Yii::$app->session->setFlash('success', 'Фото успешно удалено.');
        }
        
        return $this->redirect(['index']);
    }


    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * 
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findUser()
    {
        if (($model = User::findOne(Yii::$app->user->identity->getId())) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * Finds the Image model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * 
     * @param integer $id
     * @return Image the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findImage($id)
    {
        if (($model = Image::findOne(['id' => $id, 'user_id' => Yii::$app->user->identity->getId()])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}

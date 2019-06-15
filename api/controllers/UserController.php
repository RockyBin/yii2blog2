<?php
namespace api\controllers;

use common\models\ApiSignupForm;
use Yii;
use common\models\ApiLoginForm;
use yii\rest\Controller;

class UserController extends Controller{

    public function actionLogin(){

        $model = new ApiLoginForm();

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if($res = $model->login()){

            Yii::$app->response->statusCode = '200';
            Yii::$app->response->statusText = 'login success!';

            return $res;

        }else{

            $model->validate();

            return $model;

        }

    }

    public function actionRegister(){

        $model = new ApiSignupForm();

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if($res = $model->signup()){

            Yii::$app->response->statusCode = '200';
            Yii::$app->response->statusText = 'login success!';

            return $res;

        }else{

            $model->validate();

            return $model;

        }

    }

}

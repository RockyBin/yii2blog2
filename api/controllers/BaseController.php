<?php
namespace api\controllers;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;
use common\lib\UnsignHttpException;

class BaseController extends ActiveController{

    public $data = [];
    public $response;
    public $modelClass = '';
    public $controllers = [];
    public $optional = [];

    public function beforeAction($action)
    {
        $this->response = Yii::$app->response;
        $this->response->format = yii\web\Response::FORMAT_JSON;
        $this->getRequestData();
        //$this->getSign();
        return parent::beforeAction($action);
    }

    protected function getRequestData(){
        $req = Yii::$app->request;
        $method = $req->method;
        $data = $req->$method();
        $this->data = $data;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['authenticator']);
        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors'=>[
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'except' => ['options'],
            'optional' => $this->optional,
        ];
        return $behaviors;
    }

    /**
     * 生成访问签名
     */
    protected function getSign(){

        $controller = $this->id;
        $action = Yii::$app->controller->action->id;

        if(!in_array($controller, $this->controllers)){
            if(isset($this->data['sign']) && !empty($this->data['sign'])){

                $sign = md5($controller . $action. Yii::$app->params['signRand']);

                if($this->data['sign'] != $sign){
                    throw new UnsignHttpException('签名错误');
                }

            }else{
                throw new UnsignHttpException('签名错误');
            }
        }

    }


}
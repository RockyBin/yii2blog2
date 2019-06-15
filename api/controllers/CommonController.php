<?php
namespace api\controllers;

use common\lib\UnsignHttpException;
use Yii;
use yii\rest\Controller;
use yii\filters\Cors;
use yii\web\Response;

class CommonController extends Controller{

    public $data = [];
    public $response;
    public $controllers = [];

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
        ];

        return $behaviors;
    }

    public function beforeAction($action)
    {
        $this->format();
        $this->getData();
        $this->getSign();

        return parent::beforeAction($action);
    }

    protected function format(){
        $this->response = Yii::$app->response;
        $this->response->format = Response::FORMAT_JSON;
    }

    protected function getData(){

        $req = Yii::$app->request;
        $method = $req->getMethod();

        $this->data = $req->$method();
    }

    protected function getSign(){

        $controller = $this->id;
        $action = Yii::$app->controller->action->id;

        if(!in_array($controller, $this->controllers)){

            if(isset($this->data['sign']) && !empty($this->data['sign'])){

                $sign = md5($controller . $action . Yii::$app->params['signRand']);

                if($this->data['sign'] != $sign){
                    throw new UnsignHttpException('sign error');
                }

            }else{
                throw new UnsignHttpException('sign error');
            }

        }

    }

}

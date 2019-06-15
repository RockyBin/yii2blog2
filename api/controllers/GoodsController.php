<?php
namespace api\controllers;

use api\controllers\BaseController;
use common\models\Goods;
use yii\data\Pagination;
use common\lib\Paginations;

class GoodsController extends BaseController{

    public $modelClass = 'common\models\Goods';
    public $optional = [];

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['index']);

        return $actions;
    }

//    public function verbs()
//    {
//        return [
//            'index' => ['POST', 'HEAD'],
//            'view' => ['GET', 'HEAD'],
//            'create' => ['POST'],
//            'update' => ['PUT', 'PATCH'],
//            'delete' => ['DELETE'],
//        ];
//    }

    public function actionIndex(){

        $page = !empty($this->data['page']) ? $this->data['page']: 1;
        $pageSize = !empty($this->data['pageSize']) ? $this->data['pageSize']: 5;

        $query = Goods::find();

        $count = $query->count();

        $pagination = new Paginations([
            'totalCount' => $count,
            'pageSize' => $pageSize
        ]);

        $data = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $data;
    }

}
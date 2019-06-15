<?php
namespace common\lib;

use Yii;
use yii\data\Pagination;
use yii\web\Request;

class Paginations extends Pagination{

    /**
     * Returns the value of the specified query parameter.
     * This method returns the named parameter value from [[params]]. Null is returned if the value does not exist.
     * @param string $name the parameter name
     * @param string $defaultValue the value to be returned when the specified parameter does not exist in [[params]].
     * @return string the parameter value
     */
    protected function getQueryParam($name, $defaultValue = null)
    {
        if (($params = $this->params) === null) {
            $req = Yii::$app->request;
            $method = $req->method;
            $params = $req->$method() ? $req->$method() : [];
        }

        return isset($params[$name]) && is_scalar($params[$name]) ? $params[$name] : $defaultValue;
    }

}

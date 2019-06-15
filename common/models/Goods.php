<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property string $id
 * @property string $goodsName
 * @property string $price
 * @property int $num
 * @property string $totalPrice
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price', 'totalPrice'], 'number'],
            [['num'], 'integer'],
            [['goodsName'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goodsName' => 'Goods Name',
            'price' => 'Price',
            'num' => 'Num',
            'totalPrice' => 'Total Price',
        ];
    }
}

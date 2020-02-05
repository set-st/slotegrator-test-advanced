<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "wins".
 *
 * @property int $id
 * @property int $uId
 * @property int|null $type
 * @property float|null $amount
 * @property string|null $description
 * @property string|null $createdAt
 * @property string|null $sendAt
 */
class Wins extends \yii\db\ActiveRecord
{

    const TYPE_MONEY = 1;
    const TYPE_BONUSES = 2;
    const TYPE_ITEM = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wins';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uId'], 'required'],
            [['uId', 'type'], 'integer'],
            [['amount'], 'number'],
            [['createdAt', 'sendAt'], 'safe'],
            [['description'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'uId' => Yii::t('app', 'U ID'),
            'type' => Yii::t('app', 'Type'),
            'amount' => Yii::t('app', 'Amount'),
            'description' => Yii::t('app', 'Description'),
            'createdAt' => Yii::t('app', 'Created At'),
            'sendAt' => Yii::t('app', 'Send At'),
        ];
    }

    public static function getFreeItem($counter = 0)
    {
        // немного неэкономно в плане загрузки базы данны, но всегда актуально
        $items = self::find()
            ->where(['type' => self::TYPE_ITEM])
            ->andWhere(['sendAt' => null])
            ->asArray()
            ->all();

        $items = array_column($items, 'description', 'description');

        $params = \Yii::$app->params['items'];
        $randItem = rand(0, (count($params)-1));

        if(!in_array($params[$randItem], $items)){
            return $params[$randItem];
        }
        else{
            // если счетчик попыток превысил объем списка итемов, то выходим
            if($counter >= count($params)){
                return null;
            }
            $counter++;
            return self::getFreeItem($counter);
        }
    }

    public static function getMoneyGift()
    {
        $sum = self::find()
            ->select(['sum' => 'SUM(amount)'])
            ->where(['type' => self::TYPE_MONEY])
            ->andWhere(['sendAt' => null])
            ->asArray()
            ->one();

        $params = \Yii::$app->params['money'];
        $amount = rand($params['interval']['min'], $params['interval']['max']);

        if($sum['sum'] >= $params['limit']){
            return null;
        }

        $free = $params['limit'] - $sum['sum'];

        if($amount <= $free){
            return $amount;
        }

        return $free;
    }
}

<?php


namespace frontend\models;


use common\models\User;
use common\models\Wins;
use yii\base\Model;
use yii\helpers\Url;

class WinForm extends Model
{
    public $userId;

    public function rules()
    {
        return [
            ['userId', 'exist', 'targetAttribute' => 'id', 'targetClass' => User::class],
        ];
    }

    public function pull()
    {

        if (!$this->validate()) {
            return false;
        }

        $return = false;

        $types = [
            Wins::TYPE_MONEY,
            Wins::TYPE_BONUSES,
            Wins::TYPE_ITEM,
        ];

        $randType = rand(0, (count($types) - 1));

        switch ($types[$randType]) {
            case Wins::TYPE_MONEY:
                $amount = Wins::getMoneyGift();
                if (!empty($amount)) {
                    $params = \Yii::$app->params['money'];
                    $win = new Wins();
                    $win->uId = \Yii::$app->user->identity->getId();
                    $win->type = Wins::TYPE_MONEY;
                    $win->amount = $amount;
                    $win->createdAt = date('Y-m-d H:i:s');
                    if ($win->save()) {
                        $return = true;
                        \Yii::$app->session->addFlash('success',
                            \Yii::t('app', 'You win money: {amount}, {convert}. {toBank}', [
                                'amount' => $amount,
                                'convert' => \Yii::t('app',
                                    '<a href="{url}">You may convert it to bonuses, will be {amount} bonuses.</a>', [
                                        'amount' => $amount * $params['bonusMultiplier'],
                                        'url' => Url::to(['site/to-bonuses', 'id' => $win->id])
                                    ]),
                                'toBank' => \Yii::t('app', '<a href="{url}">Move out to bank account</a>', [
                                    'url' => Url::to(['site/to-bank', 'id' => $win->id])
                                ])
                            ]));
                    }
                }
                break;
            case Wins::TYPE_BONUSES:
                $params = \Yii::$app->params['bonuses'];
                $amount = rand($params['interval']['min'], $params['interval']['max']);
                $win = new Wins();
                $win->uId = \Yii::$app->user->identity->getId();
                $win->type = Wins::TYPE_BONUSES;
                $win->amount = $amount;
                $win->createdAt = date('Y-m-d H:i:s');
                if ($win->save()) {
                    $return = true;
                    \Yii::$app->session->addFlash('success', \Yii::t('app', 'You win bonuses: {amount}', [
                        'amount' => $amount,
                    ]));
                }
                break;
            case Wins::TYPE_ITEM:
                $item = Wins::getFreeItem();
                if (!empty($item)) {
                    $win = new Wins();
                    $win->uId = \Yii::$app->user->identity->getId();
                    $win->type = Wins::TYPE_ITEM;
                    $win->description = $item;
                    $win->createdAt = date('Y-m-d H:i:s');
                    if ($win->save()) {
                        $return = true;
                        \Yii::$app->session->addFlash('success', \Yii::t('app', 'You win this item {item}. {reject}', [
                            'item' => $item,
                            'reject' => \Yii::t('app', '<a href="{link}">You can reject</a>', [
                                'link' => Url::to(['site/item-reject', 'id' => $win->id])
                            ]),
                        ]));
                    }
                }
                break;
        }

        return $return;
    }
}
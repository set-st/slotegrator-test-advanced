<?php

namespace console\controllers;

use common\models\Wins;
use yii\console\Controller;

class GiftController extends Controller
{

    /**
     * Рассылает деньги пользователям по банковским счетам
     * chunkSize задает размер пачки
     * @param $chunkSize
     * @throws \Throwable
     */
    public function actionToBank($chunkSize)
    {
        $count = Wins::find()
            ->where(['sendAt' => null])
            ->andWhere(['type' => Wins::TYPE_MONEY])
            ->count();

        $pages = 1;

        if ($chunkSize < $count) {
            $pages = round($count / $chunkSize, 0, PHP_ROUND_HALF_DOWN);
        }

        for ($page = 1; $page <= $pages; $page++) {
            $select = Wins::find()
                ->where(['sendAt' => null])
                ->andWhere(['type' => Wins::TYPE_MONEY])
                ->limit($chunkSize);
            echo 'Sending page ' . $page . PHP_EOL;
            foreach ($select->all() as $row) {
                /* @var $row Wins */
                if ($row->toBank()) {
                    $row->sendAt = date('Y-m-d H:i:s');
                    if ($row->save()) {
                        echo 'send ' . $row->amount . PHP_EOL;
                    }
                }
            }
            unset($select);
        }
    }

}
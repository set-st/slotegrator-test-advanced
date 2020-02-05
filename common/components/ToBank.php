<?php

namespace common\components;

class ToBank extends \yii\base\Component
{

    public $bankUrl;
    // other necessary options

    /**
     * Send money to user bank account
     *
     * @param $amount
     * @return bool
     */
    public function send(float $amount)
    {
        //
        return true;
    }


}
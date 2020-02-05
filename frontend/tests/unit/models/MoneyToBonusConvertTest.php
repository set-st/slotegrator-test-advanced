<?php


namespace frontend\tests\unit\models;


use Codeception\Test\Unit;
use common\fixtures\UserFixture as UserFixture;
use common\fixtures\WinsFixture;
use common\models\Wins;

class MoneyToBonusConvertTest extends Unit
{

    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
            'wins' => [
                'class' => WinsFixture::className(),
                'dataFile' => codecept_data_dir() . 'wins_data.php'
            ]
        ]);
    }

    public function testCorrectConvert()
    {
        $record = $this->tester->grabFixture('wins', 0);
        /* @var $record Wins */

        // ручной подсчет
        $params = \Yii::$app->params['money'];
        $amount = $record->amount * $params['bonusMultiplier'];

        // проверим ожидания
        $this->assertEquals(Wins::TYPE_MONEY, $record->type, 'Record with Money type');
        $this->assertEquals($amount, $record->toBonuses(), 'Convert to bonuses method');
        $this->assertEquals($amount, $record->amount, 'Check amount');
        $this->assertEquals(Wins::TYPE_BONUSES, $record->type, 'Check change type to bonuses');
    }

}
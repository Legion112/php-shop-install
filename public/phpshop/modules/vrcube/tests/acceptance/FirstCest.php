<?php
use Codeception\Util\Locator;
require_once(__DIR__ .'/../../VrcubeConstant.php');

class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    private function convertEncode($text)
    {
        return mb_convert_encoding($text, 'UTF-8', 'windows-1251');
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Спецпредложения');
        $I->comment('Adding  product to card');
        $I->sendAjaxPostRequest('/phpshop/ajax/cartload.php', [
            'xid' => 50,
            'num' => 1,
            'xxid' => 0,
            'type' => 'json',
            'addname' => '',
        ]);
        $I->seeResponseCodeIsSuccessful();
        $I->see('"success":true');
        $I->amOnPage('/order/');
        $I->seeInTitle($this->convertEncode('Оформление заказа'));
        $mail = 'test@example.com';
        $name = $this->convertEncode('Max');
        $ouid = $I->grabAttributeFrom("//input[@name='ouid']", 'value');
        $I->sendAjaxPostRequest('/done/', [
            'ouid' => $ouid,
            'mail' => $mail,
            'name_new' => $name,
            'rule' => 'on',
            'tel_new' => '+7(995)-600-9754',
            'street_new' => 'Street',
            'house_new' => '',
            'porch_new' => '',
            'delivtime_new' => 'Сейчас',
            'dop_info' => '',
            'order_metod' => VrcubeConstant::$PAYMENT_ID,
            'send_to_order' => 'ok',
            'd' => 3,
            'nav' => 'done'
        ]);
        $I->seeResponseCodeIsSuccessful();

        $I->see('Пожалуйста, оплатите свой заказ');
        $I->see('Оплатить заказ №');
        $I->seeElement('div', ['class' => 'order']);
        $I->seeElement('input', ['name' => 'token']); // here it the failer
        /**
         * Element located either by name, CSS or XPath element with input' with attribute(s) '"name":"token" was not found.
         */




    }
}

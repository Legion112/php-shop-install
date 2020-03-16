<?php /** @noinspection AutoloadingIssuesInspection */

// Настройки модуля
PHPShopObj::loadClass("array");

class PHPShopVrcubeArray extends PHPShopArray
{
    public function __construct()
    {
        $this->objType = 3;
        $this->objBase = $GLOBALS['SysValue']['base']['vrcube']['vrcube_system'];
        parent::__construct(
            'status',
            'title',
            'title_sub',
            'product_id',
            'contract_id',
            'vrcube_secret_word',
            'endpoint_url',
            'use_cashbox'
        );
    }
}

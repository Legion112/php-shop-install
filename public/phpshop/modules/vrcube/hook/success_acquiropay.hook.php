<?php

/**
 * @param PHPShopCore $obj
 * @param $value
 * @return bool
 */
function success_mod_acquiropay_hook($obj)
{
    if (!empty($_REQUEST['cf'])) {
        $obj->order_metod = 'modules" and id="10018';
        $obj->message('', '');
        return true;
    }
    return null;
}

$addHandler = array('index' => 'success_mod_acquiropay_hook');

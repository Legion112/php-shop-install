<?php
require_once '../VrcubeConstant.php';
/**
 * @param PHPShopCore $obj
 * @param $value
 * @return bool
 */
function success_mod_vrcube_hook($obj)
{
    if (!empty($_REQUEST['cf'])) {
        $obj->order_metod = sprintf('modules" and id="%d', VrcubeConstant::$PAYMENT_ID);
        $obj->message('', '');
        return true;
    }
    return null;
}

$addHandler = array('index' => 'success_mod_vrcube_hook');

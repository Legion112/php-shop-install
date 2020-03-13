<?php

$TitlePage = __("�������");

function actionStart() {
    global $PHPShopInterface,$TitlePage;

    $PHPShopInterface->setActionPanel($TitlePage, array('������� ���������'), array('��������'));

    $PHPShopInterface->setCaption(array(null, "3%"), array("��������", "30%"), array("���������", "30%"), array("", "10%"), array("������", "10%", array('align' => 'right')));

    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['banner']);
    $data = $PHPShopOrm->select(array('*'), false, array('order' => 'id DESC'), array("limit" => "1000"));
    if (is_array($data))
        foreach ($data as $row) {

            $PHPShopInterface->setRow($row['id'], array('name' => $row['name'], 'link' => '?path=banner&id=' . $row['id'], 'align' => 'left'), $row['dir'],array('action' => array('edit', '|', 'delete', 'id' => $row['id']), 'align' => 'center'), array('status' => array('enable' => $row['flag'], 'align' => 'right', 'caption' => array('����', '���'))));
        }

    $PHPShopInterface->setAddItem('ajax/banner/adm_banner_new.php');
    $PHPShopInterface->title = $TitlePage;
    $PHPShopInterface->Compile();
}

?>

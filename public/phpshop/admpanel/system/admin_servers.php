<?php

$TitlePage = __("�������");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['servers']);

// ��������� ���
function actionStart() {
    global $PHPShopInterface, $PHPShopOrm, $TitlePage;

    $PHPShopInterface->action_select['����������'] = array(
        'name' => '����������',
        'url' => 'http://faq.phpshop.ru/page/showcase.html',
        'target' => '_blank'
    );

    $PHPShopInterface->action_select['������������'] = array(
        'name' => '������������ ���������',
        'action' => 'activate',
        'class' => 'disabled'
    );

    $PHPShopInterface->addJSFiles('./system/gui/system.gui.js');
    $PHPShopInterface->setActionPanel($TitlePage, array('����������', '������������', '|', '������� ���������'), array('��������'));
    $PHPShopInterface->setCaption(array(null, "3%"), array("��������", "30%"), array("�����", "30%"), array("", "10%"), array("������", "10%", array('align' => 'right')));

    $data = $PHPShopOrm->select(array('*'), false, array('order' => 'id DESC'), array('limit' => 1000));
    if (is_array($data))
        foreach ($data as $row) {

            $PHPShopInterface->setRow($row['id'], array('name' => $row['name'], 'link' => '?path=system.servers&id=' . $row['id'], 'align' => 'left'), array('name' => $row['host'], 'link' => 'http://' . $row['host'], 'target' => '_blank','class'=>'host'), array('action' => array('edit', '|', 'delete', 'id' => $row['id']), 'align' => 'center'), array('status' => array('enable' => $row['enabled'], 'align' => 'right', 'caption' => array('����', '���'))));
        }

    $sidebarleft[] = array('title' => '���������', 'content' => $PHPShopInterface->loadLib('tab_menu', false, './system/'));
    $PHPShopInterface->setSidebarLeft($sidebarleft, 2);
    $PHPShopInterface->Compile(2);
}

?>
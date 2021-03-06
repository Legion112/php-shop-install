<?php

$TitlePage = __("������������");

function actionStart() {
    global $PHPShopInterface, $TitlePage;

    $licFile = PHPShopFile::searchFile('../../license/', 'getLicense', true);
    @$License = parse_ini_file_true("../../license/" . $licFile, 1);

    if ($License['License']['RegisteredTo'] == 'Trial NoName' or $License['License']['SupportExpires'] < time() or $_SERVER["REMOTE_ADDR"] == '185.183.160.137')
        $action = 'noSupport';
    else
        $action = 'addNew';

    $PHPShopInterface->action_button['����� ������'] = array(
        'name' => '',
        'action' => $action,
        'class' => 'btn btn-default btn-sm navbar-btn',
        'type' => 'button',
        'icon' => 'glyphicon glyphicon-plus',
        'tooltip' => 'data-toggle="tooltip" data-placement="left" title="' . __('����� ������ � ������������') . '"'
    );

    $PHPShopInterface->setActionPanel($TitlePage, false, array('����� ������'));
    $PHPShopInterface->checkbox_action = false;
    $PHPShopInterface->addJSFiles('./support/gui/support.gui.js');
    $PHPShopInterface->setCaption(array("���������", "60%"), array("�", "10%", array('align' => 'left')), array("����", "15%", array('align' => 'center')), array("������", "15%", array('align' => 'right')));

    if ($action == 'addNew') {
        PHPShopObj::loadClass('xml');
        $path = 'https://help.phpshop.ru/base-xml-manager/search/xml.php?s=' . $License['License']['Serial'] . '&u=' . $License['License']['DomenLocked'];
        $dataArray = readDatabase($path, "row");
    }

    $status_array = array(
        0 => '<span>����� ������</span>',
        1 => '<span class="text-warning">�������� ������</span>',
        2 => '<span class="text-success">���� �����</span>',
        3 => '<span class="text-muted">���������</span>',
    );

    if (is_array($dataArray))
        foreach ($dataArray as $row) {

            $PHPShopInterface->setRow(array('name' => $row['subject'], 'link' => '?path=' . $_GET['path'] . '&id=' . $row['id'] . '#m', 'align' => 'left'), array('name' => $row['id'], 'align' => 'left'), array('name' => $row['lastchange'], 'align' => 'center'), $status_array[$row['status']]);
        }

    $PHPShopInterface->Compile();
}

?>
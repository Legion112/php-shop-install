<?php

$TitlePage = __('�������������� ������� ������') . ' #' . $_GET['id'];
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['payment_systems']);

// ��������� ���
function actionStart() {
    global $PHPShopGUI, $PHPShopSystem, $PHPShopOrm, $PHPShopModules;

    // �������
    $data = $PHPShopOrm->select(array('*'), array('id' => '=' . intval($_REQUEST['id'])));

    // ��� ������
    if (!is_array($data)) {
        header('Location: ?path=' . $_GET['path']);
    }

    // bootstrap-colorpicker
    $PHPShopGUI->addCSSFiles('./css/bootstrap-colorpicker.min.css');
    $PHPShopGUI->addJSFiles('./js/bootstrap-colorpicker.min.js');

    // ������ �������� ����
    $PHPShopGUI->field_col = 2;
    $PHPShopGUI->setActionPanel($data['name'], array('�������', '|', '�������'), array('���������', '��������� � �������'), false);

    // �������� 1
    $PHPShopGUI->setEditor($PHPShopSystem->getSerilizeParam("admoption.editor"));
    $oFCKeditor = new Editor('message_new');
    $oFCKeditor->Height = '300';
    $oFCKeditor->ToolbarSet = 'Normal';
    $oFCKeditor->Value = $data['message'];

    // ���������� 
    $Tab1 = $PHPShopGUI->setCollapse('����������', $PHPShopGUI->setField("������������", $PHPShopGUI->setInput("text", "name_new", $data['name'])) .
            $PHPShopGUI->setField("�����", $PHPShopGUI->setRadio("enabled_new", 1, "����������", $data['enabled']) . $PHPShopGUI->setRadio("enabled_new", 0, "������", $data['enabled'])) .
            $PHPShopGUI->setField("���������", $PHPShopGUI->setInputText(null, "num_new", $data['num'], '100')) .
            $PHPShopGUI->setField("����������� ������", $PHPShopGUI->setCheckbox("yur_data_flag_new", 1, "����������� ���������", $data['yur_data_flag'])) .
            $PHPShopGUI->setField("��� �����������", $PHPShopGUI->setSelect("path_new", $PHPShopGUI->loadLib('GetTipPayment', $data['path']), 350))
    );

    $Tab1.=$PHPShopGUI->setField("������", $PHPShopGUI->setIcon($data['icon'], "icon_new", false));
    
    $Tab1.=$PHPShopGUI->setField('����', $PHPShopGUI->setInputColor('color_new', $data['color']));

    $Tab1.=$PHPShopGUI->setCollapse('��������� ����� ������', $PHPShopGUI->setField("���������:", $PHPShopGUI->setInput("text", "message_header_new", $data['message_header'])) . $PHPShopGUI->setField("���������", $oFCKeditor->AddGUI()));


    // ������ ������ �� ��������
    $PHPShopModules->setAdmHandler(__FILE__, __FUNCTION__, $data);

    // ����� ����� ��������
    $PHPShopGUI->setTab(array("��������", $Tab1, 350));

    // ����� ������ ��������� � ����� � �����
    $ContentFooter =
            $PHPShopGUI->setInput("hidden", "rowID", $data['id'], "right", 70, "", "but") .
            $PHPShopGUI->setInput("button", "delID", "�������", "right", 70, "", "but", "actionDelete.order.edit") .
            $PHPShopGUI->setInput("submit", "editID", "���������", "right", 70, "", "but", "actionUpdate.order.edit") .
            $PHPShopGUI->setInput("submit", "saveID", "���������", "right", 80, "", "but", "actionSave.order.edit");

    // �����
    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}

function iconAdd() {

    // ����� ����������
    $path = '/UserFiles/Image/';

    // �������� �� ������������
    if (!empty($_FILES['file']['name'])) {
        $_FILES['file']['ext'] = PHPShopSecurity::getExt($_FILES['file']['name']);
        if (in_array($_FILES['file']['ext'], array('gif', 'png', 'jpg'))) {
            if (move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['dir']['dir'] . $path . $_FILES['file']['name'])) {
                $file = $GLOBALS['dir']['dir'] . $path . $_FILES['file']['name'];
            }
        }
    }

    // ������ ���� �� URL
    elseif (!empty($_POST['furl'])) {
        $file = $_POST['icon_new'];
    }

    // ������ ���� �� ��������� ���������
    elseif (!empty($_POST['icon_new'])) {
        $file = $_POST['icon_new'];
    }

    if (empty($file))
        $file = '';

    return $file;
}

// ������� ��������
function actionDelete() {
    global $PHPShopOrm, $PHPShopModules;

    // �������� ������
    $PHPShopModules->setAdmHandler(__FILE__, __FUNCTION__, $_POST);


    $action = $PHPShopOrm->delete(array('id' => '=' . $_POST['rowID']));
    return array('success' => $action);
}

/**
 * ����� ����������
 */
function actionSave() {

    // ���������� ������
    actionUpdate();

    header('Location: ?path=' . $_GET['path']);
}

// ������� ����������
function actionUpdate() {
    global $PHPShopOrm, $PHPShopModules;

    $_POST['icon_new'] = iconAdd();

    // ������������� ������ ��������
    $PHPShopOrm->updateZeroVars('yur_data_flag_new');

    // �������� ������
    $PHPShopModules->setAdmHandler(__FILE__, __FUNCTION__, $_POST);

    $action = $PHPShopOrm->update($_POST, array('id' => '=' . $_POST['rowID']));
    return array('success' => $action);
}

// ��������� �������
$PHPShopGUI->getAction();

// ����� ����� ��� ������
$PHPShopGUI->setAction($_GET['id'], 'actionStart', 'none');
?>
<?php

PHPShopObj::loadClass("order");
PHPShopObj::loadClass("delivery");

// SQL
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.shoplogisticswidget.shoplogisticswidget_system"));

// ���������� ������ ������
function actionBaseUpdate() {
    global $PHPShopModules, $PHPShopOrm;
    $PHPShopOrm->clean();
    $option = $PHPShopOrm->select();
    $new_version = $PHPShopModules->getUpdate($option['version']);
    $PHPShopOrm->clean();
    $PHPShopOrm->update(array('version_new' => $new_version));
}

// ������� ����������
function actionUpdate() {
    global $PHPShopModules;


    // ��������
    if (isset($_POST['delivery_id_new'])) {
        if (is_array($_POST['delivery_id_new'])) {
            foreach ($_POST['delivery_id_new'] as $val) {
                $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['delivery']);
                $PHPShopOrm->update(array('is_mod_new' => 2), array('id' => '=' . intval($val)));
            }
            $_POST['delivery_id_new'] = @implode(',', $_POST['delivery_id_new']);
        }
    }
    if(empty($_POST['delivery_id_new']))
        $_POST['delivery_id_new'] = '';

    if (empty($_POST["dev_mode_new"]))
        $_POST["dev_mode_new"] = 0;
    
    $PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.shoplogisticswidget.shoplogisticswidget_system"));
    $PHPShopOrm->debug = false;
    $action = $PHPShopOrm->update($_POST);

    header('Location: ?path=modules&id=' . $_GET['id']);

    return $action;
}

function actionStart() {
    global $PHPShopGUI, $PHPShopOrm;

    // �������
    $data = $PHPShopOrm->select();

    // �������� ������� �������
    $PHPShopOrderStatusArray = new PHPShopOrderStatusArray();
    $OrderStatusArray = $PHPShopOrderStatusArray->getArray();

    $status[] = array('����� �����', 0, $data['status']);
    if (is_array($OrderStatusArray))
        foreach ($OrderStatusArray as $order_status) {
            $status[] = array($order_status['name'], $order_status['id'], $data['status']);
        }

    // ��������
    $PHPShopDeliveryArray = new PHPShopDeliveryArray(array('is_folder' => "!='1'", 'enabled' => "='1'"));

    $DeliveryArray = $PHPShopDeliveryArray->getArray();
    if (is_array($DeliveryArray)) {
        foreach ($DeliveryArray as $delivery) {

            if (strpos($delivery['city'], '.')) {
                $name = explode(".", $delivery['city']);
                $delivery['city'] = $name[0];
            }

            if (in_array($delivery['id'], @explode(",", $data['delivery_id'])))
                $delivery_id = $delivery['id'];
            else
                $delivery_id = null;

            $delivery_value[] = array($delivery['city'], $delivery['id'], $delivery_id);
        }
        foreach ($DeliveryArray as $delivery) {

            if (strpos($delivery['city'], '.')) {
                $name = explode(".", $delivery['city']);
                $delivery['city'] = $name[0];
            }

            if (in_array($delivery['id'], @explode(",", $data['express_delivery_id'])))
                $express_delivery_id = $delivery['id'];
            else
                $express_delivery_id = null;

            $express_delivery_value[] = array($delivery['city'], $delivery['id'],  $express_delivery_id);
        }
    }

    $Tab1 = $PHPShopGUI->setField('API Key', $PHPShopGUI->setInputText(false, 'api_id_new', $data['api_id'], 300));
    $Tab1.= $PHPShopGUI->setField('����', $PHPShopGUI->setInputText(false, 'key_new', $data['key'], 300));
    $Tab1.= $PHPShopGUI->setField('������ ��� ��������', $PHPShopGUI->setSelect('status_new', $status, 300));
    $Tab1.= $PHPShopGUI->setField('��������', $PHPShopGUI->setSelect('delivery_id_new[]', $delivery_value, 300, null, false, $search = false, false, $size = 1, $multiple = true));
    $Tab1.= $PHPShopGUI->setField('����� ����������', $PHPShopGUI->setCheckbox("dev_mode_new", 1, "�������� ������ �� �������� �����", $data["dev_mode"]));
    $Tab1.= $PHPShopGUI->setCollapse('��� � �������� �� ���������',
        $PHPShopGUI->setField('���, ��.', $PHPShopGUI->setInputText('', 'weight_new', $data['weight'],300)) .
        $PHPShopGUI->setField('������, ��.', $PHPShopGUI->setInputText('', 'width_new', $data['width'],300)) .
        $PHPShopGUI->setField('������, ��.', $PHPShopGUI->setInputText('', 'height_new', $data['height'],300)) .
        $PHPShopGUI->setField('�����, ��.', $PHPShopGUI->setInputText('', 'length_new', $data['length'],300))
    );

    $info =
       '<h4>��������� ������</h4>
        <ol>
        <li>������������������ � <a href="http://shop-logistics.ru" target="_blank">Shop-Logistics</a>, ��������� �������.</li>
        <li>����������� �� <a href="https://client-shop-logistics.ru/index.php?route=account/account" target="_blank">���� ������</a> API ID � ��������������� ���� �������� ������.</li>
        <li>������� � <a href="https://client-shop-logistics.ru/index.php?route=calculate/options" target="_blank">��������� ������������</a> �������� � ��������� ����� �����������.</li>
        <li>����������� ���� ������������ ������������ � ��������������� ���� �������� ������.</li>
        <li>������� ������ ��� �������� ������ � ������ ������� Shop-Logistics.</li>
        <li>��������� ��������� ���� � ��������� �� ���������.</li>
        </ol>
        
       <h4>��������� ��������</h4>
        <ol>
        <li>� �������� �������������� �������� � �������� <kbd>��������� ��������� ��������</kbd> ��������� �������������� �������� ���������� ��������� �������� ��� ������. ����� "�� �������� ���������" ������ ���� �������.</li>
        <li>� �������� �������������� �������� ������� <kbd>������ ������� � ������ ��</kbd></li>
         <li>� �������� �������������� �������� � �������� <kbd>������ ������������</kbd> �������� <kbd>�������</kbd> "���." � "������������"</li>
         <li>� �������� �������������� �������� � �������� <kbd>������ ������������</kbd> �������� <kbd>�����</kbd> "���." � "������������"</li>
         <li>� �������� �������������� �������� � �������� <kbd>������ ������������</kbd> �������� <kbd>���</kbd> "���." � "������������"</li>
        <li>������� � ����/��������� �����������, ������� <kbd>citylist_install.sql</kbd> � ������� <kbd>������������</kbd></li>
        </ol>

';

    $Tab2 = $PHPShopGUI->setInfo($info);

    // ����� �����������
    $Tab4 = $PHPShopGUI->setPay($serial = false, false, $data['version'], true);

    // ����� ����� ��������
    $PHPShopGUI->setTab(array("��������", $Tab1, true), array("����������", $Tab2), array("� ������", $Tab4));

    // ����� ������ ��������� � ����� � �����
    $ContentFooter =
            $PHPShopGUI->setInput("hidden", "rowID", $data['id']) .
            $PHPShopGUI->setInput("submit", "saveID", "���������", "right", 80, "", "but", "actionUpdate.modules.edit");

    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}

// ��������� �������
$PHPShopGUI->getAction();

// ����� ����� ��� ������
$PHPShopGUI->setLoader($_POST['editID'], 'actionStart');
?>
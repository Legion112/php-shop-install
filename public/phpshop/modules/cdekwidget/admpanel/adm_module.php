<?php

PHPShopObj::loadClass("order");
PHPShopObj::loadClass("delivery");

// SQL
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.cdekwidget.cdekwidget_system"));

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

    // ��������� �������
    $PHPShopModules->updateOption($_GET['id'], $_POST['servers']);
    
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

    if (empty($_POST['test_new']))
        $_POST['test_new'] = 0;

    $_POST['city_from_code_new'] = getCityCode($_POST['city_from_new']);

    $PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.cdekwidget.cdekwidget_system"));
    $PHPShopOrm->debug = false;
    $action = $PHPShopOrm->update($_POST);

    header('Location: ?path=modules&id=' . $_GET['id']);

    return $action;
}

function actionStart() {
    global $PHPShopGUI, $PHPShopOrm, $PHPShopSystem;

    $PHPShopGUI->addJSFiles('../modules/cdekwidget/admpanel/gui/script.gui.js');
    // ���������
    if ($PHPShopSystem->ifSerilizeParam('admoption.dadata_enabled')) {
        $PHPShopGUI->addJSFiles('./js/jquery.suggestions.min.js', './order/gui/dadata.gui.js');
        $PHPShopGUI->addCSSFiles('./css/suggestions.min.css');
    }

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
    }

    $Tab1 = $PHPShopGUI->setField('������� ����������', $PHPShopGUI->setInputText(false, 'account_new', $data['account'], 300));
    $Tab1.= $PHPShopGUI->setField('������ ����������', $PHPShopGUI->setInput("password", 'password_new', $data['password'], false, 300));
    $Tab1.= $PHPShopGUI->setField('����� ����������', $PHPShopGUI->setCheckbox("test_new", 1, "�������� ������ �� �������� ����� ����", $data["test"]));
    $Tab1.= $PHPShopGUI->setField('������ ��� ��������', $PHPShopGUI->setSelect('status_new', $status, 300));
    $Tab1.= $PHPShopGUI->setField('��������', $PHPShopGUI->setSelect('delivery_id_new[]', $delivery_value, 300, null, false, $search = false, false, $size = 1, $multiple = true));
    $Tab1.= $PHPShopGUI->setField('����� �������� �����������', $PHPShopGUI->setInputText(false, 'city_from_new', $data['city_from'], 300));
    $Tab1.= $PHPShopGUI->setField('�������� ������ ������ �����������', '<input class="form-control input-sm " onkeypress="cdekvalidate(event)" type="text" value="' . $data['index_from'] . '" name="index_from_new" style="width:300px; ">');
    $Tab1.= $PHPShopGUI->setField('����� �� ����� �� ���������', $PHPShopGUI->setInputText(false, 'default_city_new', $data['default_city'], 300));
    $Tab1.= $PHPShopGUI->setField('�������� �������', '<input class="form-control input-sm " onkeypress="cdekvalidate(event)" type="number" step="0.1" min="0" value="' . $data['fee'] . '" name="fee_new" style="width:300px;">');
    $Tab1.= $PHPShopGUI->setField('��� �������', $PHPShopGUI->setSelect('fee_type_new', array(array('%', 1, $data['fee_type']), array('���.', 2, $data['fee_type'])), 300, null, false, $search = false, false, $size = 1));
    $Tab1.= $PHPShopGUI->setCollapse('��� � �������� �� ���������',
        $PHPShopGUI->setField('���, ��.', '<input class="form-control input-sm " onkeypress="cdekvalidate(event)" type="number" step="1" min="1" value="' . $data['weight'] . '" name="weight_new" style="width:300px; ">') .
        $PHPShopGUI->setField('������, ��.', '<input class="form-control input-sm " onkeypress="cdekvalidate(event)" type="number" step="1" min="1" value="' . $data['width'] . '" name="width_new" style="width:300px;">') .
        $PHPShopGUI->setField('������, ��.', '<input class="form-control input-sm " onkeypress="cdekvalidate(event)" type="number" step="1" min="1" value="' . $data['height'] . '" name="height_new" style="width:300px;">') .
        $PHPShopGUI->setField('�����, ��.', '<input class="form-control input-sm " onkeypress="cdekvalidate(event)" type="number" step="1" min="1" value="' . $data['length'] . '" name="length_new" style="width:300px;">')
    );

    $info = '<h4>��������� �������� ����������</h4>
       <ol>
        <li>������������������ � <a href="https://www.cdek.ru" target="_blank">����</a>, ��������� �������.</li>
        <li>������� ������ �� ������������ ������� ������ (Account � Secure_password) ��� ���������� �� email: <a href="mailto:integrator@cdek.ru">integrator@cdek.ru</a>.</li>
        </ol>
        
       <h4>��������� ������</h4>
        <ol>
        <li>������� ������ �������� ��� ������ ������.</li>
        <li>������ ������� � ������ ����������.</li>
        <li>������ ����� �������� �����������.</li>
        <li>������ ����� �� ��������� ��� �������� �����.</li>
        <li>������� ������ ��� �������� ������ � ������ ������� ����.</li>
        </ol>
        
       <h4>��������� ��������</h4>
        <ol>
        <li>� �������� �������������� �������� � �������� <kbd>��������� ��������� ��������</kbd> ��������� �������������� �������� ���������� ��������� �������� ��� ������. ����� "�� �������� ���������" ������ ���� �������.</li>
        <li>� �������� �������������� �������� � �������� <kbd>������ ������������</kbd> �������� <kbd>������</kbd> "���." � "������������"</li>
         <li>� �������� �������������� �������� � �������� <kbd>������ ������������</kbd> �������� <kbd>�������</kbd> "���." � "������������"</li>
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

function getCityCode($city) {
   $url = 'http://api.cdek.ru/city/getListByTerm/jsonPost.php';

   $params = array(
       'q'               => PHPShopString::win_utf8($city),
       'limit'           => 1,
       'displayPostCode' => false,
       'countryIsoList'  => array('RU'),
       'regionIdList'    => false,
       'cityIdList'      => false
   );

    if ( $curl = curl_init() ) {
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
        $responce = json_decode(curl_exec($curl), true);
        curl_close($curl);
    }
    if ($responce) {
        return $responce['geonames'][0]['id'];
    }
}

// ��������� �������
$PHPShopGUI->getAction();

// ����� ����� ��� ������
$PHPShopGUI->setLoader($_POST['editID'], 'actionStart');
?>
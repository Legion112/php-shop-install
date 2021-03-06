<?php
PHPShopObj::loadClass('order');

// SQL
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['avangard']['avangard_system']);
// ������� ����������
function actionUpdate() {
    global $PHPShopOrm;
    $PHPShopOrm->debug = false;

    if (empty($_POST["dev_mode_new"]))
        $_POST["dev_mode_new"] = 0;

    $action = $PHPShopOrm->update($_POST);
    header('Location: ?path=modules&id=' . $_GET['id']);
    return $action;
}

function actionStart() {
    global $PHPShopGUI, $PHPShopOrm;

    include_once '../modules/avangard/class/Avangard.php';

    // �������
    $data = $PHPShopOrm->select();

    $Tab1 = $PHPShopGUI->setInfo('<p>������ ���������� ��������-�������� � ��������� ������ ����� ��������, ��������� ��������� ������ ������ ���������� ������.
 ����� ������� ������, ���������� ���������� ����������� ��������� �� ��������������� �������.</p>');

    $Tab2 = $PHPShopGUI->setField('ID ��������:', '<input class="form-control input-sm" type="number" step="1" min="0" value="' . $data['shop_id'] . '" name="shop_id_new" style="width:300px; ">');
    $Tab2 .= $PHPShopGUI->setField('������ ��������:', $PHPShopGUI->setInput('password', 'password_new', $data['password'], false, 300));
    $Tab2 .= $PHPShopGUI->setField('������� ��������:', $PHPShopGUI->setInput('text', 'shop_sign_new', $data['shop_sign'], false, 300));
    $Tab2 .= $PHPShopGUI->setField('������� ������� ����������:', $PHPShopGUI->setInput('text', 'av_sign_new', $data['av_sign'], false, 300));

    // �������� ������� �������
    $PHPShopOrderStatusArray = new PHPShopOrderStatusArray();
    $OrderStatusArray = $PHPShopOrderStatusArray->getArray();
    $order_status_value[] = array(__('����� �����'), 0, $data['status_id']);
    if (is_array($OrderStatusArray))
        foreach ($OrderStatusArray as $order_status)
            $order_status_value[] = array($order_status['name'], $order_status['id'], $data['status_id']);

    // ������ ������
    $Tab2 .= $PHPShopGUI->setField('������ ��� �������:', $PHPShopGUI->setSelect('status_id_new', $order_status_value, 300));
    $Tab2 .= $PHPShopGUI->setField('��������� ��������������� ��������:', $PHPShopGUI->setTextarea('title_sub_new', $data['title_sub'], false, 300));
    $Tab2 .= $PHPShopGUI->setField('�������� ������:', $PHPShopGUI->setTextarea('title_payment_new', $data['title_payment'], false, 300));

    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['page']);
    $page = $PHPShopOrm->select(array('*'), false, array('order' => 'name asc'));

    $value = array();
    $value[] = array('�� ������������', 0, $data['page_id']);
    if (is_array($page))
        foreach ($page as $val) {
            $value[] = array($val['name'], $val['id'], $data['page_id']);
        }

    $Tab2.=$PHPShopGUI->setField('�������� �������� ������:', $PHPShopGUI->setSelect('page_id_new', $value, '300px', false, false, false, false, false, false));

    // ����������
    $info = '
        <h4>��������� ������</h4>
        <ol>
<li>������������ ����������� ��������� � ��������� ������� � ������ <a href="https://www.avangard.ru/rus/" target="_blank">��������</a></li>
<li>�� �������� ��������� ������ "ID ��������", ���������� �� �����.</li>
<li>�� �������� ��������� ������ "������ ��������", ���������� �� �����.</li>
<li>�� �������� ��������� ������ "������� ��������", ���������� �� �����.</li>
<li>�� �������� ��������� ������ "������� ������� ����������", ���������� �� �����.</li>
<li>� ������ �������� <a href="https://www.avangard.ru/rus/" target="_blank">��������</a> ������� URL ����������� �� �������� �������: <code>' . Avangard::getProtocol() . $_SERVER['SERVER_NAME'] . '/phpshop/modules/avangard/payment/check.php</code> <br></li>
</ol>
';

    // ����� ����� ��������
    $PHPShopGUI->setTab(array("���������", $Tab2, true), array("����������", $info, true), array("� ������", $Tab1));

    // ����� ������ ��������� � ����� � �����
    $ContentFooter = $PHPShopGUI->setInput("submit", "saveID", "���������", "right", 80, "", "but", "actionUpdate.modules.edit");

    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}

// ��������� �������
$PHPShopGUI->getAction();

// ����� ����� ��� ������
$PHPShopGUI->setLoader($_POST['editID'], 'actionStart');
?>
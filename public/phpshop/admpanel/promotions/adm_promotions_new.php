<?php

PHPShopObj::loadClass("category");

$TitlePage = __('�������� ����������');
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['promotion']);

// ���������� ������ ���������
function treegenerator($array, $i, $curent, $dop_cat_array) {
    global $tree_array;
    $del = '�&nbsp;&nbsp;&nbsp;&nbsp;';
    $tree_select = $tree_select_dop = $check = false;

    $del = str_repeat($del, $i);
    if (is_array($array['sub'])) {
        foreach ($array['sub'] as $k => $v) {

            $check = treegenerator($tree_array[$k], $i + 1, $k, $dop_cat_array);

            $selected = null;
            $disabled = null;

            if (is_array($dop_cat_array))
                foreach ($dop_cat_array as $vs) {
                    if ($k == $vs)
                        $selected = "selected";
                }

            if (empty($check['select'])) {
                $tree_select .= '<option value="' . $k . '" ' . $selected . $disabled . '>' . $del . $v . '</option>';

                $i = 1;
            } else {
                $tree_select .= '<option value="' . $k . '" ' . $selected . ' disabled>' . $del . $v . '</option>';
            }

            $tree_select .= $check['select'];
        }
    }
    return array('select' => $tree_select);
}

// ������� ������
function actionInsert() {
    global $PHPShopOrm, $PHPShopModules;

    $_POST['enabled_new'] = $_POST['enabled_new'][0];

    $_POST['categories_new'] = "";
    if (is_array($_POST['categories']) and $_POST['categories'][0] != 'null') {
        foreach ($_POST['categories'] as $v)
            if (!empty($v) and !strstr($v, ','))
                $_POST['categories_new'] .= $v . ",";
    }

    if(!empty($_POST['products_new'])) {
        $products = array();
        $orm = new PHPShopOrm($GLOBALS['SysValue']['base']['products']);
        $parents = $orm->getList(array('id', 'parent'), array('parent_enabled' => "='0' AND id IN (" . $_POST['products_new'] . ")"));

        foreach ($parents as $parent) {
            $products[] = $parent['id'];
            if(!empty($parent['parent'])) {
                $products = array_merge($products, explode(',', $parent['parent']));
            }
        }
    }

    if (is_array($_POST['statuses']))
        $_POST['statuses_new'] = serialize($_POST['statuses']);

    $PHPShopOrm->updateZeroVars('block_old_price_new', 'status_check_new', 'hide_old_price_new', 'discount_tip_new', 'products_check_new', 'categories_check_new', 'discount_check_new', 'active_check_new', 'enabled_new');

    // �������� ������
    $PHPShopModules->setAdmHandler(__FILE__, __FUNCTION__, $_POST);

    $action = $PHPShopOrm->insert($_POST);

    if ($_POST['saveID'] == '������� � �������������')
        header('Location: ?path=' . $_GET['path'] . '&id=' . $action);
    else
        header('Location: ?path=' . $_GET['path']);
    return $action;
}

// ��������� ������� ��������
function actionStart() {
    global $PHPShopGUI, $PHPShopOrm, $TitlePage, $PHPShopModules;


    $data['name'] = "����� ������";
    $data['enabled'] = 1;

    // ����� ����
    $PHPShopGUI->addJSFiles('./js/jquery.tagsinput.min.js', './js/bootstrap-datetimepicker.min.js', './promotions/gui/promotions.gui.js');
    $PHPShopGUI->addCSSFiles('./css/jquery.tagsinput.css', './css/bootstrap-datetimepicker.min.css');

    $PHPShopGUI->field_col = 2;
    $PHPShopGUI->setActionPanel($TitlePage, false, array('������� � �������������', '��������� � �������'));

    $Tab1 = $PHPShopGUI->setField('��������', $PHPShopGUI->setInputText('', 'name_new', $data['name'])) .
            $PHPShopGUI->setField('������', $PHPShopGUI->setRadio("enabled_new[]", 1, "����������", $data['enabled']) . $PHPShopGUI->setRadio("enabled_new[]", 0, "������", $data['enabled']));

    $Tab1 .= $PHPShopGUI->setCollapse('����������', $PHPShopGUI->setField('������', $PHPShopGUI->setCheckbox("active_check_new", 1, "��������� ����������", $data['active_check'])) . $PHPShopGUI->setField('������', $PHPShopGUI->setInputDate("active_date_ot_new", $data['active_date_ot'])) . $PHPShopGUI->setField('����������', $PHPShopGUI->setInputDate("active_date_do_new", $data['active_date_do']))
    );

    $Tab1.=$PHPShopGUI->setCollapse('������', 
            $PHPShopGUI->setField('���', $PHPShopGUI->setRadio("discount_tip_new", 1, "%", $data['discount_tip']) . $PHPShopGUI->setRadio("discount_tip_new", 0, "�����", $data['discount_tip']), 'left') .
            $PHPShopGUI->setField('������', $PHPShopGUI->setInputText('', 'discount_new', $data['discount'], '100'))
    );

    $PHPShopCategoryArray = new PHPShopCategoryArray($where);
    $CategoryArray = $PHPShopCategoryArray->getArray();
    $GLOBALS['count'] = count($CategoryArray);

    $CategoryArray[0]['name'] = '- ' . __('�������� �������') . ' -';
    $tree_array = array();

    foreach ($PHPShopCategoryArray->getKey('parent_to.id', true) as $k => $v) {
        foreach ($v as $cat) {
            $tree_array[$k]['sub'][$cat] = $CategoryArray[$cat]['name'];
        }
        $tree_array[$k]['name'] = $CategoryArray[$k]['name'];
        $tree_array[$k]['id'] = $k;
        if ($k == $data['parent_to'])
            $tree_array[$k]['selected'] = true;
    }

    $GLOBALS['tree_array'] = &$tree_array;

    // �����������
    $dop_cat_array = preg_split('/,/', $data['categories'], -1, PREG_SPLIT_NO_EMPTY);

    if (is_array($tree_array[0]['sub']))
        foreach ($tree_array[0]['sub'] as $k => $v) {
            $check = treegenerator($tree_array[$k], 1, $k, $dop_cat_array);


            // �����������
            $selected_ = null;
            if (is_array($dop_cat_array))
                foreach ($dop_cat_array as $vs) {
                    if ($k == $vs)
                        $selected = "selected";
                }

            if (empty($tree_array[$k]))
                $disabled = null;
            else
                $disabled = ' disabled';

            $tree_select .= '<option value="' . $k . '"  ' . $selected . $disabled . '>' . $v . '</option>';

            $tree_select .= $check['select'];
        }


    $tree_select = '<select class="selectpicker show-menu-arrow hidden-edit" data-live-search="true" data-container=""  data-style="btn btn-default btn-sm" name="categories[]"  data-width="100%" multiple>' . $tree_select . '</select>';

    // ������� ����������
    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['shopusers_status']);
    $data_user_status = $PHPShopOrm->select(array('id,name'), false, array('order' => 'name'), array('limit' => 100));
    $status_array = unserialize($data['statuses']);
    array_unshift($data_user_status, array('id' => 0, 'name' => '���������� ��� �������'));

    foreach ($data_user_status as $value) {
        if (is_array($status_array) && in_array($value['id'], $status_array))
            $sel = 'selected';
        else
            $sel = false;
        $value_user_status[] = array($value['name'], $value['id'], $sel);
    }

    $Tab1.=$PHPShopGUI->setCollapse('�������', $PHPShopGUI->setField('������ ����������', $PHPShopGUI->setCheckbox('status_check_new', 1, '��������� ������ ����������', $data['status_check']) . '<br>' .
                    $PHPShopGUI->setSelect('statuses[]', $value_user_status, '300', true, false, false, '300', false, true)) .
            $PHPShopGUI->setField('���������', $PHPShopGUI->setHelp('�������� ��������� ������� �/��� ������� ID ������� ��� �����.') . $PHPShopGUI->setCheckbox("categories_check_new", 1, "��������� ��������� ������", $data['categories_check']) .
                    $PHPShopGUI->setCheckbox("categories_all", 1, "������� ��� ���������?", 0) .
                    $tree_select) .
            $PHPShopGUI->setField('������', $PHPShopGUI->setCheckbox("products_check_new", 1, "��������� ������", $data['products_check']) . $PHPShopGUI->setCheckbox("block_old_price_new", 1, "������������ ������ �� ������ �����", $data['block_old_price']) . $PHPShopGUI->setCheckbox("hide_old_price_new", 1, "�� ���������� ���� ��� ������", $data['hide_old_price']) .
                    $PHPShopGUI->setTextarea('products_new', $data['products'], false, false, false, __('������� ID ������� ��� ��������������') . ' <a href="#" data-target="#products_new"  class="btn btn-sm btn-default tag-search"><span class="glyphicon glyphicon-search"></span> ' . __('������� �������') . '</a>'))
    );
    
    $Tab1.=$PHPShopGUI->setField('����� ������ �� �����', $PHPShopGUI->setInputText('', 'label_new', $data['label']));

    // ������ ������ �� ��������
    $PHPShopModules->setAdmHandler(__FILE__, __FUNCTION__, $data);

    // ����� ����� ��������
    $PHPShopGUI->setTab(array("��������", $Tab1, true));

    // ����� ������ ��������� � ����� � �����
    $ContentFooter = $PHPShopGUI->setInput("submit", "saveID", "���������", "right", false, false, false, "actionInsert.servers.create");

    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}

// ��������� �������
$PHPShopGUI->getAction();

// ����� ����� ��� ������
$PHPShopGUI->setLoader($_POST['saveID'], 'actionStart');
?>
<?php

PHPShopObj::loadClass("page");
PHPShopObj::loadClass("string");

$TitlePage = __('����� ��������');
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['page']);

// ���������� ������ ���������
function treegenerator($array, $i, $curent) {
    global $tree_array;
    $del = '�&nbsp;&nbsp;&nbsp;&nbsp;';
    $tree_select = $check = false;

    $del = str_repeat($del, $i);
    if (is_array($array['sub'])) {
        foreach ($array['sub'] as $k => $v) {

            $check = treegenerator($tree_array[$k], $i + 1, $curent);

            if ($k == $curent)
                $selected = 'selected';
            else
                $selected = null;

            if (empty($check['select'])) {
                $tree_select.='<option value="' . $k . '" ' . $selected . '>' . $del . $v . '</option>';
                $i = 1;
            } else {
                $tree_select.='<option value="' . $k . '" ' . $selected . '>' . $del . $v . '</option>';
            }

            $tree_select.=$check['select'];
        }
    }
    return array('select' => $tree_select);
}

function actionStart() {
    global $PHPShopGUI, $PHPShopSystem, $PHPShopModules, $TitlePage;

    // ��������� ������
    $data = array();
    $data['num'] = 1;
    $data['enabled'] = 1;
    $data['category'] = $_GET['cat'];

    $PHPShopGUI->field_col = 2;
    $PHPShopGUI->setActionPanel($TitlePage, false, array('������� � �������������', '��������� � �������'));

    $PHPShopGUI->addJSFiles('./js/jquery.tagsinput.min.js', './js/bootstrap-datetimepicker.min.js', './page/gui/page.gui.js');
    $PHPShopGUI->addCSSFiles('./css/jquery.tagsinput.css', './css/bootstrap-datetimepicker.min.css');

    $PHPShopCategoryArray = new PHPShopPageCategoryArray();
    $CategoryArray = $PHPShopCategoryArray->getArray();

    $CategoryArray[0]['name'] = '- ' . __('�������� �������') . ' -';
    $tree_array = array();

    $PHPShopCategoryArrayKey = $PHPShopCategoryArray->getKey('parent_to.id', true);
    if (is_array($PHPShopCategoryArrayKey))
        foreach ($PHPShopCategoryArrayKey as $k => $v) {
            foreach ($v as $cat) {
                $tree_array[$k]['sub'][$cat] = $CategoryArray[$cat]['name'];
            }
            $tree_array[$k]['name'] = $CategoryArray[$k]['name'];
            $tree_array[$k]['id'] = $k;
        }


    $GLOBALS['tree_array'] = &$tree_array;

    $tree_select = '<select class="selectpicker show-menu-arrow hidden-edit" data-container=""  data-style="btn btn-default btn-sm" name="category_new" data-width="100%">';

    $tree_array[0]['sub'][1000] = __('������� ���� �����');
    $tree_array[0]['sub'][2000] = __('��������� ��������');

    $tree_select.='<option value="0" ' . $data['category'] . ' data-subtext="<span class=\'glyphicon glyphicon-cog\'></span> ' . __('���������') . '">' . __('���������� ��������') . '</option>';
    if (is_array($tree_array[0]['sub']))
        foreach ($tree_array[0]['sub'] as $k => $v) {
            $check = treegenerator($tree_array[$k], 1, $data['category']);

            if ($k == $data['category'])
                $selected = 'selected';
            else
                $selected = null;

            if (in_array($k, array(1000, 2000)))
                $subtext = 'data-subtext="<span class=\'glyphicon glyphicon-cog\'></span> ' . __('���������') . '"';
            else
                $subtext = null;

            $tree_select.='<option value="' . $k . '" ' . $selected . ' ' . $subtext . '>' . $v . '</option>';

            $tree_select.=$check['select'];
        }
    $tree_select.='</select>';


    // �������� 1
    $PHPShopGUI->setEditor($PHPShopSystem->getSerilizeParam("admoption.editor"));
    $oFCKeditor = new Editor('content_new');
    $oFCKeditor->Height = '550';
    $oFCKeditor->Value = $data['content'];

    // ���������� �������� 1
    $Tab1 = $PHPShopGUI->setCollapse('����������', $PHPShopGUI->setField("����������", $tree_select) .
            $PHPShopGUI->setField("���������", $PHPShopGUI->setInput("text.requared", "name_new", $data['name'])) .
            $PHPShopGUI->setField("����������", $PHPShopGUI->setInputText("�", "num_new", $data['num'], 150)) .
            $PHPShopGUI->setField("URL ������", $PHPShopGUI->setInputText('/page/', "link_new", $data['link'], '100%', '.html')));

    $SelectValue[] = array('����� � ��������', 1, $data['enabled']);
    $SelectValue[] = array('�������������', 0, $data['enabled']);

    $Tab1.= $PHPShopGUI->setField("����� ������", $PHPShopGUI->setSelect("enabled_new", $SelectValue, 300));
    
    // �����
    $Tab1 .= $PHPShopGUI->setField("������", $PHPShopGUI->setCheckbox('footer_new', 1, '������� ���� � �������', 1));


    // ���������� �������� 3
    $Tab3 = $PHPShopGUI->setField("Title: ", $PHPShopGUI->setTextarea("title_new", $data['title']));
    $Tab3.=$PHPShopGUI->setField("Description: ", $PHPShopGUI->setTextarea("description_new", $data['description']));
    $Tab3.=$PHPShopGUI->setField("Keywords: ", $PHPShopGUI->setTextarea("keywords_new", $data['keywords']));

    $Tab1.=$PHPShopGUI->setCollapse('SEO / ����-������', $Tab3);

    // ������������
    $SecurityValue[] = array('���� �������������', 0, $data['secure']);
    $SecurityValue[] = array('������ ������������������ �������������', 1, $data['secure']);
    $Tab1.=$PHPShopGUI->setCollapse('�����������', $PHPShopGUI->setField("����������", $PHPShopGUI->setSelect("secure_new", $SecurityValue, 300)) .
            $PHPShopGUI->setField("�������", $PHPShopGUI->loadLib('tab_multibase', $data, 'catalog/')));

    // ������
    $Tab4 = $PHPShopGUI->setField("�����������", $PHPShopGUI->setIcon($data['icon'], "icon_new", false));

    // ����
    $Tab4 .= $PHPShopGUI->setField("����", $PHPShopGUI->setInputDate("datas_new", PHPShopDate::get($data['datas'])));

    // ������������� ������
    $Tab4.=$PHPShopGUI->setField('������������� ������ ��� ���������� �������', $PHPShopGUI->setTextarea('odnotip_new', $data['odnotip'], false, false, false, __('������� ID ������� ��� ��������������') . ' <a href="#" data-target="#odnotip_new"  class="btn btn-sm btn-default tag-search"><span class="glyphicon glyphicon-search"></span> ' . __('������� �������') . '</a>'));

    // �����
    $oFCKeditor2 = new Editor('preview_new');
    $oFCKeditor2->Height = '270';
    $oFCKeditor2->Value = $data['preview'];
    $Tab4.=$PHPShopGUI->setField("�����", $oFCKeditor2->AddGUI());

    // ������ ������ �� ��������
    $PHPShopModules->setAdmHandler(__FILE__, __FUNCTION__, $data);

    // ����� ����� ��������
    $PHPShopGUI->setTab(array("��������", $Tab1), array("����������", $oFCKeditor->AddGUI()), array("�������������", $Tab4, true));

    // ����� ������ ��������� � ����� � �����
    $ContentFooter = $PHPShopGUI->setInput("submit", "saveID", "��", "right", 70, "", "but", "actionInsert.page.create");

    // �����
    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}

/**
 * ����� ������
 * @return bool 
 */
function actionInsert() {
    global $PHPShopModules, $PHPShopOrm;

    // ������������� ������ ��������
    $PHPShopOrm->updateZeroVars('enabled_new', 'secure_new', 'footer_new');

    if (empty($_POST['link_new']))
        $_POST['link_new'] = PHPShopString::toLatin($_POST['name_new']);

    if (!empty($_POST['datas_new']))
        $_POST['datas_new'] = PHPShopDate::GetUnixTime($_POST['datas_new']);
    else
        $_POST['datas_new'] = PHPShopDate::GetUnixTime($_POST['datas_new']);

    // ����������
    $_POST['servers_new'] = "";
    if (is_array($_POST['servers']))
        foreach ($_POST['servers'] as $v)
            if ($v != 'null' and !strstr($v, ','))
                $_POST['servers_new'].="i" . $v . "i";

    $_POST['icon_new'] = iconAdd();

    // �������� ������
    $PHPShopModules->setAdmHandler(__FILE__, __FUNCTION__, $_POST);

    $action = $PHPShopOrm->insert($_POST);

    if ($_POST['saveID'] == '������� � �������������')
        header('Location: ?path=page&return=page.catalog&id=' . $action);
    else
        header('Location: ?path=page.catalog&cat=' . $_POST['category_new']);

    return $action;
}

// ���������� ����������� 
function iconAdd() {
    global $PHPShopSystem;

    // ����� ����������
    $path = $GLOBALS['SysValue']['dir']['dir'] . '/UserFiles/Image/' . $PHPShopSystem->getSerilizeParam('admoption.image_result_path');

    // �������� �� ������������
    if (!empty($_FILES['file']['name'])) {
        $_FILES['file']['ext'] = PHPShopSecurity::getExt($_FILES['file']['name']);
        if (in_array($_FILES['file']['ext'], array('gif', 'png', 'jpg', 'jpeg', 'svg'))) {
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

// ��������� �������
$PHPShopGUI->getAction();

// ����� ����� ��� ������
$PHPShopGUI->setLoader($_POST['editID'], 'actionStart');
?>

<?php

// ���������
$TitlePage = __("������");

function getFileInfo($file) {
    $f = parse_ini_file_true("../../license/" . $file, 1);

    if ($f['License']['Pro'] == 'Start')
        $_SESSION['mod_limit'] = 5;
    else
        $_SESSION['mod_limit'] = 50;

    return $f['License']['SupportExpires'];
}

if (!getenv("COMSPEC"))
    define("EXPIRES", PHPShopFile::searchFile("../../license/", 'getFileInfo'));
else {
    define("EXPIRES", time() + 100000);
}

// ���������� �� ������
function GetModuleInfo($name) {
    $path = "../modules/" . $name . "/install/module.xml";
    return xml2array($path, false, true);
}

function ChekInstallModule($path, $num = false) {
    global $link_db;

    $return = array();
    $sql = 'SELECT a.*, b.key FROM ' . $GLOBALS['SysValue']['base']['modules'] . ' AS a LEFT OUTER JOIN ' . $GLOBALS['SysValue']['base']['modules_key'] . ' AS b ON a.path = b.path where a.path="' . $path . '"';

    $result = mysqli_query($link_db, $sql);
    $row = mysqli_fetch_array($result);
    if (mysqli_num_rows($result) > 0) {
        $return[0] = "#C0D2EC";
        $return[1] = array('status' => array('enable' => 1, 'align' => 'right', 'caption' => array('����', '���')));
        $return[2] = $row['date'];
        $return[3] = $row['key'];
    } elseif ($num >= $_SESSION['mod_limit']) {

        $return[0] = "white";
        $return[1] = array('name' => '<span class="glyphicon glyphicon-lock pull-right text-muted" data-toggle="tooltip" data-placement="left" title="����� ��������"></span>');
        $return[2] = null;
        $return[3] = $row['key'];
    } else {
        $return[0] = "white";
        $return[1] = array('status' => array('enable' => 0, 'align' => 'right', 'caption' => array('<span class="text-muted">����</span>', '���')));
        $return[2] = null;
        $return[3] = $row['key'];
    }
    return $return;
}

function actionStart() {
    global $PHPShopInterface, $PHPShopBase,$TitlePage;


    $PHPShopInterface->action_select['��������� ���������'] = array(
        'name' => '��������� ���������',
        'action' => 'module-off-select',
        'class' => 'disabled',
        'url' => '#'
    );

    $PHPShopInterface->action_select['�������� ���������'] = array(
        'name' => '�������� ���������',
        'action' => 'module-on-select',
        'class' => 'disabled',
        'url' => '#'
    );

    if ($PHPShopBase->Rule->CheckedRules('modules', 'remove')) {
        $PHPShopInterface->action_button['���������'] = array(
            'name' => '',
            'action' => '',
            'class' => 'btn btn-default btn-sm navbar-btn load-module',
            'type' => 'button',
            'icon' => 'glyphicon glyphicon-plus',
            'tooltip' => 'data-toggle="tooltip" data-placement="left" title="'.__('��������� ������').'"'
        );
    }


    $PHPShopInterface->action_title['manual'] = '����������';


    if ($_SESSION['mod_limit'] > 5)
        $PHPShopInterface->setActionPanel($TitlePage, array('��������� ���������', '�������� ���������'), array('���������'));
    else
        $PHPShopInterface->setActionPanel($TitlePage, false);


    $PHPShopInterface->setCaption(
            array(null, "3%"), array("��������", "60%"), array("�����������", "15%"), array("", "10%"), array("������" . "", "7%", array('align' => 'right'))
    );

    $PHPShopInterface->addJSFiles('./js/jquery.treegrid.js', './modules/gui/modules.gui.js');
    $PHPShopInterface->path = 'modules.action';


    $where = false;
    if (!empty($_GET['cat'])) {
        $where = array('category' => '=' . intval($_GET['cat']));
    }

    // ���������� ������������� �������
    if (empty($_GET['install'])) {
        $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['modules']);
        $data = $PHPShopOrm->select(array('*'), false, false, array('limit' => intval($_SESSION['mod_limit'])));
        $num = count($data);
    }


    $path = "../modules/";
    $i = 1;

    if (isset($_GET['install'])) {

        $active_tree_menu = 'install';

        $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['modules']);
        $data = $PHPShopOrm->select(array('*'), false, array('order' => 'date desc'), array('limit' => intval($_SESSION['mod_limit'])));
        $num = count($data);
        if (is_array($data))
            foreach ($data as $row) {
                $ChekInstallModule = ChekInstallModule($row['path']);
                $drop_menu = null;

                // ���������� �� ������
                $Info = GetModuleInfo($row['path']);

                if (!empty($Info['status']))
                    $new = '<span class="label label-primary">' . $Info['status'] . '</span>';
                else
                    $new = null;

                if (!empty($Info['faqlink']))
                    $wikiPath = $Info['faqlink'];
                else
                    $wikiPath = null;

                if (!empty($Info['trial']) and empty($ChekInstallModule[3])) {
                    $trial = ' (Trial 30 ����)';
                }
                else
                    $trial = null;


                if (!$PHPShopBase->Rule->CheckedRules('modules', 'edit')) {
                    $status = '<span class="glyphicon glyphicon-lock pull-right"></span>';
                    $drop_menu = null;
                } else {
                    $status = $ChekInstallModule[1];

                    if(!empty($wikiPath))
                    $drop_menu = array('option', 'manual', 'id' => $row['path']);
                    else $drop_menu = array('option','id' => $row['path']);


                    // ���� ������
                    if (is_array($Info['adminmenu']['podmenu'][0])) {
                        foreach ($Info['adminmenu']['podmenu'] as $menu_value) {
                            array_push($drop_menu, array('name' => $menu_value['podmenu_name'], 'url' => '?path=modules.' . $menu_value['podmenu_action']));
                        }
                    } else {
                        array_push($drop_menu, array('name' => $Info['adminmenu']['podmenu']['podmenu_name'], 'url' => '?path=modules.' . $Info['adminmenu']['podmenu']['podmenu_action']));
                    }

                    array_push($drop_menu, '|');
                    array_push($drop_menu, 'off');
                }

                $name = '<div class="modules-list">
                            <a href="?path=modules&id=' . $row['path'] . '" data-wiki="' . $wikiPath . '">' . $Info['name'] . ' ' . $Info['version'] . $trial . '</a> ' . $new . '<br>' . $Info['description'] . '</div>';


                $PHPShopInterface->setRow($row['path'], $name, '<span class="install-date">' . PHPShopDate::get($row['date']) . '</span>', array('action' => $drop_menu, 'align' => 'center'), $status);

                $i++;
            }
    } elseif (@$dh = opendir($path)) {

        $active_tree_menu = $_GET['cat'];

        while (($file = readdir($dh)) !== false) {
            if ($file != "." && $file != "..") {

                if (is_dir($path . $file)) {

                    // ���������� �� ������
                    $Info = GetModuleInfo($file);

                    if (!empty($Info['status']))
                        $new = '<span class="label label-primary">' . $Info['status'] . '</span>';
                    else
                        $new = null;

                    // ���� ������� ���������
                    if (isset($_GET['cat']) and @strstr($Info['category'], $_GET['cat']) and empty($Info['hidden'])) {

                        $ChekInstallModule = ChekInstallModule($file, $num);

                        // ����������
                        if (!empty($Info['faqlink']))
                            $wikiPath = $Info['faqlink'];
                        else
                            $wikiPath = null;

                        // ���� ���������
                        if (!empty($ChekInstallModule[2])) {
                            $InstallDate = date("d-m-Y", $ChekInstallModule[2]);
                            $drop_menu = array('option', 'manual', '|', 'off', 'id' => $file);
                        } elseif ($num < $_SESSION['mod_limit']) {
                            $InstallDate = null;
                            if(!empty($wikiPath))
                            $drop_menu = array('manual', '|', 'on', 'id' => $file);
                            else $drop_menu = array('on', 'id' => $file);
                        } else {
                            $InstallDate = null;
                            $drop_menu = null;
                        }

                        if (!empty($Info['trial']) and empty($ChekInstallModule[3])) {
                            $trial = ' (Trial 30 ����)';
                        }
                        else
                            $trial = null;


                        if (!$PHPShopBase->Rule->CheckedRules('modules', 'edit') or EXPIRES < $Info['sign']) {
                            $status = '<span class="glyphicon glyphicon-lock pull-right"></span>';
                            unset($drop_menu);
                        }
                        else
                            $status = $ChekInstallModule[1];

                        $name = '<div class="modules-list">
                            <a href="?path=modules&id=' . $file . '" data-wiki="' . $wikiPath . '">' . __($Info['name']) . ' ' . $Info['version'] . $trial . '</a> ' . $new . '<br>' . $Info['description'] . '</div>';


                        $PHPShopInterface->setRow($file, $name, '<span class="install-date">' . $InstallDate . '</span>', array('action' => $drop_menu, 'align' => 'center'), $status);

                        $i++;
                    }
                    // ����� ���� �������
                    elseif (empty($_GET['cat']) and empty($Info['hidden'])) {

                        $active_tree_menu = 'all';

                        $ChekInstallModule = ChekInstallModule($file, $num);

                        if (!empty($Info['status']))
                            $new = '<span class="label label-primary">' . $Info['status'] . '</span>';
                        else
                            $new = null;
                        
                         // ����������
                        if (!empty($Info['faqlink']))
                            $wikiPath = $Info['faqlink'];
                        else
                            $wikiPath = null;

                        // ���� ���������
                        if (!empty($ChekInstallModule[2])) {
                            $InstallDate = date("d-m-Y", $ChekInstallModule[2]);
                            $drop_menu = array('option', 'manual', '|', 'off', 'id' => $file);
                        } elseif ($num < $_SESSION['mod_limit']) {
                            $InstallDate = null;
                            if(!empty($wikiPath))
                            $drop_menu = array('manual', '|', 'on', 'id' => $file);
                            else $drop_menu = array('on', 'id' => $file);
                        } else {
                            $InstallDate = null;
                            $drop_menu = null;
                        }

                        if (!empty($Info['trial']) and empty($ChekInstallModule[3])) {
                            $trial = ' (Trial 30 ����)';
                        }
                        else
                            $trial = null;

                        if (!$PHPShopBase->Rule->CheckedRules('modules', 'edit') or EXPIRES < $Info['sign']) {
                            $status = '<span class="glyphicon glyphicon-lock pull-right"></span> ';
                            unset($drop_menu);
                        }
                        else
                            $status = $ChekInstallModule[1];

                        $name = '<div class="modules-list">
                            <a href="?path=modules&id=' . $file . '" data-wiki="' . $wikiPath . '">' . $Info['name'] . ' ' . $Info['version'] . $trial . '</a> ' . $new . '<br>' . __($Info['description']) . '</div>';

                        $PHPShopInterface->setRow($file, $name, '<span class="install-date">' . $InstallDate . '</span>', array('action' => $drop_menu, 'align' => 'center'), $status);
                        $i++;
                    }
                }
            }
        }
        closedir($dh);
    }

    if ($num == $_SESSION['mod_limit'])
        $label_class = 'label-warning';
    else
        $label_class = 'label-primary';

    $tree = '<table class="table table-hover">
        <tr class="treegrid-all">
           <td><a href="?path=modules" class="treegrid-parent" data-parent="treegrid-all">'.__('��� ������').'</a> <span id="mod-install-count" class="label label-primary pull-right">84</span></td>
	</tr>
        <tr class="treegrid-template">
           <td><a href="?path=modules&cat=template" class="treegrid-parent" data-parent="treegrid-template">'.__('������').'</a> <span id="mod-install-count" class="label label-primary pull-right">6</span></td>
	</tr>
        <tr class="treegrid-form">
           <td><a href="?path=modules&cat=form" class="treegrid-parent" data-parent="treegrid-form">'.__('���������').'</a> <span id="mod-install-count" class="label label-primary pull-right">10</span></td>
	</tr>
        <tr class="treegrid-soc">
           <td><a href="?path=modules&cat=soc" class="treegrid-parent" data-parent="treegrid-soc">'.__('���������� ����').'</a> <span id="mod-install-count" class="label label-primary pull-right">3</span></td>
	</tr>
        <tr class="treegrid-seo">
           <td><a href="?path=modules&cat=seo" class="treegrid-parent" data-parent="treegrid-seo">SEO</a> <span id="mod-install-count" class="label label-primary pull-right">5</span></td>
	</tr>
        <tr class="treegrid-delivery">
           <td><a href="?path=modules&cat=delivery" class="treegrid-parent" data-parent="treegrid-delivery">'.__('��������').'</a> <span id="mod-install-count" class="label label-primary pull-right">11</span></td>
	</tr>
        <tr class="treegrid-chat">
           <td><a href="?path=modules&cat=chat" class="treegrid-parent" data-parent="treegrid-delivery">'.__('���� � ������').'</a> <span id="mod-install-count" class="label label-primary pull-right">5</span></td>
	</tr>
        <tr class="treegrid-crm">
           <td><a href="?path=modules&cat=crm" class="treegrid-parent" data-parent="treegrid-crm">CRM</a> <span id="mod-install-count" class="label label-primary pull-right">3</span></td>
	</tr>
        <tr class="treegrid-payment">
           <td><a href="?path=modules&cat=payment" class="treegrid-parent" data-parent="treegrid-payment">'.__('��������� �������').'</a> <span id="mod-install-count" class="label label-primary pull-right">26</span></td>
	</tr>
       <tr class="treegrid-credit">
           <td><a href="?path=modules&cat=credit" class="treegrid-parent" data-parent="treegrid-payment">'.__('������������').'</a> <span id="mod-install-count" class="label label-primary pull-right">3</span></td>
	</tr>
        <tr class="treegrid-yandex">
           <td><a href="?path=modules&cat=yandex" class="treegrid-parent" data-parent="treegrid-yandex">'.__('������').'</a> <span id="mod-install-count" class="label label-primary pull-right">4</span></td>
	</tr>
        <tr class="treegrid-sale">
           <td><a href="?path=modules&cat=sale" class="treegrid-parent" data-parent="treegrid-sale5">'.__('�������').'</a> <span id="mod-install-count" class="label label-primary pull-right">5</span></td>
	</tr>
        <tr class="treegrid-develop">
           <td><a href="?path=modules&cat=develop" class="treegrid-parent" data-parent="treegrid-develop">'.__('�������������').'</a> <span id="mod-install-count" class="label label-primary pull-right">14</span></td>
	</tr>
        <tr class="treegrid-install">
           <td><a href="?path=modules&install=check" class="treegrid-parent" data-parent="treegrid-install">'.__('�������������').'</a> <span id="mod-install-count" class="label ' . $label_class . ' pull-right">' . $num . '</span></td>
	</tr>
    </table>
    <script>
    var modcat="' . $active_tree_menu . '";
    </script>';

    $sidebarleft[] = array('title' => '���������', 'content' => $tree);
    $PHPShopInterface->setSidebarLeft($sidebarleft, 3);

    $PHPShopInterface->Compile(3);
}

?>
<?php

/**
 * ����� ��������� � �������������� � ������ �������� ������������
 * @package PHPShopCoreDepricated
 * @param int $UID �� ������������
 * @return string
 */
function MessageList($UID = 0) {
    global $SysValue,$link_db;
    $display = null;

    // �������� ������� � ��
    $sql = Page_messages($UID);

    $result = mysqli_query($link_db,$sql);
    while ($row = mysqli_fetch_array($result)) {
        $UID = $row['UID'];
        $AID = $row['AID'];
        if ($AID) { //�������� ��� ��������������, ���� ��������� �� ������
            $sqlad = 'select * from ' . $SysValue['base']['table_name19'] . ' WHERE id=' . intval($AID);
            $resultad = mysqli_query($link_db,$sqlad);
            $rowad = mysqli_fetch_array($resultad);
            if (strlen($rowad['name'])) {
                $name = $rowad['name'];
            } else {
                $name = '��������';
            }
            $color = 'style="background:#C0D2EC;"';
        } else { //��� ��� ������������
            $sqlus = 'select * from ' . $SysValue['base']['table_name27'] . ' WHERE id=' . intval($UID);
            $resultus = mysqli_query($link_db,$sqlus);
            $rowus = mysqli_fetch_array($resultus);
            $name = $rowus['name'];
            $color = '';
        }
        $DataTime = $row['DateTime'];
        $Subject = PHPShopSecurity::TotalClean($row['Subject']);
        $Message = strip_tags($row['Message'],'<b><hr><br>');

        if (strlen($Subject) > 1) {
            $Subject = '<B>' . $Subject . '</B><BR>';
        }

        $display.="<tr >
	<td " . $color . " id=allspecwhite>
                $DataTime<BR>
	��: <B>$name</B>
	</td>
	<td " . $color . " id=allspecwhite>
                $Subject
                $Message</td></tr>";
    }
    return $display;
}

/**
 * �������� SQL ������� � �� �� ����� ��������� ������������
 * @package PHPShopCoreDepricated
 * @param int $UID �� ������������
 * @return string
 */
function Page_messages($UID = 0) {
    global $SysValue;

    $p = $SysValue['nav']['id'];
    if (empty($p))
        $p = 1;
    $num_row = 10;
    $num_ot = 0;
    $q = 0;
    while ($q < $p) {
        $sql = "select * from " . $SysValue['base']['table_name37'] . " where (UID=" . $UID . ") order by DateTime DESC LIMIT $num_ot, $num_row ";
        $q++;
        $num_ot = $num_ot + $num_row;
    }
    return $sql;
}

// ����� ���-��
function NumFrom($from_base, $query) {
    global $SysValue,$link_db;
    $sql = "select COUNT('id') as count from " . $SysValue['base'][$from_base] . " " . $query;
    @$result = mysqli_query($link_db,$sql);
    @$row = mysqli_fetch_array(@$result);
    @$num = $row['count'];
    return @$num;
}

/**
 * ��������� �� ���������� � ������ �������� ������������
 * @package PHPShopCoreDepricated
 * @param int $UID �� ������������
 * @return string
 */
function Nav_messages($UID = 0) {
    global $SysValue;

    $navigat = $nava = null;
    $p = $SysValue['nav']['id'];
    if (empty($p))
        $p = 1;
    $num_row = 10;
    $num_page = NumFrom("table_name37", " where (UID=" . intval($UID) . ")");
    $i = 1;
    $num = $num_page / $num_row;
    while ($i < $num + 1) {
        if ($i != $p) {
            if ($i == 1) {
                $pageOt = $i + $pageDo;
            } else {
                $pageOt = $i + $pageDo - $i;
            }
            $pageDo = $i * $num_row;
            $navigat.="\n<a href=\"./message_" . $i . ".html\">" . $pageOt . "-" . $pageDo . "</a> | ";
        } else {
            if ($i == 1) {
                $pageOt = $i + @$pageDo;
            } else {
                $pageOt = $i + @$pageDo - $i;
            }
            $pageDo = $i * $num_row;
            $navigat.="\n<b>" . $pageOt . "-" . $pageDo . "</b> | ";
        }
        $i++;
    }
    if ($num > 1) {
        if ($p > $num) {
            $p_to = $i - 1;
        } else {
            $p_to = $p + 1;
        }
        $nava = "<table cellpadding=\"0\" cellpadding=\"0\" border=\"0\"><tr><td>
	" . $SysValue['lang']['page_now'] . ":
	<a href=\"./message_" . ($p - 1) . ".html\">" . ($p - 1) . "</a>
                $navigat&nbsp<a href=\"./message_" . $p_to . ".html\">$p_to</a>
		</td></tr></table>";
    }
    return $nava;
}

/**
 * ����������� ��������� ��������� �� ������� �������� ������������
 * @package PHPShopCoreDepricated
 * @param int $UsersId �� ������������
 * @return string
 */
function user_message($obj) {
    global $SysValue,$link_db;

    $statusMail = null;
    $sql = "select * from " . $SysValue['base']['table_name27'] . " where id=" . intval($obj->UsersId) . " LIMIT 0, 1";
    $result = mysqli_query($link_db,$sql);
    $row = mysqli_fetch_array($result);
    $id = $row['id'];
    $login = $row['login'];
    $mail = $row['mail'];
    $name = $row['name'];

    // mail ���������
    if (!empty($_POST['message'])) {
        $zag_adm = __("��������� ��������� �� ������������")." " . $name;
        $content_adm = "{������� �������}!

{�������� ������ � �����} '" . $obj->PHPShopSystem->getName() . "'
{�� ������������} " . $name . "

{������������}: " . $login . "
---------------------------------------------------------

" . PHPShopSecurity::TotalClean($_POST['message'], 2) . "

{����}: " . date("d-m-y H:i a") . "
IP:" . $_SERVER['REMOTE_ADDR'];

        // �������� e-mail ��������������
        new PHPShopMail($obj->PHPShopSystem->getValue('adminmail2'), $obj->PHPShopSystem->getValue('adminmail2'), $zag_adm, Parser($content_adm), false,false,array('replyto'=>$mail));
        $sql = 'select * from ' . $SysValue['base']['table_name37'] . ' where (UID=' . $id . ') order by DateTime DESC';
        $result = mysqli_query($link_db,$sql);
        $row = mysqli_fetch_array($result);

        if ($row['AID'] == "0") {
            $DateTime = $row['DateTime'];
            $message = PHPShopSecurity::TotalClean($_POST['message'], 2) . "<HR>" . $row['DateTime'] . ": " . $row['Message'];
            $sql = 'UPDATE ' . $SysValue['base']['table_name37'] . ' SET Message="' . $message . '", DateTime="' . date("Y-m-d H:i:s") . '", enabled=\'0\' WHERE ID=' . $row['ID'];
            $result = mysqli_query($link_db,$sql);
            $p = $SysValue['nav']['id'];
            if (empty($p))
                $p = 1;
            if ($p > 1) {
                $nav = '_' . $p;
            } else {
                $nav = '';
            }
            header("Location: ./message$nav.html");
        } else {
            $sql = 'INSERT INTO ' . $SysValue['base']['table_name37'] . ' VALUES ("",0,' . $id . ',\'\',\'' . date("Y-m-d H:i:s") . '\',\'' . PHPShopSecurity::TotalClean($_POST['Subject'], 2) . '\',\'' . PHPShopSecurity::TotalClean($_POST['message'], 2) . '\',"0")';
            $result = mysqli_query($link_db,$sql);
            header("Location: ./message.html");
        }

    }
    // ����� ������ ���������
    $display = MessageList($id);

    // �������� ���������
    $sql = 'select * from ' . $SysValue['base']['table_name37'] . ' where (UID=' . intval($id) . ') order by DateTime DESC';
    $result = mysqli_query($link_db,$sql);
    $i = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);

    if (($row['AID'] == 0) && ($i)) {
        $Subject = $row['Subject'];
        $Subjectreadonly = ' readonly disabled';
        $message = $row['Message'];
        $oldmessage = '<B>{�� ������ ��������� ���� ���������. ������� �������������� �����}:</B><BR>';
    } else {
        $Subject = '';
        $Subjectreadonly = '';
        $message = '';
        $oldmessage = '<B>{����� ���������}</B><br>';
    }

    if ($i) {
        $display = '<H4>{������� ���������}</H4>
<table id="allspecwhite" cellpadding="1" cellspacing="1" width="100%" class="table table-striped">
<tr>
	<td width="20%" id=allspec><span name=txtLang id=txtLang>{����}</span></td>
	<td width="80%" id=allspec><span name=txtLang id=txtLang>{���������}</span></td>
</tr>
	' . $display . '</table>' . Nav_messages($id);
    } else {
        $display = '';
    }

    $disp = '
<table class="user-table-fix" style="width:80%;">
<tr>
  <td>
  <form method="post" name="forma_message" id="forma_message">
  <B>{��������� ���������}</B><BR>
  <input type="TEXT" style="width:80%;" value="' . $Subject . '" ' . $Subjectreadonly . ' name="Subject"><BR>
  ' . $oldmessage . '
  <textarea style="height:100px;" name="message" id="message"></textarea>
  <div>
  <br>
  <input type="button" class="btn btn-primary" value="{������ ������ ���������}" id="CheckMessage" onclick="if(typeof checkMessageText == \'function\') checkMessageText();">
  </div>
  </form>
  </td>
</tr>
</table>
   ' . $display;

    $obj->set('formaTitle', __('����� � �����������'));
    $obj->set('formaContent', $disp);
    $obj->ParseTemplate($obj->getValue('templates.users_page_list'));
}

?>

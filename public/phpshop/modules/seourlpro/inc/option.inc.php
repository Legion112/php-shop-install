<?php

if (!defined("OBJENABLED"))
    exit(header('Location: /?error=OBJENABLED'));

// �������� �� 404 ������ ��� ������ ���� ��� SEO Pro
if ($PHPShopNav->notPath(array('page')) and !@strpos($PHPShopNav->getName(true), '/', 2))
    $SysValue['nav']['path'] = 'index';

class PHPShopCategorySeoProArray extends PHPShopArray {

    /**
     * �����������
     * @param string $sql SQL ������� �������
     */
    function __construct($sql = false) {
        $this->objSQL = $sql;
        $this->cache = false;
        $this->order = array('order' => 'num');
        $this->objBase = $GLOBALS['SysValue']['base']['categories'];
        parent::__construct("id", "name", "cat_seo_name");
    }

}

class PHPShopPageCategorySeoProArray extends PHPShopArray {

    /**
     * �����������
     * @param string $sql SQL ������� �������
     */
    function __construct($sql = false) {
        $this->objSQL = $sql;
        $this->cache = false;
        $this->order = array('order' => 'num');
        $this->objBase = $GLOBALS['SysValue']['base']['page_categories'];
        parent::__construct("id", "name", "page_cat_seo_name");
    }

}

class PHPShopSeoPro {

    var $cat_pre = 'shop/CID_';
    var $prod_pre = 'shop/UID_';
    var $prod_pre_target = 'id/';
    var $cat_page_pre = 'page/CID_';
    var $true_dir = false;

    function __construct() {

        $this->memory = $GLOBALS['modules']['seourlpro']['map'];
        $this->memory_prod = $GLOBALS['modules']['seourlpro']['map_prod'];
        $url = explode("?", $_SERVER["REQUEST_URI"]);
        $this->url = pathinfo($url[0]);
    }

    /*
     *  ������ ��������� � ������
     */

    function getNav() {
        $url = $this->url;

        // ��������� / � �������, ������ sony/audio-video-foto-super.html => /cat/sony/audio-video-foto-super.html
        if ($this->true_dir) {
            if (strpos($GLOBALS['PHPShopNav']->getName(true), '/', 2)) {
                $GLOBALS['SysValue']['nav']['path'] = 'index';
                $url['filename'] = substr($url['dirname'], 1, strlen($url['dirname']) - 1) . '/' . $url['filename'];
            }
        }

        $array_seo_name = explode('-', $url['filename']);
        $page = $array_seo_name[count($array_seo_name) - 1];

        if (!is_numeric($page) and $page != 'ALL')
            $page = null;

        if ($page >= 1)
            $file = substr($url['filename'], 0, strlen($url['filename']) - strlen($page) - 1);
        else
            $file = $url['filename'];

        return array('page' => $page, 'file' => $file, 'name' => $url['filename']);
    }

    /**
     * ��������� ��������� ID �������� 
     */
    function getCID() {
        $getNav = $this->getNav();
        $array_true = array_flip($this->memory);
        return str_replace($this->cat_pre, '', $array_true[$getNav['file']]);
    }

    /**
     * ��������� ��������� ID ������
     */
    function getID() {
        $getNav = $this->getNav();
        return $getNav['page'];
    }

    function setRout($mode = 1) {

        $getNav = $this->getNav();
        $file = $getNav['file'];
        $page = $getNav['page'];
        //$name = $getNav['name'];

        if ($page == 'ALL')
            $GLOBALS['PHPShopNav']->objNav['page'] = $page;
        else
            $GLOBALS['PHPShopNav']->objNav['page'] = intval($page);
        $GLOBALS['PHPShopNav']->objNav['path'] = 'shop';

        if ($mode == 1) {

            $array_true = array_flip($this->memory);
            $GLOBALS['PHPShopNav']->objNav['name'] = 'CID';
            $true_id = str_replace($this->cat_pre, '', $array_true[$file]);
        } elseif ($mode == 2) {

            //$array_true = array_flip($this->memory_prod);
            $GLOBALS['PHPShopNav']->objNav['name'] = 'UID';
            // $true_id = str_replace($this->prod_pre, '', $array_true[$name]);
            $true_id = $page;
        }

        $GLOBALS['PHPShopNav']->objNav['id'] = intval($true_id);
        $GLOBALS['SysValue']['nav']['id'] = intval($true_id);
    }

    function setMemory($id, $name, $mode = 1, $latin = true) {
        if ($mode == 1) {
            $this->memory[$this->cat_pre . $id] = $this->setLatin($name, $latin);

            if (strstr($name, '/')) {
                $this->memory['./CID_' . $id . '_1'] = '/' . $this->setLatin($name . '-1', $latin);
            }
            else
                $this->memory['CID_' . $id . '_1'] = $this->setLatin($name . '-1', $latin);

            //$this->memory['CID_' . $key . '_1'] = $this->setLatin($val['name'] . '-1');
        } elseif ($mode == 2)
            $this->memory_prod[$this->prod_pre . $id] = $this->prod_pre_target . $this->setLatin($name, $latin) . '-' . $id;
        elseif ($mode == 3)
            $this->memory[$this->cat_page_pre . $id] = 'page/' . $this->setLatin($name, $latin);
    }

    function setLatin($str, $enabled = true) {
        if ($enabled) {
            $str = PHPShopString::toLatin(trim($str));
            $str = str_replace("_", "-", $str);
            //$str = str_replace("/", "-", $str);
        }

        return $str;
    }

    function catArrayToMemory() {

        $PHPShopCategoryArray = new PHPShopCategorySeoProArray();
        foreach ($PHPShopCategoryArray->getArray() as $key => $val) {

            if (!empty($val['cat_seo_name'])) {
                $this->setMemory($key, $val['cat_seo_name'], 1, false);
                $this->memory['CID_' . $key . '_1'] = $this->setLatin($val['cat_seo_name'] . '-1');
                $this->memory['shop/CID_' . $key . '_ALL'] = $this->setLatin($val['cat_seo_name']) . '-ALL';
            } else {
                $this->setMemory($key, $val['name']);
                $this->memory['CID_' . $key . '_1'] = $this->setLatin($val['name'] . '-1');
                $this->memory['shop/CID_' . $key . '_ALL'] = $this->setLatin($val['name']) . '-ALL';
            }
        }
    }

    function catPageArrayToMemory() {

        $PHPShopPageCategoryArray = new PHPShopPageCategorySeoProArray();

        foreach ($PHPShopPageCategoryArray->getArray() as $key => $val) {

            if (!empty($val['page_cat_seo_name'])) {
                $this->setMemory($key, $val['page_cat_seo_name'], 3, false);
            } else {
                $this->setMemory($key, $val['name'], 3);
            }
        }
    }

    function catCacheToMemory() {

        if (is_array($GLOBALS['Cache'][$GLOBALS['SysValue']['base']['categories']]))
            foreach ($GLOBALS['Cache'][$GLOBALS['SysValue']['base']['categories']] as $key => $val) {
                $this->setMemory($key, $val['name']);
                $this->memory['CID_' . $key . '_1'] = $this->setLatin($val['name'] . '-1');
                $this->memory['shop/CID_' . $key . '_ALL'] = $this->setLatin($val['name']) . '-ALL';
            }
    }

    function stro_replace($search, $replace, $subject) {
        return strtr($subject, array_combine($search, $replace));
    }

    function AjaxCompile($result) {

        // ������
        if (is_array($this->memory_prod)) {
            $array_str_prod = array_values($this->memory_prod);
            $array_id_prod = array_keys($this->memory_prod);
            $result = $this->stro_replace($array_id_prod, $array_str_prod, $result);
        }

        return $result;
    }

    function Compile($obj) {
        global $PHPShopModules;

        $this->catArrayToMemory();

        // ��������� ������� ������ ���������
        // $this->catCacheToMemory();
        //$this->catArrayToMemory();
        //print_r($this->memory);
        //print_r($this->memory_prod);
        // ��������
        if (is_array($this->memory)) {
            $array_str = array_values($this->memory);
            $array_id = array_keys($this->memory);
        }

        // ������
        if (is_array($this->memory_prod)) {
            $array_str_prod = array_values($this->memory_prod);
            $array_id_prod = array_keys($this->memory_prod);
        }


        ob_start();

        ob_implicit_flush(0);
        ParseTemplate($obj->getValue($obj->template));
        $result = ob_get_clean();

        // ���������������� ��� ������� ������ ������
        ob_end_clean();

        if (is_array($this->memory))
            $result = $this->stro_replace($array_id, $array_str, $result);

        if (is_array($this->memory_prod))
            $result = $this->stro_replace($array_id_prod, $array_str_prod, $result);

        echo $result;
    }

}

$GLOBALS['PHPShopSeoPro'] = new PHPShopSeoPro();
?>
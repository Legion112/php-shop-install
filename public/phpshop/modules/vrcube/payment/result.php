<?php /** @noinspection AutoloadingIssuesInspection */

/**
 * ���������� ���������� � ������� Vrcube
 */
session_start();

$_classPath = '../../../';
include($_classPath . 'class/obj.class.php');
PHPShopObj::loadClass('base');
PHPShopObj::loadClass('order');
PHPShopObj::loadClass('file');
PHPShopObj::loadClass('orm');
PHPShopObj::loadClass('payment');
PHPShopObj::loadClass('modules');
PHPShopObj::loadClass('system');

$PHPShopBase = new PHPShopBase($_classPath . 'inc/config.ini', true, true);

$PHPShopModules = new PHPShopModules($_classPath . 'modules/');
$PHPShopModules->checkInstall('vrcube');

/**
 * Class VrcubePayment
 * @property string $option
 * @property string $payment_name
 * @property string $inv_id
 * @property string $crc
 * @property string $my_crc
 * @property float $out_summ
 */
class VrcubePayment extends PHPShopPaymentResult {

    public function __construct() {

//        $this->log = true;
        $this->option();

        parent::__construct();
    }

    /**
     * ��������� ������
     */
    public function option() {
        $this->payment_name = 'Vrcube';
        include_once('../hook/mod_option.hook.php');
        $options = new PHPShopVrcubeArray();
        $this->option = $options->getArray();
    }

    /**
     * ������� ���������� �������
     */
    function done() {
        echo 'ok';
        $this->log();
    }

    /**
     * ������
     * @param int $type
     */
    function error($type = 1) {
        if ($type == 1) {
            echo "bad order num\n";
        } else {
            echo "bad cost\n";
        }
        $this->log();
    }

    /**
     * �������� �������
     * @return boolean
     */
    function check() {

        $this->crc = $_REQUEST['sign'];
        /** @noinspection PhpIllegalStringOffsetInspection */
        $this->my_crc = md5(
            (int) $this->option['contract_id']
            . $_REQUEST['payment_id']
            . $_REQUEST['status']
            . $_REQUEST['cf']
            . $_REQUEST['cf2']
            . $_REQUEST['cf3']
            . trim($this->option['vrcube_secret_word'])
        );
        $this->inv_id = str_replace('-', '', $_REQUEST['cf']);
        $this->inv_id = trim($this->inv_id);

        $this->out_summ = (float)$_REQUEST['amount'];

        $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['orders']);
        $data = $PHPShopOrm->select(array('*'), array('uid' => '="' . $this->true_num($this->inv_id) . '"'), false, array('limit' => 1));

        if (!is_array($data)) {
            return false;
        }
        if ($_REQUEST['status'] !== 'OK') {
            return false;
        }
//        if (number_format($data['sum'], 2, '.', '') !== number_format($this->out_summ, 2, '.', '')) {
//            return false;
//        }
        if ($this->crc != $this->my_crc) {
            return false;
        }

        return true;
    }
}

new VrcubePayment();


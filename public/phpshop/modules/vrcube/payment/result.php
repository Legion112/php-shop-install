<?php /** @noinspection AutoloadingIssuesInspection */
require_once(__DIR__ . '/../src/VrcubeCallbackTokenGenerator.php');
require_once(__DIR__.'/../src/CallbackStatus.php');
/**
 * Обработчик оповещения о платеже Vrcube
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
     * Настройка модуля
     */
    public function option() {
        $this->payment_name = 'Vrcube';
        require_once('../hook/mod_option.hook.php');
        $options = new PHPShopVrcubeArray();
        $this->option = $options->getArray();
    }

    /**
     * Удачное завершение поверки
     */
    function done() {
        echo 'ok';
        $this->log();
    }

    /**
     * Ошибка
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
     * Проверка подписи
     * @return boolean
     */
    function check() {

        $tokenChecker = new VrcubeCallbackTokenGenerator();
        $body = file_get_contents('php://input');
        $parameters = json_decode($body, true);


        $this->crc = $_SERVER['HTTP_X_SIGN'];
        /** @noinspection PhpIllegalStringOffsetInspection */
        $this->my_crc = $tokenChecker->generate($body, $this->option['vrcube_secret_word']);
        $this->inv_id = str_replace('-', '', $parameters['cf']);
        $this->inv_id = trim($this->inv_id);

        $this->out_summ = (float)$parameters['amount'];

        $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['orders']);
        $data = $PHPShopOrm->select(array('*'), array('uid' => '="' . $this->true_num($this->inv_id) . '"'), false, array('limit' => 1));

        if ($parameters['status'] !== CallbackStatus::$SUCCESS) {
            return false;
        }
        // Checking sing
        if ($this->crc != $this->my_crc) {
            return false;
        }

        if (!is_array($data)) {
            return false;
        }

        return true;
    }
}

new VrcubePayment();


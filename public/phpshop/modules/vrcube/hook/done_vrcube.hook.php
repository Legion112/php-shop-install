<?php
require_once(__DIR__.'/../VrcubeConstant.php');
require_once(__DIR__.'/../src/VrcubeTokenGenerator.php');
/**
 * @param PHPShopCore $obj
 * @param $value
 * @param $rout
 */
function send_to_order_mod_vrcube_hook($obj, $value, $rout)
{
    if ($rout === 'MIDDLE' && (int)$value['order_metod'] === VrcubeConstant::$PAYMENT_ID) {

        // ��������� ������
        include_once __DIR__ . '/mod_option.hook.php';
        $options = new PHPShopVrcubeArray();
        $options = $options->getArray();

        // �������� ������ �� ������� ������
        if (empty($options['status'])) {
            $orderId = $value['ouid'];
            // ����� �������
            $amount = number_format($obj->get('total'), 2, '.', '');


            $cf = $orderId;

            $domainUrl = isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : 'http';
            $domainUrl .= '://' . trim($_SERVER['SERVER_NAME'], '/');

            $tokenGenerator = new VrcubeTokenGenerator(); // TODO think about move to ServiceLocator

            $formParams = array(
                'product_id' => (int)$options['product_id'],
                'token' => $tokenGenerator->generate(
                    $options['contract_id'],
                    (int)$options['product_id'],
                    $amount,
                    $cf,
                    trim($options['vrcube_secret_word'])
                ),
                'amount' => $amount,
                'cf' => $cf,
                'email' => isset($_POST['mail']) ? $_POST['mail'] : '',
                'phone' => isset($_POST['tel_new']) ? $_POST['tel_new'] : '',

                'ok_url' => $domainUrl . '/success/',
                'ko_url' => $domainUrl . '/fail/',
                'cb_url' => $domainUrl . '/phpshop/modules/vrcube/payment/result.php',
            );

            // Email �����������
            if (!empty($value['mail'])) {
                $formParams['email'] = $value['mail'];
            }


            if ((int)$options['use_cashbox'] > 0 && !empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['system']);
                $systemSettings = $PHPShopOrm->select(array('nds'));

                $receipt = array();
                $taxLabels = array(
                    0 => 'vat0',
                    10 => 'vat10',
                    18 => 'vat18'
                );
                $tax = 'none';
                if (isset($systemSettings['nds'])) {
                    $tax = isset($taxLabels[$systemSettings['nds']]) ? $taxLabels[$systemSettings['nds']] : '';
                }

                foreach ($_SESSION['cart'] as $item) {
                    $name = str_replace(array('"', "'"), '', $item['name']);
                    $name = mb_convert_encoding($name, 'UTF-8', 'windows-1251');
                    $receipt[] = array(
                        'sum' => number_format($item['price'] * $item['num'], 2, '.', ''),
                        'tax' => $tax,
                        'name' => $name,
                        'price' => number_format($item['price'], 2, '.', ''),
                        'quantity' => number_format($item['num'], 2, '.', ''),
                    );
                }
                $receipt = array('items' => $receipt);
                $formParams['receipt'] = (string)json_encode($receipt);
            }


            $hiddenFields = '';
            foreach ($formParams as $formParamName => $formParamValue) {
                $hiddenFields .= '<input type="hidden" name="' . $formParamName . '" value=\'' . $formParamValue . '\'/>';
            }
            $obj->set('hiddenFields', $hiddenFields);

            $formUrl = trim($options['endpoint_url']);

            $obj->set('payment_forma_action', $formUrl);
            $obj->set('payment_forma_title', '�������� ����� � ' . $orderId);
            $obj->set('payment_info', $options['title']);
            $forma = ParseTemplateReturn(
                $GLOBALS['SysValue']['templates']['vrcube']['vrcube_payment_forma'],
                true
            );
        } else {
            $obj->set('mesageText', $options['title_sub']);
            $forma = ParseTemplateReturn($GLOBALS['SysValue']['templates']['order_forma_mesage']);
        }

        $obj->set('orderMesage', $forma);
    }
}

$addHandler = array(
    'send_to_order' => 'send_to_order_mod_vrcube_hook'
);

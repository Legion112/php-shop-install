<?php

class VrcubeTokenGenerator
{
    /**
     * @param $contractUuid string
     * @param $productId int
     * @param $amount string
     * @param $orderId string
     * @param $extraAmount
     * @param $vrcubeSecretWord string
     * @return string
     */
    public function generate($contractUuid, $productId, $amount, $orderId, $vrcubeSecretWord)
    {
        return hash('sha256', $contractUuid . $productId . $amount . $orderId . $vrcubeSecretWord);
    }
}

<?php

class VrcubeCallbackTokenGenerator
{

    /**
     * @param $sing string
     * @param $body string
     * @param $vrcubeSecretWord string
     * @return string
     */
    public function generate($body, $vrcubeSecretWord)
    {
        return hash('sha256', $body . $vrcubeSecretWord);
    }
}

<?php

use PHPUnit\Framework\TestCase;

class VrcubeCallbackTokenGeneratorTest extends TestCase
{
    public function testCfCannotBeNull()
    {
        $tokenGenerator = new VrcubeCallbackTokenGenerator();

        $body = file_get_contents(__DIR__ .'/../_data/callbackBody.json');
        $this->assertEquals(
            '4d1a841f3dce93d221bd4038fd1014278f47ecce1425e393cddd201f8dde9801',
            $tokenGenerator->generate(
                $body,
                'SECRET'
            )
        );
    }
}


<?php

use PHPUnit\Framework\TestCase;

class VrcubeTokenGeneratorTest extends TestCase
{
    public function testCfCannotBeNull()
    {
        $tokenGenerator = new VrcubeTokenGenerator();

        $this->assertEquals(
            '1df5ef9893e225f08931824dc3b5801277b446ebd48c38ff1d7cece7294ae4f2',
            $tokenGenerator->generate(
                '1',
                1,
                '1.0',
                '1',
                'SECRET'
            )
        );
    }
}

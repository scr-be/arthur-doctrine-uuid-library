<?php

namespace SR\Doctrine\Tests\DBAL\Types;

use SR\Doctrine\DBAL\Types\ConversionException;
use SR\Wonka\Utility\UnitTest\WonkaTestCase;

class ConversionExceptionTest extends WonkaTestCase
{
    public function testDefaultMessage()
    {
        $e = new ConversionException();

        $this->assertSame(ConversionException::MSG_ORM_TYPE_CONVERSION, $e->getMessage());
        $this->assertSame(ConversionException::CODE_ORM_GENERIC, $e->getCode());
    }
}

/* EOF */

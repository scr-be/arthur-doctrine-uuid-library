<?php

namespace Scribe\Doctrine\Tests\DBAL\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ramsey\Uuid\Uuid;
use Scribe\Wonka\Utility\UnitTest\WonkaTestCase;

class BinaryUuidTypeTest extends WonkaTestCase
{
    /**
     * @var AbstractPlatform
     */
    private $platform;

    /**
     * @var Type
     */
    private $type;

    public static function setUpBeforeClass()
    {
        if (class_exists('Doctrine\\DBAL\\Types\\Type')) {
            Type::addType('bin_uuid', 'Scribe\Doctrine\DBAL\Types\BinaryUuidType');
        }
    }
    protected function setUp()
    {
        $this->platform = $this->getMockBuilder('Doctrine\DBAL\Platforms\AbstractPlatform')
            ->setMethods(array('getBinaryTypeDeclarationSQL'))
            ->getMockForAbstractClass();
        $this->platform->expects($this->any())
            ->method('getBinaryTypeDeclarationSQL')
            ->will($this->returnValue('DUMMYBINARY(16)'));
        $this->type = Type::getType('bin_uuid');
    }

    public function testUuidConvertsToDatabaseValue()
    {
        $uuid = Uuid::fromString('4b6f3e59-6aeb-489f-9e89-dfb57839b9b3');
        $expected = hex2bin('4b6f3e596aeb489f9e89dfb57839b9b3');
        $actual = $this->type->convertToDatabaseValue($uuid, $this->platform);
        $this->assertEquals($expected, $actual);
    }

    public function testStringUuidConvertsToDatabaseValue()
    {
        $uuid = 'ff6f8cb0-c57d-11e1-9b21-0800200c9a66';
        $expected = hex2bin('ff6f8cb0c57d11e19b210800200c9a66');
        $actual = $this->type->convertToDatabaseValue($uuid, $this->platform);
        $this->assertEquals($expected, $actual);

        $uuid = '524da6f5-4418-4df0-b752-5184671d22a3';
        $expected = base64_decode('Uk2m9UQYTfC3UlGEZx0iow==');
        $actual = $this->type->convertToDatabaseValue($uuid, $this->platform);
        $this->assertEquals($expected, $actual);
    }

    public function testInvalidUuidConversionForDatabaseValue()
    {
        $this->setExpectedException('Doctrine\DBAL\Types\ConversionException');
        $this->type->convertToDatabaseValue('abcdefg', $this->platform);
    }

    public function testNullConversionForDatabaseValue()
    {
        $this->assertNull($this->type->convertToDatabaseValue(null, $this->platform));
    }

    public function testUuidConvertsToPHPValue()
    {
        $uuid = $this->type->convertToPHPValue(hex2bin('ff6f8cb0c57d11e19b210800200c9a66'), $this->platform);
        $this->assertInstanceOf('Ramsey\Uuid\Uuid', $uuid);
        $this->assertEquals('ff6f8cb0-c57d-11e1-9b21-0800200c9a66', $uuid->toString());
    }

    public function testInvalidUuidConversionForPHPValue()
    {
        $this->setExpectedException('Doctrine\DBAL\Types\ConversionException');
        $this->type->convertToPHPValue('abcdefg', $this->platform);
    }

    public function testNullConversionForPHPValue()
    {
        $this->assertNull($this->type->convertToPHPValue(null, $this->platform));
    }

    public function testReturnValueIfUuidForPHPValue()
    {
        $uuid = Uuid::uuid4();
        $this->assertSame($uuid, $this->type->convertToPHPValue($uuid, $this->platform));
    }

    public function testGetName()
    {
        $this->assertEquals('bin_uuid', $this->type->getName());
    }

    public function testGetGuidTypeDeclarationSQL()
    {
        $this->assertEquals('DUMMYBINARY(16)', $this->type->getSqlDeclaration(array('length' => 36), $this->platform));
    }

    public function testRequiresSQLCommentHint()
    {
        $this->assertTrue($this->type->requiresSQLCommentHint($this->platform));
    }
}

/* EOF */

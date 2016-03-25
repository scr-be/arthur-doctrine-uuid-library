<?php

namespace SR\Doctrine\Tests\DBAL\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ramsey\Uuid\Uuid;
use SR\Wonka\Utility\UnitTest\WonkaTestCase;

class StringUuidTypeTest extends WonkaTestCase
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
            Type::addType('str_uuid', 'SR\Doctrine\DBAL\Types\StringUuidType');
        }
    }

    protected function setUp()
    {
        $this->platform = $this->getMockBuilder('Doctrine\DBAL\Platforms\AbstractPlatform')
            ->setMethods(array('getGuidTypeDeclarationSQL'))
            ->getMockForAbstractClass();
        $this->platform->expects($this->any())
            ->method('getGuidTypeDeclarationSQL')
            ->will($this->returnValue('DUMMYVARCHAR()'));

        $this->type = Type::getType('str_uuid');
    }

    public function testUuidConvertsToDatabaseValue()
    {
        $uuid = Uuid::fromString('ff6f8cb0-c57d-11e1-9b21-0800200c9a66');
        $expected = 'ff6f8cb0-c57d-11e1-9b21-0800200c9a66';
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
        $uuid = $this->type->convertToPHPValue('4b6f3e59-6aeb-489f-9e89-dfb57839b9b3', $this->platform);
        $this->assertInstanceOf('Ramsey\Uuid\Uuid', $uuid);
        $this->assertEquals('4b6f3e59-6aeb-489f-9e89-dfb57839b9b3', $uuid->toString());
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
        $this->assertEquals('str_uuid', $this->type->getName());
    }

    public function testGetGuidTypeDeclarationSQL()
    {
        $this->assertEquals('DUMMYVARCHAR()', $this->type->getSqlDeclaration(array('length' => 36), $this->platform));
    }

    public function testRequiresSQLCommentHint()
    {
        $this->assertTrue($this->type->requiresSQLCommentHint($this->platform));
    }
}

/* EOF */

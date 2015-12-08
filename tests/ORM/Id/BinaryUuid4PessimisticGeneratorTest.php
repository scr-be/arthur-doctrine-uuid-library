<?php

/*
 * This file is part of the Scribe Doctrine UUID Library.
 *
 * (c) Scribe Inc. <oss@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Test\ORM\Id;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Entity;
use Ramsey\Uuid\Uuid;
use Scribe\Doctrine\ORM\Id\BinaryUuid4PessimisticGenerator;
use Scribe\Wonka\Utility\UnitTest\WonkaTestCase;

/**
 * Class BinaryUuid4PessimisticGeneratorTest.
 */
class BinaryUuid4PessimisticGeneratorTest extends WonkaTestCase
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Entity
     */
    private $entity;

    /**
     * @var ClassMetadata
     */
    private $meta;

    protected function setUp()
    {
        $this->meta = $this
            ->getMockBuilder('Doctrine\ORM\Mapping\ClassMetadata')
            ->disableOriginalConstructor()
            ->setMethods(['getName'])
            ->getMock();
        $this->meta
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('Scribe\Doctrine\ORM\Id\BinaryUuid4Generator'));
        $this->em = $this
            ->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->setMethods(['getClassMetadata', 'find'])
            ->getMock();
        $this->em
            ->expects($this->any())
            ->method('getClassMetadata')
            ->will($this->returnValue($this->meta));
        $this->em
            ->expects($this->any())
            ->method('find')
            ->will($this->returnValue(null));
        $this->entity = $this
            ->getMockBuilder('Scribe\Doctrine\ORM\Mapping\Entity')
            ->getMock();
    }

    public function testUuidConvertsToDatabaseValue()
    {
        $g = new BinaryUuid4PessimisticGenerator();
        $uuid = $g->generate($this->em, $this->entity);

        $this->assertTrue(Uuid::isValid($uuid));
    }

    public function testIsPreInsertGenerator()
    {
        $g = new BinaryUuid4PessimisticGenerator();
        $this->assertFalse($g->isPostInsertGenerator());
    }

    public function testThrownException()
    {
        $this->em
            ->expects($this->any())
            ->method('find')
            ->will($this->throwException(new \Doctrine\ORM\ORMException()));
        $this->setExpectedException('Scribe\Doctrine\Exception\ORMException');
        $g = new BinaryUuid4PessimisticGenerator();
        $g->generate($this->em, $this->entity);
    }
}

/* EOF */

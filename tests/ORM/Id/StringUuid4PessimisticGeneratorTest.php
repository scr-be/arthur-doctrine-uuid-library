<?php

/*
 * This file is part of the `src-run/arthur-doctrine-uuid-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\Test\ORM\Id;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Entity;
use Ramsey\Uuid\Uuid;
use SR\Doctrine\ORM\Id\StringUuid4Generator;
use SR\Doctrine\ORM\Id\StringUuid4PessimisticGenerator;

/**
 * Class StringUuid4PessimisticGeneratorTest.
 */
class StringUuid4PessimisticGeneratorTest extends \PHPUnit_Framework_TestCase
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
            ->will($this->returnValue('SR\Doctrine\ORM\Id\StringUuid4Generator'));
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
            ->getMockBuilder('SR\Doctrine\ORM\Mapping\Entity')
            ->getMock();
    }

    public function testUuidConvertsToDatabaseValue()
    {
        $g = new StringUuid4PessimisticGenerator();
        $uuid = $g->generate($this->em, $this->entity);

        $this->assertTrue(Uuid::isValid($uuid));
    }

    public function testIsPreInsertGenerator()
    {
        $g = new StringUuid4Generator();
        $this->assertFalse($g->isPostInsertGenerator());
    }

    public function testThrownException()
    {
        $this->em
            ->expects($this->any())
            ->method('find')
            ->will($this->throwException(new \Doctrine\ORM\ORMException()));
        $this->setExpectedException('SR\Doctrine\Exception\ORMException');
        $g = new StringUuid4PessimisticGenerator();
        $g->generate($this->em, $this->entity);
    }
}

/* EOF */

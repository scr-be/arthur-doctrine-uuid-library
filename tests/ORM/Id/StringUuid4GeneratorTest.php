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
use Doctrine\ORM\Mapping\Entity;
use Ramsey\Uuid\Uuid;
use Scribe\Doctrine\ORM\Id\StringUuid4Generator;
use Scribe\Wonka\Utility\UnitTest\WonkaTestCase;

/**
 * Class StringUuid4GeneratorTest.
 */
class StringUuid4GeneratorTest extends WonkaTestCase
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Entity
     */
    private $entity;

    protected function setUp()
    {
        $this->em = $this
            ->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->setMethods(['getClassMetadata'])
            ->getMock();
        $this->em->expects($this->any())
            ->method('getClassMetadata')
            ->will($this->returnValue((object)['name' => 'Scribe\Doctrine\ORM\Id\StringUuid4Generator']));
    }

    public function testUuidConvertsToDatabaseValue()
    {
        $g = new StringUuid4Generator();
        $uuid = $g->generate($this->em, $this->entity);

        $this->assertTrue(Uuid::isValid($uuid));
    }

    public function testIsPreInsertGenerator()
    {
        $g = new StringUuid4Generator();
        $this->assertFalse($g->isPostInsertGenerator());
    }
}

/* EOF */

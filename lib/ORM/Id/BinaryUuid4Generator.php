<?php

/*
 * This file is part of the Scribe Doctrine UUID Library.
 *
 * (c) Scribe Inc. <oss@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\ORM\Id;

use Doctrine\ORM\EntityManager;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid;
use Scribe\Doctrine\Exception\ORMException;

/**
 * Class OptimisticBinaryUuidGenerator.
 */
class BinaryUuid4Generator extends AbstractPreInsertIdGenerator
{
    /**
     * @param EntityManager $em
     * @param \Doctrine\ORM\Mapping\Entity $entity
     *
     * @throws ORMException
     *
     * @return string
     */
    public function generate(EntityManager $em, $entity)
    {
        try {
            return Uuid::uuid4()->getBytes();
        } catch (UnsatisfiedDependencyException $exception) {
            throw new ORMException('UUID generator dependency unsatisfied: %s', null, null, $exception->getMessage());
        }
    }
}

/* EOF */

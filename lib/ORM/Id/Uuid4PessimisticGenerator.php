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
use Doctrine\ORM\ORMException as DoctrineORMException;
use Ramsey\Uuid\Uuid;
use Scribe\Doctrine\Exception\ORMException;

/**
 * Class Uuid4PessimisticGenerator.
 */
abstract class Uuid4PessimisticGenerator extends Uuid4Generator
{
    /**
     * @param EntityManager                $em
     * @param \Doctrine\ORM\Mapping\Entity $entity
     *
     * @throws ORMException
     *
     * @return Uuid
     */
    public function generate(EntityManager $em, $entity)
    {
        self::setMetadata($em, $entity);

        try {

            do {
                $uuid = parent::generate($em, $entity);
            }
            while ($this->findMatchingRow($em, $uuid));

        } catch (DoctrineORMException $exception) {
            throw new ORMException('Could not generate UUID: %s', null, null, $exception->getMessage());
        }

        return $uuid;
    }

    /**
     * @param EntityManager $em
     * @param Uuid          $uuid
     *
     * @return bool
     */
    abstract protected function findMatchingRow(EntityManager $em, Uuid $uuid);
}

/* EOF */

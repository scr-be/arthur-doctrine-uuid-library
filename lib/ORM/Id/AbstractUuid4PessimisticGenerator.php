<?php

/*
 * This file is part of the `src-run/arthur-doctrine-uuid-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 * (c) Scribe Inc      <scr@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\ORM\Id;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException as DoctrineORMException;
use Ramsey\Uuid\Uuid;
use SR\Doctrine\Exception\ORMException;

/**
 * Class AbstractUuid4PessimisticGenerator.
 */
abstract class AbstractUuid4PessimisticGenerator extends AbstractUuid4Generator
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
            } while ($this->findMatchingRow($em, $uuid));
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

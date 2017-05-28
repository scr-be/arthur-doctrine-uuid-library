<?php

/*
 * This file is part of the `src-run/arthur-doctrine-uuid-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\ORM\Id;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException as DoctrineORMException;
use Ramsey\Uuid\UuidInterface;
use SR\Doctrine\Exception\OrmException;
use SR\Doctrine\Exception\Type\OrmTypeGeneratorException;

abstract class AbstractUuid4PessimisticGenerator extends AbstractUuid4Generator
{
    /**
     * @param EntityManager                $em
     * @param \Doctrine\ORM\Mapping\Entity $entity
     *
     * @throws OrmException
     *
     * @return UuidInterface
     */
    public function generate(EntityManager $em, $entity)
    {
        self::setMetadata($em, $entity);

        try {
            do {
                $uuid = parent::generate($em, $entity);
            } while ($this->findMatchingRow($em, $uuid));
        } catch (DoctrineORMException $exception) {
            throw new OrmTypeGeneratorException('Unable to generate UUID', $exception);
        }

        return $uuid;
    }

    /**
     * @param EntityManager $em
     * @param UuidInterface $uuid
     *
     * @return bool
     */
    abstract protected function findMatchingRow(EntityManager $em, UuidInterface $uuid);
}

/* EOF */

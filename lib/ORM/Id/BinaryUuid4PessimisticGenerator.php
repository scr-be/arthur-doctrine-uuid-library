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
use Ramsey\Uuid\UuidInterface;

class BinaryUuid4PessimisticGenerator extends AbstractUuid4PessimisticGenerator
{
    /**
     * @param EntityManager $em
     * @param UuidInterface $uuid
     *
     * @return object|null
     */
    protected function findMatchingRow(EntityManager $em, UuidInterface $uuid)
    {
        return $em->find(self::$metadata->getName(), ['uuid' => $uuid->getBytes()]);
    }
}

/* EOF */

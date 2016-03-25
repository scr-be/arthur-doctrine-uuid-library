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
use Ramsey\Uuid\Uuid;

/**
 * Class BinaryUuid4PessimisticGenerator.
 */
class BinaryUuid4PessimisticGenerator extends AbstractUuid4PessimisticGenerator
{
    /**
     * @param EntityManager $em
     * @param Uuid          $uuid
     *
     * @return bool
     */
    protected function findMatchingRow(EntityManager $em, Uuid $uuid)
    {
        return $em->find(self::$metadata->getName(), ['uuid' => $uuid->getBytes()]);
    }
}

/* EOF */

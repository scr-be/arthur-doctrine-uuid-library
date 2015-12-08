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
use Ramsey\Uuid\Uuid;

/**
 * Class StringUuid4PessimisticGenerator.
 */
class StringUuid4PessimisticGenerator extends Uuid4PessimisticGenerator
{
    /**
     * @param EntityManager $em
     * @param Uuid          $uuid
     *
     * @return bool
     */
    protected function findMatchingRow(EntityManager $em, Uuid $uuid)
    {
        return $em->find(self::$metadata->getName(), ['uuid' => $uuid->toString()]);
    }
}

/* EOF */

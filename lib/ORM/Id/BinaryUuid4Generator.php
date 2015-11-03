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
 * Class BinaryUuid4Generator.
 */
class BinaryUuid4Generator extends AbstractPreInsertIdGenerator
{
    /**
     * @param EntityManager                $em
     * @param \Doctrine\ORM\Mapping\Entity $entity
     *
     * @return string
     */
    public function generate(EntityManager $em, $entity)
    {
        return Uuid::uuid4()->getBytes();
    }
}

/* EOF */

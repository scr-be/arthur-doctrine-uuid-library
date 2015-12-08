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

/**
 * Trait IdGeneratorTrait.
 */
trait IdGeneratorTrait
{
    /**
     * @var \Doctrine\ORM\Mapping\ClassMetadata
     */
    protected static $metadata;

    /**
     * @param EntityManager                $em
     * @param \Doctrine\ORM\Mapping\Entity $entity
     */
    protected static function setMetadata(EntityManager $em, $entity)
    {
        static::$metadata = $em->getClassMetadata(get_class($entity));
    }
}

/* EOF */

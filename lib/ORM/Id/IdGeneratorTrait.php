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

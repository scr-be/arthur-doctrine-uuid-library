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
use Doctrine\ORM\Id\AbstractIdGenerator;
use Ramsey\Uuid\Uuid;

/**
 * Class AbstractUuid4Generator.
 */
abstract class AbstractUuid4Generator extends AbstractIdGenerator
{
    use IdGeneratorTrait;
    use IdGeneratorPreInsertTrait;

    /**
     * @param EntityManager                $em
     * @param \Doctrine\ORM\Mapping\Entity $entity
     *
     * @return Uuid
     */
    public function generate(EntityManager $em, $entity)
    {
        return Uuid::uuid4();
    }
}

/* EOF */

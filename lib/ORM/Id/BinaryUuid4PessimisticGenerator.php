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
 * Class BinaryUuid4PessimisticGenerator.
 */
class BinaryUuid4PessimisticGenerator extends Uuid4PessimisticGenerator
{
    /**
     * @param EntityManager                $em
     * @param \Doctrine\ORM\Mapping\Entity $entity
     *
     * @return string
     */
    public function generate(EntityManager $em, $entity)
    {
        return parent::generate($em, $entity)->getBytes();
    }

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

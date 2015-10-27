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
 * Class BinaryUuid4PessimisticGenerator
 *
 * @package Scribe\Doctrine\ORM\Id
 */
class BinaryUuid4PessimisticGenerator extends BinaryUuid4Generator
{
    /**
     * @param EntityManager $em
     * @param \Doctrine\ORM\Mapping\Entity $entity
     *
     * @return string
     */
    public function generate(EntityManager $em, $entity)
    {
        self::setClassMetadata($em, $entity);

        try {
            do {
                $uuid = Uuid::getFactory()->uuid5(Uuid::NAMESPACE_OID, $entityName)->getBytes();
            } while (!$em->find($entityName, ['uuid', $uuid]));
        } catch ()

        return $uuid;
    }

    /**
     * @return bool
     */
    public function isPostInsertGenerator()
    {
        return false;
    }
}
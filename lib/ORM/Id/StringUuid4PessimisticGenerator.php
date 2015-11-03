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
use Doctrine\ORM\ORMException as BaseORMException;
use Scribe\Doctrine\Exception\ORMException;

/**
 * Class StringUuid4PessimisticGenerator.
 */
class StringUuid4PessimisticGenerator extends StringUuid4Generator
{
    /**
     * @param EntityManager                $em
     * @param \Doctrine\ORM\Mapping\Entity $entity
     *
     * @throws ORMException
     *
     * @return string
     */
    public function generate(EntityManager $em, $entity)
    {
        self::setMetadata($em, $entity);

        try {
            do {
                $uuid = parent::generate($em, $entity);
            } while ($em->find(self::$metadata->getName(), ['uuid', $uuid]));
        } catch (BaseORMException $exception) {
            throw new ORMException('Could not generate UUID: %s', null, null, $exception->getMessage());
        }

        return $uuid;
    }
}

/* EOF */

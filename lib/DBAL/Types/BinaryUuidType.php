<?php

/*
 * This file is part of the Scribe Doctrine UUID Library.
 *
 * (c) Scribe Inc. <oss@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Ramsey\Uuid\Uuid;

class BinaryUuidType extends Type
{
    /**
     * @var string
     */
    const NAME = 'bin_uuid';

    /**
     * {@inheritdoc}
     *
     * @param mixed[]          $fieldDeclaration
     * @param AbstractPlatform $platform
     *
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getBinaryTypeDeclarationSQL([
            'length' => 16,
            'fixed'  => true,
        ]);
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed            $value
     * @param AbstractPlatform $platform
     *
     * @throws ConversionException
     *
     * @return mixed|null|\Ramsey\Uuid\UuidInterface
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof Uuid) {
            return $value;
        }

        try {
            return Uuid::fromBytes($value);
        } catch (\InvalidArgumentException $exception) {
            throw ConversionException::conversionFailed($value, self::NAME);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed            $value
     * @param AbstractPlatform $platform
     *
     * @throws ConversionException
     *
     * @return null|string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof Uuid) {
            return $value->getBytes();
        }

        if (Uuid::isValid($value)) {
            return Uuid::fromString($value)->getBytes();
        }

        try {
            return Uuid::fromBytes($value)->getBytes();
        } catch (\InvalidArgumentException $exception) {
            throw ConversionException::conversionFailed($value, self::NAME);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @param AbstractPlatform $platform
     *
     * @return bool
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}

/* EOF */

<?php

/*
 * This file is part of the `src-run/arthur-doctrine-uuid-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Ramsey\Uuid\Uuid;
use SR\Doctrine\Exception\Type\OrmTypeConversionException;

class StringUuidType extends Type
{
    /**
     * @var string
     */
    const NAME = 'str_uuid';

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
        return $platform->getGuidTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed            $value
     * @param AbstractPlatform $platform
     *
     * @throws OrmTypeConversionException
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
            return Uuid::fromString($value);
        } catch (\InvalidArgumentException $exception) {
            throw new OrmTypeConversionException('Unable to convert "%s" PHP value in "%s"', $value, self::NAME);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed            $value
     * @param AbstractPlatform $platform
     *
     * @throws OrmTypeConversionException
     *
     * @return null|string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof Uuid || Uuid::isValid($value)) {
            return (string) $value;
        }

        throw new OrmTypeConversionException('Unable to convert "%s" database value in "%s"', $value, self::NAME);
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

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

namespace SR\Doctrine\DBAL\Types;

use Doctrine\DBAL\Types\ConversionException as BaseConversionException;
use SR\Doctrine\Exception\ORMExceptionInterface;
use SR\Wonka\Exception\ExceptionTrait;

/**
 * Class ConversionException.
 */
class ConversionException extends BaseConversionException implements ORMExceptionInterface
{
    use ExceptionTrait;

    const MSG_ORM_TYPE_CONVERSION = 'Error during type conversion.';

    /**
     * @return string
     */
    public function getDefaultMessage()
    {
        return self::MSG_ORM_TYPE_CONVERSION;
    }

    /**
     * @return int
     */
    public function getDefaultCode()
    {
        return self::CODE_ORM_GENERIC;
    }
}

/* EOF */

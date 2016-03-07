<?php

/*
 * This file is part of the Arthur Doctrine Library.
 *
 * (c) Scribe Inc. <oss@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\DBAL\Types;

use Doctrine\DBAL\Types\ConversionException as BaseConversionException;
use Scribe\Doctrine\Exception\ORMExceptionInterface;
use Scribe\Wonka\Exception\ExceptionTrait;

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

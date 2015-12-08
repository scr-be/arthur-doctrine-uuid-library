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

/**
 * Trait IdGeneratorPreInsertTrait.
 */
trait IdGeneratorPreInsertTrait
{
    /**
     * @return bool
     */
    public function isPostInsertGenerator()
    {
        return false;
    }
}

/* EOF */

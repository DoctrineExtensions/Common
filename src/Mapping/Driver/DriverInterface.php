<?php

/*
 * This file is part of the arodax/doctrine-extensions-common package.
 *
 * (c) ARODAX  <info@arodax.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Arodax\Doctrine\Extensions\Common\Mapping\Driver;

/**
 * The mapping driver abstract class, defines the
 * metadata extraction function common among
 * all drivers used on these extensions.
 */
interface DriverInterface
{
    /**
     * Read extended metadata configuration for
     * a single mapped class
     *
     * @param object $meta
     * @param array  $config
     *
     * @return void
     */
    public function readExtendedMetadata($meta, array &$config);

    /**
     * Passes in the original driver
     *
     * @param object $driver
     *
     * @return void
     */
    public function setOriginalDriver($driver);
}

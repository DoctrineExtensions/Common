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

namespace DoctrineExtensions\Common\Mapping\Driver;

/**
 * The chain mapping driver enables chained
 * extension mapping driver support
 *
 * @author Gediminas Morkevicius <gediminas.morkevicius@gmail.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class ChainMapping implements DriverInterface
{
    /**
     * The default driver
     *
     * @var DriverInterface|null
     */
    private $defaultDriver;

    /**
     * List of drivers nested
     * @var DriverInterface[]
     */
    private $_drivers = array();

    /**
     * Add a nested driver.
     *
     * @param DriverInterface $nestedDriver
     * @param string $namespace
     */
    public function addDriver(DriverInterface $nestedDriver, $namespace)
    {
        $this->_drivers[$namespace] = $nestedDriver;
    }

    /**
     * Get the array of nested drivers.
     *
     * @return DriverInterface[] $drivers
     */
    public function getDrivers()
    {
        return $this->_drivers;
    }

    /**
     * Get the default driver.
     *
     * @return DriverInterface|null
     */
    public function getDefaultDriver()
    {
        return $this->defaultDriver;
    }

    /**
     * Set the default driver.
     *
     * @param DriverInterface $driver
     */
    public function setDefaultDriver(DriverInterface $driver)
    {
        $this->defaultDriver = $driver;
    }

    /**
     * {@inheritDoc}
     */
    public function readExtendedMetadata($meta, array &$config)
    {
        foreach ($this->_drivers as $namespace => $driver) {
            if (strpos($meta->name, $namespace) === 0) {
                $driver->readExtendedMetadata($meta, $config);

                return;
            }
        }

        if (null !== $this->defaultDriver) {
            $this->defaultDriver->readExtendedMetadata($meta, $config);

            return;
        }
    }

    /**
     * Passes in the mapping read by original driver
     *
     * @param $driver
     * @return void
     */
    public function setOriginalDriver($driver)
    {
        //not needed here
    }
}

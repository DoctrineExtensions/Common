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

use Doctrine\Common\Persistence\Mapping\Driver\FileDriver;
use Doctrine\Common\Persistence\Mapping\Driver\FileLocator;

/**
 * The mapping FileDriver abstract class, defines the
 * metadata extraction function common among
 * all drivers used on these extensions by file based
 * drivers.
 *
 * @author Gediminas Morkevicius <gediminas.morkevicius@gmail.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
abstract class AbstractFile implements DriverInterface
{
    use RelatedClassNameTrait;

    /**
     * @var FileLocator
     */
    protected $locator;

    /**
     * AbstractFile extension, must be set in child class
     * @var string
     */
    protected $_extension;

    /**
     * original driver if it is available
     */
    protected $_originalDriver = null;

    public function setLocator(FileLocator $locator)
    {
        $this->locator = $locator;
    }

    /**
     * Set the paths for file lookup
     *
     * @param array $paths
     *
     * @return void
     */
    public function setPaths($paths)
    {
        $this->_paths = (array) $paths;
    }

    /**
     * Set the file extension
     *
     * @param string $extension
     *
     * @return void
     */
    public function setExtension($extension)
    {
        $this->_extension = $extension;
    }

    /**
     * Loads a mapping file with the given name and returns a map
     * from class/entity names to their corresponding elements.
     *
     * @param string $file The mapping file to load.
     *
     * @return array
     */
    abstract protected function _loadMappingFile($file);

    /**
     * Tries to get a mapping for a given class
     *
     * @param string $className
     *
     * @return null|array|object
     *
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     */
    protected function _getMapping($className)
    {
        //try loading mapping from original driver first
        $mapping = null;
        if (!is_null($this->_originalDriver)) {
            if ($this->_originalDriver instanceof FileDriver) {
                $mapping = $this->_originalDriver->getElement($className);
            }
        }

        //if no mapping found try to load mapping file again
        if (is_null($mapping)) {
            $yaml = $this->_loadMappingFile($this->locator->findMappingFile($className));
            $mapping = $yaml[$className];
        }

        return $mapping;
    }

    /**
     * Passes in the mapping read by original driver
     *
     * @param object $driver
     *
     * @return void
     */
    public function setOriginalDriver($driver)
    {
        $this->_originalDriver = $driver;
    }
}

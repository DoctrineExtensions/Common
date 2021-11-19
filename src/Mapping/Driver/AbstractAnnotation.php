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

use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Arodax\Doctrine\Extensions\Common\Exception\InvalidMappingException;

/**
 * @deprecated Use Arodax\Doctrine\Extensions\Tree\Mapping\Driver\AbstractAnnotation
 * from arodax/doctrine-extensions-tree package. This package will be no longer needed since v4.0.0 version.
 *
 * This is an abstract class to implement common functionality
 * for extension annotation mapping drivers.
 *
 * @author     Derek J. Lambert <dlambert@dereklambert.com>
 * @author     Daniel Chodusov <daniel@chodusov.com>
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
abstract class AbstractAnnotation implements AnnotationInterface
{
    use RelatedClassNameTrait;

    /**
     * Annotation reader instance
     *
     * @var object
     */
    protected $reader;

    /**
     * Original driver if it is available
     */
    protected $_originalDriver = null;

    /**
     * List of types which are valid for extension
     *
     * @var array
     */
    protected $validTypes = array();

    /**
     * {@inheritDoc}
     */
    public function setAnnotationReader($reader)
    {
        $this->reader = $reader;
    }

    /**
     * Passes in the mapping read by original driver
     *
     * @param object $driver
     */
    public function setOriginalDriver($driver)
    {
        $this->_originalDriver = $driver;
    }

    /**
     * @param object $meta
     *
     * @return \ReflectionClass
     *
     * @throws \ReflectionException
     */
    public function getMetaReflectionClass($meta): \ReflectionClass
    {
        $class = $meta->getReflectionClass();
        if (!$class) {
            // based on recent doctrine 2.3.0-DEV maybe will be fixed in some way
            // this happens when running annotation driver in combination with
            // static reflection services. This is not the nicest fix
            $class = new \ReflectionClass($meta->name);
        }

        return $class;
    }

    /**
     * Checks if $field type is valid
     *
     * @param ClassMetadataInfo $meta
     * @param string $field
     *
     * @return boolean Whether field is valid or not.
     *
     * @throws InvalidMappingException if mapping type is not declared.
     * @throws \Doctrine\ORM\Mapping\MappingException
     */
    protected function isValidField(ClassMetadataInfo $meta, $field): bool
    {
        $mapping = $meta->getFieldMapping($field);

        if (!isset($mapping['type'])) {
            throw new InvalidMappingException('Missing mapping type');
        }

        return $mapping && in_array($mapping['type'], $this->validTypes);
    }
}

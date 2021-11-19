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

use Doctrine\Persistence\Mapping\ClassMetadata;

/**
 * @deprecated Use Arodax\Doctrine\Extensions\Tree\Mapping\Driver\RelatedClassNameTrait
 * from arodax/doctrine-extensions-tree package. This package will be no longer needed since v4.0.0 version.
 *
 * Provides getRelatedClassName() method for abstract driver classes
 *
 * @author Gediminas Morkevicius <gediminas.morkevicius@gmail.com>
 * @author Daniel Chodusov <daniel@chodusov.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
trait RelatedClassNameTrait
{
    /**
     * Try to find out related class name out of mapping
     *
     * @param ClassMetadata $metadata The mapped class metadata
     * @param string $name The related object class name.
     *
     * @return string related class name or empty string if class does not exist.
     */
    protected function getRelatedClassName(ClassMetadata $metadata, string $name): string
    {
        if (class_exists($name) || interface_exists($name)) {
            return $name;
        }

        $reflectionClass    = $metadata->getReflectionClass();
        $namespace          = $reflectionClass->getNamespaceName();
        $className          = $namespace . '\\' . $name;

        return class_exists($className) ? $className : '';
    }
}

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
 * Annotation driver interface, provides method
 * to set custom annotation reader.
 *
 * @author Gediminas Morkevicius <gediminas.morkevicius@gmail.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
interface AnnotationInterface extends DriverInterface
{
    /**
     * Set annotation reader class
     * since older doctrine versions do not provide an interface
     * it must provide these methods:
     *     getClassAnnotations([reflectionClass])
     *     getClassAnnotation([reflectionClass], [name])
     *     getPropertyAnnotations([reflectionProperty])
     *     getPropertyAnnotation([reflectionProperty], [name])
     *
     * @param object $reader - annotation reader class
     */
    public function setAnnotationReader($reader);
}

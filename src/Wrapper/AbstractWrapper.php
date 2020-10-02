<?php

/*
 * This file is part of the arodax/doctrine-extensions-common package.
 *
 * (c) ARODAX  <info@arodax.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Arodax\Doctrine\Extensions\Common\Wrapper;

use Arodax\Doctrine\Extensions\Common\Exception\UnsupportedObjectManagerException;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\EntityManagerInterface;



/**
 * Wraps entity or proxy for more convenient
 * manipulation
 *
 * @author Gediminas Morkevicius <gediminas.morkevicius@gmail.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
abstract class AbstractWrapper implements WrapperInterface
{
    /**
     * Object metadata
     *
     * @var object
     */
    protected $meta;

    /**
     * Wrapped object
     *
     * @var object
     */
    protected $object;

    /**
     * Object manager instance
     *
     * @var \Doctrine\Persistence\ObjectManager
     */
    protected $om;

    /**
     * List of wrapped object references
     *
     * @var array
     */
    private static $wrappedObjectReferences;

    /**
     * Wrap object factory method
     *
     * @param object $object
     * @param ObjectManager $om
     *
     * @return WrapperInterface
     *
     * @throws UnsupportedObjectManagerException
     */
    public static function wrap($object, ObjectManager $om): WrapperInterface
    {
        if ($om instanceof EntityManagerInterface) {
            return new EntityWrapper($object, $om);
        } elseif ($om instanceof DocumentManager) {
            return new DocumentWrapper($object, $om);
        }

        throw new UnsupportedObjectManagerException('Given object manager is not managed by wrapper');
    }


    /**
     * @return void
     */
    public static function clear(): void
    {
        self::$wrappedObjectReferences = array();
    }

    /**
     * {@inheritDoc}
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * {@inheritDoc}
     */
    public function getMetadata()
    {
        return $this->meta;
    }

    /**
     * {@inheritDoc}
     */
    public function populate(array $data)
    {
        foreach ($data as $field => $value) {
            $this->setPropertyValue($field, $value);
        }

        return $this;
    }
}

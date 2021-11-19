<?php

/*
 * This file is part of the arodax/doctrine-extensions-common package.
 *
 * (c) ARODAX  <info@arodax.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Arodax\Doctrine\Extensions\Common\Mapping\Event\Adapter;

use Arodax\Doctrine\Extensions\Common\Mapping\Event\AdapterInterface;
use Arodax\Doctrine\Extensions\Common\Exception\RuntimeException;
use Doctrine\Common\EventArgs;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;

/**
 * @deprecated Use Arodax\Doctrine\Extensions\Tree\Mapping\Event\Adapter\ODM
 * from arodax/doctrine-extensions-tree package. This package will be no longer needed since v4.0.0 version.
 *
 * Doctrine event adapter for ODM specific
 * event arguments
 *
 * @author Gediminas Morkevicius <gediminas.morkevicius@gmail.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class ODM implements AdapterInterface
{
    /**
     * @var \Doctrine\Common\EventArgs
     */
    private $args;

    /**
     * @var \Doctrine\ODM\MongoDB\DocumentManager
     */
    private $dm;

    /**
     * {@inheritdoc}
     */
    public function setEventArgs(EventArgs $args)
    {
        $this->args = $args;
    }

    /**
     * {@inheritdoc}
     */
    public function getDomainObjectName()
    {
        return 'Document';
    }

    /**
     * {@inheritdoc}
     */
    public function getManagerName()
    {
        return 'ODM';
    }

    /**
     * {@inheritdoc}
     */
    public function getRootObjectClass($meta)
    {
        return $meta->rootDocumentName;
    }

    /**
     * Set the document manager
     *
     * @param \Doctrine\ODM\MongoDB\DocumentManager $dm
     */
    public function setDocumentManager(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    /**
     * {@inheritdoc}
     */
    public function getObjectManager()
    {
        if (!is_null($this->dm)) {
            return $this->dm;
        }

        return $this->__call('getDocumentManager', array());
    }

    /**
     * {@inheritdoc}
     */
    public function getObjectState($uow, $object)
    {
        return $uow->getDocumentState($object);
    }

    /**
     * {@inheritdoc}
     */
    public function __call($method, $args)
    {
        if (is_null($this->args)) {
            throw new RuntimeException("Event args must be set before calling its methods");
        }
        $method = str_replace('Object', $this->getDomainObjectName(), $method);

        return call_user_func_array(array($this->args, $method), $args);
    }

    /**
     * {@inheritdoc}
     */
    public function getObjectChangeSet($uow, $object)
    {
        return $uow->getDocumentChangeSet($object);
    }

    /**
     * {@inheritdoc}
     */
    public function getSingleIdentifierFieldName($meta)
    {
        return $meta->identifier;
    }

    /**
     * {@inheritdoc}
     */
    public function recomputeSingleObjectChangeSet($uow, $meta, $object)
    {
        $uow->recomputeSingleDocumentChangeSet($meta, $object);
    }

    /**
     * {@inheritdoc}
     */
    public function getScheduledObjectUpdates($uow)
    {
        $updates = $uow->getScheduledDocumentUpdates();
        $upserts = $uow->getScheduledDocumentUpserts();

        return array_merge($updates, $upserts);
    }

    /**
     * {@inheritdoc}
     */
    public function getScheduledObjectInsertions($uow)
    {
        return $uow->getScheduledDocumentInsertions();
    }

    /**
     * {@inheritdoc}
     */
    public function getScheduledObjectDeletions($uow)
    {
        return $uow->getScheduledDocumentDeletions();
    }

    /**
     * {@inheritdoc}
     */
    public function setOriginalObjectProperty($uow, $oid, $property, $value)
    {
        $uow->setOriginalDocumentProperty($oid, $property, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function clearObjectChangeSet($uow, $oid)
    {
        $uow->clearDocumentChangeSet($oid);
    }

    /**
     * Creates a ODM specific LifecycleEventArgs.
     *
     * @param object                                $document
     * @param \Doctrine\ODM\MongoDB\DocumentManager $documentManager
     *
     * @return \Doctrine\ODM\MongoDB\Event\LifecycleEventArgs
     */
    public function createLifecycleEventArgsInstance($document, $documentManager)
    {
        return new LifecycleEventArgs($document, $documentManager);
    }
}

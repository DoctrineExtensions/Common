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

namespace Arodax\Doctrine\Extensions\Common\Exception;

/**
 * @deprecated Use Arodax\Doctrine\Extensions\Tree\Exception\UnsupportedObjectManagerException
 * from arodax/doctrine-extensions-tree package. This package will be no longer needed since v4.0.0 version.
 *
 * Exception thrown if an error which can only be found on runtime occurs.
 *
 * @author Daniel Chodusov <daniel@chodusov.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class UnsupportedObjectManagerException extends \Exception implements ExceptionInterface
{
    //
}

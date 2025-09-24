<?php

/**
 * Laravel Tron API Package - Not Found Exception
 *
 * A PHP API for interacting with Tron (TRX) blockchain with Laravel integration
 * Based on the original iexbase/tron-api package
 *
 * @author  Jackillll <jackjack75383973@gmail.com>
 * @author  Shamsudin Serderov <steein.shamsudin@gmail.com> (Original Author)
 * @license https://github.com/jackillll/tron/blob/master/LICENSE (MIT License)
 * @version 2.0.0
 * @link    https://github.com/jackillll/tron
 * @package Jackillll\Tron\Exception
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jackillll\Tron\Exception;

use InvalidArgumentException;

/**
 * Not Found Exception
 *
 * Exception class for resource not found errors in TRON operations.
 * This exception is thrown when:
 * - Requested addresses are not found on the blockchain
 * - Transaction IDs do not exist
 * - Block numbers or hashes are invalid
 * - Smart contracts are not deployed at specified addresses
 * - API endpoints return 404 errors
 *
 * @package Jackillll\Tron\Exception
 * @author  Jackillll <jackjack75383973@gmail.com>
 * @since   2.0.0
 */
class NotFoundException extends InvalidArgumentException
{
    //
}

<?php

/**
 * Laravel Tron API Package - TRC20 Exception
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

/**
 * TRC20 Exception
 *
 * Exception class specifically for TRC20 token-related errors.
 * This exception is thrown when:
 * - TRC20 contract interactions fail
 * - Invalid token addresses are provided
 * - Token transfer operations encounter errors
 * - Smart contract method calls fail
 * - Token balance queries return errors
 *
 * @package Jackillll\Tron\Exception
 * @author  Jackillll <jackjack75383973@gmail.com>
 * @since   2.0.0
 */
class TRC20Exception extends TronException
{
}

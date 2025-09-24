<?php

/**
 * Laravel Tron API Package - Tron Exception
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
 * Tron Exception
 *
 * Base exception class for all Tron-related errors.
 * This exception is thrown when:
 * - API requests fail or return errors
 * - Invalid parameters are provided
 * - Network connectivity issues occur
 * - Blockchain-specific errors happen
 *
 * @package Jackillll\Tron\Exception
 * @author  Jackillll <jackjack75383973@gmail.com>
 * @since   2.0.0
 */
class TronException extends \Exception
{
    //
}

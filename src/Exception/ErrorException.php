<?php

/**
 * Laravel Tron API Package - Error Exception
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
 * Error Exception
 *
 * Exception class for general error conditions in TRON operations.
 * This exception is thrown when:
 * - General runtime errors occur
 * - Invalid data formats are encountered
 * - System-level errors happen during processing
 * - Unexpected conditions arise during execution
 *
 * @package Jackillll\Tron\Exception
 * @author  Jackillll <jackjack75383973@gmail.com>
 * @since   2.0.0
 */
class ErrorException extends \ErrorException
{

}

<?php

/**
 * Laravel Tron API Package - Manages Tronscan
 *
 * A PHP API for interacting with Tron (TRX) blockchain with Laravel integration
 * Based on the original iexbase/tron-api package
 *
 * @author  Jackillll <jackjack75383973@gmail.com>
 * @author  Shamsudin Serderov <steein.shamsudin@gmail.com> (Original Author)
 * @license https://github.com/jackillll/tron/blob/master/LICENSE (MIT License)
 * @version 2.0.0
 * @link    https://github.com/jackillll/tron
 * @package Jackillll\Tron\Concerns
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jackillll\Tron\Concerns;

use Jackillll\Tron\Exception\TronException;

/**
 * Manages Tronscan
 *
 * Trait for managing Tronscan explorer API interactions.
 * Provides functionality for:
 * - Transaction queries through Tronscan explorer
 * - Address-based transaction history retrieval
 * - Explorer API parameter validation
 *
 * @package Jackillll\Tron\Concerns
 * @author  Jackillll <jackjack75383973@gmail.com>
 * @since   2.0.0
 */
trait ManagesTronscan
{
    /**
     * Transactions from explorer
     *
     * @param array $options
     * @return array
     * @throws TronException
     */
    public function getTransactionByAddress($options = [])
    {
        if(empty($options)) {
            throw new TronException('Parameters must not be empty.');
        }

        return $this->manager->request('api/transaction', $options);
    }
}

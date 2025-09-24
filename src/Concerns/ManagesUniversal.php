<?php

/**
 * Laravel Tron API Package - Manages Universal
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

use Jackillll\Tron\Exception\ErrorException;

/**
 * Manages Universal
 *
 * Trait for managing universal TRON operations.
 * Provides functionality for:
 * - Batch balance queries for multiple accounts
 * - One-to-many transaction operations
 * - Universal account management utilities
 * - Bulk operations optimization
 *
 * @package Jackillll\Tron\Concerns
 * @author  Jackillll <jackjack75383973@gmail.com>
 * @since   2.0.0
 */
trait ManagesUniversal
{
    /**
     * Default Attributes
     *
     * @var array
    */
    private $attribute = [
        'balances'  =>  [],
        'one_to_many' => []
    ];

    /**
     * Check multiple balances
     *
     * @param array $accounts
     * @param bool $isValid
     * @return array
     * @throws ErrorException
     */
    public function balances(array $accounts, $isValid = false): array
    {
        if(!is_array($accounts)) {
            throw new ErrorException('Data must be an array');
        }

        if(count($accounts) > 20) {
            throw new ErrorException('Once you can check 20 accounts');
        }

        foreach ($accounts as $item)
        {
            if($isValid && $this->validateAddress($item[0])['result'] == false) {
                throw new ErrorException($item[0].' invalid address');
            }

            array_push($this->attribute['balances'], [
                'address'   =>  $item[0],
                'balance'   =>  $this->getBalance($item[0], $item[1])
            ]);
        }

        return $this->attribute['balances'];
    }

    /**
     * We send funds to several addresses at once.
     *
     * @param string $from
     * @param array $to
     * @param null $private_key
     * @param bool $isValid
     * @return array
     * @throws ErrorException
     */
    public function sendOneToMany(array $to, $private_key = null, bool $isValid = false, string $from = null): array
    {
        if(!is_null($private_key)) {
            $this->privateKey = $private_key;
        }

        if(count($to) > 10) {
            throw new ErrorException('Allowed to send to "10" accounts');
        }

        foreach ($to as $item)
        {
            if($isValid && $this->validateAddress($item[0])['result'] == false) {
                throw new ErrorException($item[0].' invalid address');
            }

            array_push($this->attribute['one_to_many'],
                $this->send($item[0], $item[1], $from)
            );
        }

        return $this->attribute['one_to_many'];
    }
}

<?php declare(strict_types=1);

/**
 * Laravel Tron Package
 *
 * A comprehensive Laravel package for interacting with the TRON blockchain.
 * Provides easy-to-use methods for account management, transactions, smart contracts,
 * and blockchain data retrieval.
 *
 * @package   Jackillll\Tron
 * @author    Jackillll <jackjack75383973@gmail.com>
 * @author    Shamsudin Serderov <steein.shamsudin@gmail.com> (Original Author)
 * @license   MIT
 * @version   2.0.0
 * @link      https://github.com/jackillll/laravel-tron
 * @package   Jackillll\Tron
 */

namespace Jackillll\Tron;

use Jackillll\Tron\Exception\TronException;

/**
 * Tron Interface
 *
 * Defines the contract for TRON blockchain interaction functionality.
 * This interface establishes the standard methods that must be implemented
 * by any TRON API client, ensuring consistent behavior across different
 * implementations.
 *
 * Key functionalities defined:
 * - Account and address management
 * - Transaction creation and broadcasting
 * - Balance and blockchain data queries
 * - Block information retrieval
 * - Address validation and generation
 * - Account registration and management
 * - Super representative operations
 *
 * @package Jackillll\Tron
 * @author  Jackillll <jackjack75383973@gmail.com>
 * @since   2.0.0
 */
interface TronInterface
{
    /**
     * Enter the link to the manager nodes
     *
     * @param $providers
     */
    public function setManager($providers);

    /**
     * Enter your private account key
     *
     * @param string $privateKey
     */
    public function setPrivateKey(string $privateKey): void;

    /**
     * Enter your account address
     *
     * @param string $address
     */
    public function setAddress(string $address) : void;

    /**
     * Getting a balance
     *
     * @param string $address
     * @return array
     */
    public function getBalance(string $address = null);

    /**
     * Query transaction based on id
     *
     * @param $transactionID
     * @return array
     */
    public function getTransaction(string $transactionID);

    /**
     * Count all transactions on the network
     *
     * @return integer
     */
    public function getTransactionCount();

    /**
     * Send transaction to Blockchain
     *
     * @param $to
     * @param $amount
     * @param $from
     *
     * @return array
     * @throws TronException
     */
    public function sendTransaction(string $to, float $amount, string $from = null);

    /**
     * Modify account name
     * Note: Username is allowed to edit only once.
     *
     * @param $address
     * @param $account_name
     * @return array
     */
    public function changeAccountName(string $address = null, string $account_name);

    /**
     * Create an account.
     * Uses an already activated account to create a new account
     *
     * @param $address
     * @param $newAccountAddress
     * @return array
     */
    public function registerAccount(string $address, string $newAccountAddress);

    /**
     * Apply to become a super representative
     *
     * @param string $address
     * @param string $url
     * @return array
     */
    public function applyForSuperRepresentative(string $address, string $url);


    /**
     * Get block details using HashString or blockNumber
     *
     * @param null $block
     * @return array
     */
    public function getBlock($block = null);

    /**
     * Query the latest blocks
     *
     * @param int $limit
     * @return array
     */
    public function getLatestBlocks(int $limit = 1);

    /**
     * Validate Address
     *
     * @param string $address
     * @param bool $hex
     * @return array
     */
    public function validateAddress(string $address, bool $hex = false);

    /**
     * Generate new address
     *
     * @return array
     */
    public function generateAddress();

    /**
     * Check the address before converting to Hex
     *
     * @param $sHexAddress
     * @return string
     */
    public function address2HexString($sHexAddress);
}

<?php declare(strict_types=1);

/**
 * Laravel Tron API Package - Tron Facade
 *
 * A PHP API for interacting with Tron (TRX) blockchain with Laravel integration
 * Based on the original iexbase/tron-api package
 *
 * @author  Jackillll <jackjack75383973@gmail.com>
 * @author  Shamsudin Serderov <steein.shamsudin@gmail.com> (Original Author)
 * @license https://github.com/jackillll/tron/blob/master/LICENSE (MIT License)
 * @version 2.0.0
 * @link    https://github.com/jackillll/tron
 * @package Jackillll\Tron\Facades
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jackillll\Tron\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Tron Facade
 *
 * Laravel facade for the Tron API client, providing static access to all
 * Tron blockchain functionality including account management, transaction
 * handling, smart contract interaction, and blockchain data queries.
 *
 * Account Management:
 * @method static \Jackillll\Tron\Tron setAddress(string $address) Set the default address for operations
 * @method static \Jackillll\Tron\Tron setPrivateKey(string $privateKey) Set the private key for signing transactions
 * @method static array getAccount(string $address = null) Get account information
 * @method static array getBalance(string $address = null, bool $fromTron = false) Get account balance
 * @method static array getBandwidth(string $address = null) Get account bandwidth information
 * @method static array getAccountNet(string $address = null) Get account network information
 * @method static array getAccountResource(string $address = null) Get account resource information
 *
 * Transaction Management:
 * @method static \Jackillll\Tron\TransactionBuilder getTransactionBuilder() Get transaction builder instance
 * @method static array sendTransaction(array $signedTransaction) Send a signed transaction
 * @method static array signTransaction(array $transaction) Sign a transaction
 * @method static array getTransactionInfo(string $txID) Get transaction information by ID
 * @method static array getTransaction(string $txID) Get transaction details by ID
 *
 * Smart Contract Interaction:
 * @method static \Jackillll\Tron\TRC20Contract contract(string $contractAddress = null) Get TRC20 contract instance
 *
 * Blockchain Data:
 * @method static array getBlock(int $block = null) Get block information
 * @method static array getBlockByHash(string $blockHash) Get block by hash
 * @method static array getNowBlock() Get current block
 * @method static array getNodeInfo() Get node information
 * @method static array getChainParameters() Get chain parameters
 *
 * Asset Management:
 * @method static array getAssetIssueById(string $assetId) Get asset issue by ID
 * @method static array getAssetIssueByName(string $assetName) Get asset issue by name
 * @method static array getAssetIssueListByName(string $assetName) Get asset issue list by name
 * @method static array listAssetIssue() List all asset issues
 *
 * Exchange Operations:
 * @method static array getExchangeById(int $exchangeId) Get exchange by ID
 * @method static array listExchanges() List all exchanges
 *
 * Governance:
 * @method static array getProposal(int $proposalId) Get proposal by ID
 * @method static array listProposals() List all proposals
 *
 * Resource Delegation:
 * @method static array getDelegatedResource(string $fromAddress, string $toAddress) Get delegated resource
 * @method static array getDelegatedResourceAccountIndex(string $address) Get delegated resource account index
 * @method static array getCanDelegatedMaxSize(string $address, int $type) Get maximum delegatable size
 * @method static array getAvailableUnfreezeCount(string $address) Get available unfreeze count
 * @method static array getCanWithdrawUnfreezeAmount(string $address, int $timestamp) Get withdrawable unfreeze amount
 *
 * Staking & Rewards:
 * @method static array getBrokerageInfo(string $address) Get brokerage information
 * @method static array getRewardInfo(string $address) Get reward information
 *
 * Utility Functions:
 * @method static string address2HexString(string $address) Convert address to hex string
 * @method static string hexString2Address(string $hexString) Convert hex string to address
 * @method static string hexString2Utf8(string $hex) Convert hex string to UTF-8
 * @method static string stringUtf8toHex(string $str) Convert UTF-8 string to hex
 * @method static bool isAddress(string $address) Validate Tron address format
 * @method static bool isConnected() Check if connected to Tron network
 *
 * @package Jackillll\Tron\Facades
 * @author  Jackillll <jackjack75383973@gmail.com>
 * @since   2.0.0
 * @see     \Jackillll\Tron\Tron
 */
class Tron extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'tron';
    }
}

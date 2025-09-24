<?php

declare(strict_types=1);

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

use Jackillll\Tron\Provider\HttpProvider;
use Jackillll\Tron\Exception\TronException;

/**
 * Tron Configuration Helper
 *
 * Provides simplified configuration and instantiation methods for the Tron client.
 * This utility class offers convenient factory methods to create Tron instances
 * with predefined network configurations, reducing boilerplate code and improving
 * developer experience.
 *
 * Key features:
 * - Predefined network configurations (mainnet, testnet, nile)
 * - Factory methods for quick Tron instance creation
 * - Support for Solidity and Full node selection
 * - Custom configuration support
 * - Network information retrieval
 * - Simplified API for common use cases
 *
 * @package Jackillll\Tron
 * @author  Jackillll <jackjack75383973@gmail.com>
 * @since   2.0.0
 */
class TronConfig
{
    /**
     * Default networks configuration
     *
     * @var array
     */
    protected static array $defaultNetworks = [
        'mainnet' => [
            'host' => 'https://api.trongrid.io',
            'explorer' => 'https://tronscan.org',
        ],
        'testnet' => [
            'host' => 'https://api.shasta.trongrid.io',
            'explorer' => 'https://shasta.tronscan.org',
        ],
        'nile' => [
            'host' => 'https://nile.trongrid.io',
            'explorer' => 'https://nile.tronscan.org',
        ],
    ];

    /**
     * Create Tron instance from configuration
     *
     * @param array $config
     * @return Tron
     * @throws TronException
     */
    public static function createFromConfig(array $config): Tron
    {
        // Get network configuration
        $network = $config['network'] ?? 'mainnet';
        $networks = array_merge(self::$defaultNetworks, $config['networks'] ?? []);
        
        // Validate network exists
        if (!isset($networks[$network])) {
            throw new TronException("Network '{$network}' is not configured");
        }
        
        // Get host from networks configuration
        $host = $networks[$network]['host'];
        
        $timeout = $config['timeout'] ?? 30000;
        $headers = $config['headers'] ?? [];
        $useSolidity = $config['use_solidity'] ?? false;
        
        // Create providers based on useSolidity setting
        if ($useSolidity) {
            // When useSolidity is true, create solidityNode with 'solidity' nodeType
            $solidityProvider = new HttpProvider([
                'host' => $host,
                'timeout' => $timeout,
                'headers' => $headers,
                'nodeType' => 'solidity'
            ]);
            
            return new Tron(null, $solidityProvider);
        } else {
            // When useSolidity is false, create fullNode with 'fullnode' nodeType
            $fullNodeProvider = new HttpProvider([
                'host' => $host,
                'timeout' => $timeout,
                'headers' => $headers,
                'nodeType' => 'fullnode'
            ]);
            
            return new Tron($fullNodeProvider);
        }
    }

    /**
     * Create Tron instance with specific network and solidity setting
     *
     * @param string $network
     * @param bool $useSolidity
     * @param array $headers
     * @param int $timeout
     * @return Tron
     * @throws TronException
     */
    public static function create(
        string $network = 'mainnet', 
        bool $useSolidity = false, 
        array $headers = [], 
        int $timeout = 30000
    ): Tron {
        $config = [
            'network' => $network,
            'use_solidity' => $useSolidity,
            'headers' => $headers,
            'timeout' => $timeout,
            'networks' => self::$defaultNetworks,
        ];

        return self::createFromConfig($config);
    }

    /**
     * Get available networks
     *
     * @return array
     */
    public static function getAvailableNetworks(): array
    {
        return array_keys(self::$defaultNetworks);
    }

    /**
     * Get all networks configuration
     *
     * @return array
     */
    public static function getNetworks(): array
    {
        return self::$defaultNetworks;
    }

    /**
     * Get network host URL
     *
     * @param string $network
     * @return string
     * @throws TronException
     */
    public static function getNetworkHost(string $network): string
    {
        if (!isset(self::$defaultNetworks[$network])) {
            throw new TronException("Network '{$network}' is not available");
        }

        return self::$defaultNetworks[$network]['host'];
    }

    /**
     * Get network explorer URL
     *
     * @param string $network
     * @return string
     * @throws TronException
     */
    public static function getNetworkExplorer(string $network): string
    {
        if (!isset(self::$defaultNetworks[$network])) {
            throw new TronException("Network '{$network}' is not available");
        }

        return self::$defaultNetworks[$network]['explorer'];
    }
}

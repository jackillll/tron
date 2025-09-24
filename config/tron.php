<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Tron API Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for the Tron API client.
    | You can configure the host, timeout, and other settings here.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Tron Network
    |--------------------------------------------------------------------------
    |
    | The network to use for Tron API requests. This should be one of the
    | keys defined in the 'networks' section below.
    |
    | Available networks: mainnet, testnet, nile
    |
    */
    'network' => env('TRON_NETWORK', 'mainnet'),

    /*
    |--------------------------------------------------------------------------
    | Request Timeout
    |--------------------------------------------------------------------------
    |
    | The timeout for HTTP requests in milliseconds.
    |
    */
    'timeout' => env('TRON_TIMEOUT', 30000),

    /*
    |--------------------------------------------------------------------------
    | Use Solidity Node
    |--------------------------------------------------------------------------
    |
    | Whether to use the Solidity node for API requests.
    | 
    | - true: Use Solidity node for confirmed historical data and smart contract calls
    | - false: Use Full node for real-time data and transaction broadcasting
    |
    */
    'use_solidity' => env('TRON_USE_SOLIDITY', false),

    /*
    |--------------------------------------------------------------------------
    | Custom Headers
    |--------------------------------------------------------------------------
    |
    | Any custom headers you want to include with requests.
    | For TronGrid, you might want to include an API key.
    |
    */
    'headers' => [
        'TRON-PRO-API-KEY' => env('TRON_API_KEY', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Private Key
    |--------------------------------------------------------------------------
    |
    | The default private key to use for signing transactions.
    | This should be kept secure and not committed to version control.
    |
    */
    'private_key' => env('TRON_PRIVATE_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Default Address
    |--------------------------------------------------------------------------
    |
    | The default address to use for operations.
    |
    */
    'address' => env('TRON_ADDRESS', ''),

    /*
    |--------------------------------------------------------------------------
    | Network Settings
    |--------------------------------------------------------------------------
    |
    | Network-specific settings.
    |
    */
    'networks' => [
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
    ],
];

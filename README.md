# TRON API
A PHP API for interacting with the Tron Protocol

**Based on [iexbase/tron-api](https://github.com/iexbase/tron-api)**

[![Latest Stable Version](https://poser.pugx.org/jackillll/tron/version)](https://packagist.org/packages/jackillll/tron)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

## Install

```bash
composer require jackillll/tron --ignore-platform-reqs
```

## Requirements

The following versions of PHP are supported by this version.

* PHP 7.4+

## Configuration

This package supports a new, more intuitive configuration structure:

### New Configuration Structure
```php
'network' => 'mainnet',        // Network name: mainnet, testnet, nile
'use_solidity' => false,       // Boolean: true for Solidity node, false for Full node
'networks' => [
    'mainnet' => [
        'host' => 'https://api.trongrid.io',
        'explorer' => 'https://tronscan.org'
    ],
    'testnet' => [
        'host' => 'https://api.shasta.trongrid.io', 
        'explorer' => 'https://shasta.tronscan.org'
    ],
    'nile' => [
        'host' => 'https://nile.trongrid.io',
        'explorer' => 'https://nile.tronscan.org'
    ]
]
```

## Usage

### Laravel Usage

#### 1. Installation in Laravel

```bash
composer require iexbase/tron-api --ignore-platform-reqs
```

#### 2. Publish Configuration

```bash
php artisan vendor:publish --provider="Jackillll\Tron\TronServiceProvider"
```

#### 3. Environment Configuration

Add to your `.env` file:

```env
TRON_NETWORK=mainnet
TRON_USE_SOLIDITY=false
TRON_API_KEY=your-trongrid-api-key
TRON_PRIVATE_KEY=your-private-key
TRON_ADDRESS=your-address
TRON_TIMEOUT=30000
```

#### 4. Laravel Usage Examples

**Using Dependency Injection:**
```php
<?php

namespace App\Http\Controllers;

use Jackillll\Tron\Tron;

class TronController extends Controller
{
    protected $tron;

    public function __construct(Tron $tron)
    {
        $this->tron = $tron;
    }

    public function getBalance($address)
    {
        return $this->tron->getBalance($address, true);
    }

    public function sendTrx($to, $amount)
    {
        return $this->tron->send($to, $amount);
    }
}
```

**Using Facade:**
```php
<?php

use Jackillll\Tron\Facades\Tron;

// Get account information
$account = Tron::getAccount('TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t');

// Get balance
$balance = Tron::getBalance('TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t', true);

// Send TRX
$result = Tron::send('TTo_Address_Here', 1.5);

// Get latest blocks
$blocks = Tron::getLatestBlocks(10);
```

**Service Class Example:**
```php
<?php

namespace App\Services;

use Jackillll\Tron\Tron;

class TronService
{
    protected $tron;

    public function __construct(Tron $tron)
    {
        $this->tron = $tron;
    }

    public function getUserBalance($address)
    {
        try {
            return $this->tron->getBalance($address, true);
        } catch (\Exception $e) {
            \Log::error('Tron balance error: ' . $e->getMessage());
            return 0;
        }
    }

    public function transferTrx($fromPrivateKey, $toAddress, $amount)
    {
        try {
            $this->tron->setPrivateKey($fromPrivateKey);
            return $this->tron->send($toAddress, $amount);
        } catch (\Exception $e) {
            \Log::error('Tron transfer error: ' . $e->getMessage());
            return false;
        }
    }
}
```

### Plain PHP Usage

#### 1. Using TronConfig Helper (Recommended)

```php
<?php

require_once 'vendor/autoload.php';

use Jackillll\Tron\TronConfig;

// Method 1: Simple usage with defaults
$tron = TronConfig::create(); // mainnet + fullnode

// Method 2: Specify network and node type
$tron = TronConfig::create('mainnet', true); // mainnet + solidity node
$tron = TronConfig::create('testnet', false); // testnet + fullnode

// Method 3: With custom headers
$tron = TronConfig::create('mainnet', false, [
    'TRON-PRO-API-KEY' => 'your-api-key'
], 30000);

// Method 4: Using custom configuration
$config = [
    'network' => 'mainnet',
    'use_solidity' => false,
    'timeout' => 30000,
    'headers' => [
        'TRON-PRO-API-KEY' => 'your-api-key'
    ],
    'networks' => [
        'mainnet' => [
            'host' => 'https://api.trongrid.io',
            'explorer' => 'https://tronscan.org'
        ]
    ]
];

$tron = TronConfig::createFromConfig($config);
```

#### 2. Traditional HttpProvider Usage

```php
<?php

require_once 'vendor/autoload.php';

use Jackillll\Tron\Tron;
use Jackillll\Tron\Provider\HttpProvider;

// Create providers
$fullNode = new HttpProvider('https://api.trongrid.io');
$solidityNode = new HttpProvider('https://api.trongrid.io');
$eventServer = new HttpProvider('https://api.trongrid.io');

// Create Tron instance
try {
    $tron = new Tron($fullNode, $solidityNode, $eventServer);
} catch (\Jackillll\Tron\Exception\TronException $e) {
    exit($e->getMessage());
}
```

#### 3. Complete PHP Example

```php
<?php

require_once 'vendor/autoload.php';

use Jackillll\Tron\TronConfig;

try {
    // Initialize Tron with mainnet
    $tron = TronConfig::create('mainnet', false, [
        'TRON-PRO-API-KEY' => 'your-api-key'
    ]);

    // Set private key for transactions
    $tron->setPrivateKey('your-private-key');
    $tron->setAddress('your-address');

    // Get account balance
    $balance = $tron->getBalance('TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t', true);
    echo "Balance: " . $balance . " TRX\n";

    // Get account information
    $account = $tron->getAccount('TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t');
    echo "Account Type: " . $account['type'] . "\n";

    // Send TRX (requires private key)
    // $result = $tron->send('TTo_Address_Here', 1.5);

    // Generate new address
    $newAccount = $tron->createAccount();
    echo "New Address: " . $newAccount['address'] . "\n";
    echo "Private Key: " . $newAccount['privateKey'] . "\n";

    // Get latest blocks
    $blocks = $tron->getLatestBlocks(5);
    echo "Latest block number: " . $blocks[0]['block_header']['raw_data']['number'] . "\n";

    // Work with smart contracts
    $contract = $tron->contract('TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t'); // USDT contract
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
```

## Network Configuration

### Available Networks

- **mainnet**: Tron mainnet (production)
- **testnet**: Shasta testnet (development)  
- **nile**: Nile testnet (development)

### Node Types

- **Full Node** (`use_solidity = false`): For sending transactions, getting latest data
- **Solidity Node** (`use_solidity = true`): For querying smart contracts, historical data

### Dynamic Network Switching

```php
// Different network instances
$mainnetTron = TronConfig::create('mainnet');
$testnetTron = TronConfig::create('testnet'); 
$nileTron = TronConfig::create('nile');

// Different node types
$fullNodeTron = TronConfig::create('mainnet', false);
$solidityNodeTron = TronConfig::create('mainnet', true);
```

## Basic Examples

### Quick Start Example

```php
<?php

require_once 'vendor/autoload.php';

use Jackillll\Tron\TronConfig;

// Quick setup with new configuration
$tron = TronConfig::create('mainnet', false, [
    'TRON-PRO-API-KEY' => 'your-api-key'
]);

// Generate new address
$generateAddress = $tron->createAccount();
echo $generateAddress['address']; // TKttnV3FSY1iEoAwB4N52WK2DxdV94KpDd
echo $generateAddress['privateKey']; // 7d507c48da396a6b0dbe09f21f729dd2ba29d9a5e5bf8edde5fc9144c7ebe261
echo $generateAddress['publicKey']; // 0337e1a88b108c438266c3ca5c5a73a8b6803443c4f7e1b1d140b11106a4e7d88f

// Get account balance
$balance = $tron->getBalance('TKttnV3FSY1iEoAwB4N52WK2DxdV94KpDd', true);

// Send TRX
$tron->setPrivateKey('7d507c48da396a6b0dbe09f21f729dd2ba29d9a5e5bf8edde5fc9144c7ebe261');
$tron->setAddress('TKttnV3FSY1iEoAwB4N52WK2DxdV94KpDd');

$transfer = $tron->send('TLsV52sRDL79HXGGm9yzwKibb6BeruhUzy', 0.1);
```

### Legacy HttpProvider Example

```php
<?php

require_once 'vendor/autoload.php';

use Jackillll\Tron\Tron;
use Jackillll\Tron\Provider\HttpProvider;

$fullNode = new HttpProvider('https://api.trongrid.io');
$solidityNode = new HttpProvider('https://api.trongrid.io');
$eventServer = new HttpProvider('https://api.trongrid.io');

try {
    $tron = new Tron($fullNode, $solidityNode, $eventServer);
} catch (\Jackillll\Tron\Exception\TronException $e) {
    exit($e->getMessage());
}

// Use the same way as above...
```

## Advanced Features

### Smart Contract Interaction

```php
// Get contract instance
$contract = $tron->contract('TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t'); // USDT contract

// Call contract method
$result = $contract->call('balanceOf', 'TAddress...');

// Send contract transaction
$tron->setPrivateKey('your-private-key');
$result = $contract->send('transfer', 'TToAddress...', 1000000); // 1 USDT
```

### Transaction Management

```php
// Create transaction
$transaction = $tron->getTransactionBuilder()->sendTrx('TTo...', 1000000, 'TFrom...');

// Sign transaction
$signedTransaction = $tron->signTransaction($transaction);

// Broadcast transaction
$result = $tron->sendRawTransaction($signedTransaction);
```

### Block and Transaction Queries

```php
// Get latest blocks
$blocks = $tron->getLatestBlocks(10);

// Get block by number
$block = $tron->getBlock(12345);

// Get transaction by ID
$transaction = $tron->getTransaction('transaction_id_here');

// Get account transactions
$transactions = $tron->getTransactionsFromAddress('TAddress...', 50);
```

## Configuration Migration

### From Old Configuration

```php
// Old way (still supported)
'host' => 'https://api.trongrid.io',
'node_type' => 'fullnode',
```

### To New Configuration

```php
// New way (recommended)
'network' => 'mainnet',
'use_solidity' => false,
```

## Error Handling

```php
use Jackillll\Tron\Exception\TronException;

try {
    $tron = TronConfig::create('mainnet');
    $balance = $tron->getBalance('invalid_address');
} catch (TronException $e) {
    echo "Tron API Error: " . $e->getMessage();
} catch (\Exception $e) {
    echo "General Error: " . $e->getMessage();
}
```

## Best Practices

1. **Use Environment Variables**: Store sensitive data like private keys in environment variables
2. **Error Handling**: Always wrap API calls in try-catch blocks
3. **Network Selection**: Use testnet for development, mainnet for production
4. **API Keys**: Use TronGrid API keys for better rate limits
5. **Node Types**: Use Full Node for transactions, Solidity Node for queries

## API Documentation

For detailed API documentation, please refer to:
- [NEW_CONFIG_GUIDE.md](NEW_CONFIG_GUIDE.md) - New configuration structure guide
- [Tron Developer Documentation](https://developers.tron.network/)
- [TronGrid API Documentation](https://www.trongrid.io/docs/)

## Testing

```bash
composer test
```

## Examples

Check the `examples/` directory for more usage examples:
- `new-config-simple.php` - Basic new configuration usage
- `config-based-example.php` - Advanced configuration examples
- `final-verification.php` - Comprehensive feature testing

## Changelog

### v2.0.0
- ✅ New configuration structure with `network` and `use_solidity`
- ✅ TronConfig helper class for easier setup
- ✅ Support for multiple networks (mainnet, testnet, nile)
- ✅ Backward compatibility with old configuration
- ✅ Improved Laravel integration

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

## Donations
**Tron(TRX)**: TRWBqiqoFZysoAeyR1J35ibuyc8EvhUAoY

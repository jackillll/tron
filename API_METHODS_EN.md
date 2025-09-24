# Laravel Tron Package - Complete API Methods Documentation

## Overview

The Laravel Tron package provides comprehensive functionality for interacting with the TRON blockchain network. This document details all available API methods.

## Table of Contents

1. [Basic Functions](#basic-functions)
2. [Account Management](#account-management)
3. [Transaction Operations](#transaction-operations)
4. [Block Queries](#block-queries)
5. [Smart Contracts](#smart-contracts)
6. [Token Management](#token-management)
7. [Voting Functions](#voting-functions)
8. [Stake 2.0 Staking](#stake-20-staking)
9. [Governance Functions](#governance-functions)
10. [Exchange Functions](#exchange-functions)
11. [Market Functions](#market-functions)
12. [Privacy Transactions](#privacy-transactions)
13. [Resource Management](#resource-management)
14. [Network Information](#network-information)

---

## Basic Functions

### Connection Management

#### `isConnected()`
Check the connection status with the TRON network.

**Returns:** `bool` - Connection status

**Example:**
```php
$isConnected = $tron->isConnected();
```

#### `validateAddress($address)`
Validate the validity of a TRON address.

**Parameters:**
- `$address` (string) - Address to validate

**Returns:** `array` - Validation result

**Example:**
```php
$result = $tron->validateAddress('TRX9Uhjxvb5RYiuqiH1qQD6KpBcBv4cWBY');
```

#### `isAddress($address)`
Check if a string is a valid TRON address.

**Parameters:**
- `$address` (string) - Address to check

**Returns:** `bool` - Whether it's a valid address

**Example:**
```php
$isValid = $tron->isAddress('TRX9Uhjxvb5RYiuqiH1qQD6KpBcBv4cWBY');
```

### Address Conversion

#### `getAddressHex($address)`
Convert Base58 address to hexadecimal format.

**Parameters:**
- `$address` (string) - Base58 address

**Returns:** `string` - Hexadecimal address

#### `getBase58CheckAddress($hexAddress)`
Convert hexadecimal address to Base58 format.

**Parameters:**
- `$hexAddress` (string) - Hexadecimal address

**Returns:** `string` - Base58 address

#### `generateAddress()`
Generate a new TRON address.

**Returns:** `array` - Array containing address and private key

---

## Account Management

### Account Information

#### `getAccount($address)`
Get detailed account information.

**Parameters:**
- `$address` (string) - Account address

**Returns:** `array` - Account information

**Example:**
```php
$account = $tron->getAccount('TRX9Uhjxvb5RYiuqiH1qQD6KpBcBv4cWBY');
```

#### `getAccountResources($address)`
Get account resource information (bandwidth, energy, etc.).

**Parameters:**
- `$address` (string) - Account address

**Returns:** `array` - Resource information

#### `createAccount($ownerAddress, $accountAddress)`
Create a new account.

**Parameters:**
- `$ownerAddress` (string) - Creator address
- `$accountAddress` (string) - New account address

**Returns:** `array` - Transaction information

#### `registerAccount($address, $accountName)`
Register an account name.

**Parameters:**
- `$address` (string) - Account address
- `$accountName` (string) - Account name

**Returns:** `array` - Transaction information

#### `changeAccountName($address, $accountName)`
Change account name.

**Parameters:**
- `$address` (string) - Account address
- `$accountName` (string) - New account name

**Returns:** `array` - Transaction information

### Balance Queries

#### `getBalance($address, $fromTron = false)`
Get TRX balance.

**Parameters:**
- `$address` (string) - Account address
- `$fromTron` (bool) - Whether to fetch from TRON network

**Returns:** `float` - TRX balance

**Example:**
```php
$balance = $tron->getBalance('TRX9Uhjxvb5RYiuqiH1qQD6KpBcBv4cWBY');
```

#### `getTokenBalance($address, $tokenId, $fromTron = false)`
Get token balance.

**Parameters:**
- `$address` (string) - Account address
- `$tokenId` (string) - Token ID or contract address
- `$fromTron` (bool) - Whether to fetch from TRON network

**Returns:** `float` - Token balance

#### `getBandwidth($address)`
Get account bandwidth information.

**Parameters:**
- `$address` (string) - Account address

**Returns:** `array` - Bandwidth information

---

## Transaction Operations

### TRX Transfers

#### `sendTransaction($to, $amount, $from)`
Send TRX transaction.

**Parameters:**
- `$to` (string) - Recipient address
- `$amount` (float) - Transfer amount
- `$from` (string) - Sender address

**Returns:** `array` - Transaction information

**Example:**
```php
$result = $tron->sendTransaction('TTo...', 100, 'TFrom...');
```

#### `send($to, $amount, $from)`
Send TRX (alias for sendTransaction).

#### `sendTrx($to, $amount, $from)`
Send TRX (alias for sendTransaction).

### Token Transfers

#### `sendTokenTransaction($to, $amount, $tokenId, $from)`
Send token transaction.

**Parameters:**
- `$to` (string) - Recipient address
- `$amount` (float) - Transfer amount
- `$tokenId` (string) - Token ID
- `$from` (string) - Sender address

**Returns:** `array` - Transaction information

#### `sendToken($to, $amount, $tokenId, $from)`
Send token (alias for sendTokenTransaction).

### Transaction Signing and Broadcasting

#### `signTransaction($transaction, $privateKey)`
Sign a transaction.

**Parameters:**
- `$transaction` (array) - Transaction object
- `$privateKey` (string) - Private key

**Returns:** `array` - Signed transaction

#### `sendRawTransaction($signedTransaction)`
Broadcast a signed transaction.

**Parameters:**
- `$signedTransaction` (array) - Signed transaction

**Returns:** `array` - Broadcast result

### Transaction Queries

#### `getTransaction($txId)`
Get transaction details by transaction ID.

**Parameters:**
- `$txId` (string) - Transaction ID

**Returns:** `array` - Transaction details

#### `getTransactionInfo($txId)`
Get transaction execution information.

**Parameters:**
- `$txId` (string) - Transaction ID

**Returns:** `array` - Transaction execution information

#### `getTransactionsToAddress($address, $limit = 30, $offset = 0)`
Get list of transactions sent to a specific address.

**Parameters:**
- `$address` (string) - Address
- `$limit` (int) - Limit count
- `$offset` (int) - Offset

**Returns:** `array` - Transaction list

#### `getTransactionsFromAddress($address, $limit = 30, $offset = 0)`
Get list of transactions sent from a specific address.

**Parameters:**
- `$address` (string) - Address
- `$limit` (int) - Limit count
- `$offset` (int) - Offset

**Returns:** `array` - Transaction list

#### `getTransactionsRelated($address, $direction = 'all', $limit = 30, $offset = 0)`
Get transactions related to an address.

**Parameters:**
- `$address` (string) - Address
- `$direction` (string) - Direction: 'all', 'from', 'to'
- `$limit` (int) - Limit count
- `$offset` (int) - Offset

**Returns:** `array` - Transaction list

#### `getTransactionCount()`
Get total network transaction count.

**Returns:** `int` - Total transaction count

---

## Block Queries

### Block Information

#### `getCurrentBlock()`
Get the current latest block.

**Returns:** `array` - Block information

#### `getBlock($block)`
Get block by block number or hash.

**Parameters:**
- `$block` (int|string) - Block number or hash

**Returns:** `array` - Block information

#### `getBlockByHash($blockHash)`
Get block by block hash.

**Parameters:**
- `$blockHash` (string) - Block hash

**Returns:** `array` - Block information

#### `getBlockByNumber($blockNumber)`
Get block by block number.

**Parameters:**
- `$blockNumber` (int) - Block number

**Returns:** `array` - Block information

#### `getBlockRange($start, $end)`
Get block range.

**Parameters:**
- `$start` (int) - Start block number
- `$end` (int) - End block number

**Returns:** `array` - Block list

#### `getLatestBlocks($limit = 1)`
Get latest block list.

**Parameters:**
- `$limit` (int) - Limit count

**Returns:** `array` - Block list

### Block Transactions

#### `getBlockTransactionCount($block)`
Get transaction count in a block.

**Parameters:**
- `$block` (int|string) - Block number or hash

**Returns:** `int` - Transaction count

#### `getTransactionFromBlock($block, $index)`
Get transaction at specific index from a block.

**Parameters:**
- `$block` (int|string) - Block number or hash
- `$index` (int) - Transaction index

**Returns:** `array` - Transaction information

---

## Smart Contracts

### Contract Instantiation

#### `contract($contractAddress, $abi = null)`
Create a smart contract instance (mainly for TRC20 tokens).

**Parameters:**
- `$contractAddress` (string) - Contract address
- `$abi` (string|null) - Contract ABI (optional)

**Returns:** `TRC20Contract` - TRC20 contract instance

**Example:**
```php
$contract = $tron->contract('TLa2f6VPqDgRE67v1736s7bJ8Ray5wYjU7');
$balance = $contract->balanceOf('TRX9Uhjxvb5RYiuqiH1qQD6KpBcBv4cWBY');
```

### Contract Deployment

#### `deployContract($abi, $bytecode, $parameters, $feeLimit, $from)`
Deploy a smart contract.

**Parameters:**
- `$abi` (array) - Contract ABI
- `$bytecode` (string) - Contract bytecode
- `$parameters` (array) - Constructor parameters
- `$feeLimit` (int) - Fee limit
- `$from` (string) - Deployer address

**Returns:** `array` - Deployment result

### Contract Calls

#### `getEventResult($contractAddress, $eventName = null, $blockNumber = null)`
Get contract event results.

**Parameters:**
- `$contractAddress` (string) - Contract address
- `$eventName` (string|null) - Event name
- `$blockNumber` (int|null) - Block number

**Returns:** `array` - Event results

#### `getEventByTransactionID($txId)`
Get events by transaction ID.

**Parameters:**
- `$txId` (string) - Transaction ID

**Returns:** `array` - Event information

---

## Token Management

### Token Creation

#### `createToken($options, $issuerAddress)`
Create a new token.

**Parameters:**
- `$options` (array) - Token parameters
- `$issuerAddress` (string) - Issuer address

**Returns:** `array` - Creation result

#### `updateToken($description, $url, $freeBandwidth, $freeBandwidthLimit, $ownerAddress)`
Update token information.

**Parameters:**
- `$description` (string) - Token description
- `$url` (string) - Token URL
- `$freeBandwidth` (int) - Free bandwidth
- `$freeBandwidthLimit` (int) - Free bandwidth limit
- `$ownerAddress` (string) - Owner address

**Returns:** `array` - Update result

### Token Queries

#### `getTokensIssuedByAddress($address)`
Get list of tokens issued by an address.

**Parameters:**
- `$address` (string) - Address

**Returns:** `array` - Token list

#### `getTokenFromID($tokenId)`
Get token information by ID.

**Parameters:**
- `$tokenId` (string) - Token ID

**Returns:** `array` - Token information

#### `getTokenByID($tokenId)`
Get token information by ID (alias for getTokenFromID).

#### `listTokens($limit = 0, $offset = 0)`
Get token list.

**Parameters:**
- `$limit` (int) - Limit count
- `$offset` (int) - Offset

**Returns:** `array` - Token list

### Token Transactions

#### `purchaseToken($tokenId, $amount, $buyerAddress)`
Purchase tokens.

**Parameters:**
- `$tokenId` (string) - Token ID
- `$amount` (int) - Purchase amount
- `$buyerAddress` (string) - Buyer address

**Returns:** `array` - Purchase result

---

## Voting Functions

### Voting Operations

#### `voteWitnessAccount($votes, $voterAddress)`
Vote for Super Representatives.

**Parameters:**
- `$votes` (array) - Vote list, format: [['vote_address' => 'address', 'vote_count' => count]]
- `$voterAddress` (string) - Voter address

**Returns:** `array` - Vote transaction

**Example:**
```php
$votes = [
    ['vote_address' => 'TSuper...', 'vote_count' => 100],
    ['vote_address' => 'TSuper2...', 'vote_count' => 50]
];
$result = $tron->voteWitnessAccount($votes, 'TVoter...');
```

### Voting Queries

#### `getAccountVotes($address)`
Get account voting information.

**Parameters:**
- `$address` (string) - Account address

**Returns:** `array` - Voting information

#### `getWitnesses()`
Get all Super Representatives list.

**Returns:** `array` - Super Representatives list

#### `getWitness($address)`
Get specific Super Representative information.

**Parameters:**
- `$address` (string) - Super Representative address

**Returns:** `array` - Super Representative information

#### `getBrokerage($address)`
Get Super Representative brokerage information.

**Parameters:**
- `$address` (string) - Super Representative address

**Returns:** `array` - Brokerage information

#### `getReward($address)`
Get account reward information.

**Parameters:**
- `$address` (string) - Account address

**Returns:** `array` - Reward information

### Super Representatives

#### `listSuperRepresentatives()`
Get Super Representatives list.

**Returns:** `array` - Super Representatives list

#### `applyForSuperRepresentative($address, $url)`
Apply to become a Super Representative.

**Parameters:**
- `$address` (string) - Applicant address
- `$url` (string) - Super Representative URL

**Returns:** `array` - Application result

#### `timeUntilNextVoteCycle()`
Get time until next voting cycle.

**Returns:** `int` - Remaining time (seconds)

---

## Stake 2.0 Staking

### Staking Operations

#### `freezeBalanceV2($frozenBalance, $resource, $ownerAddress)`
Stake TRX v2 (Stake 2.0).

**Parameters:**
- `$frozenBalance` (int) - Stake amount (sun)
- `$resource` (string) - Resource type: 'BANDWIDTH' or 'ENERGY'
- `$ownerAddress` (string) - Owner address

**Returns:** `array` - Stake transaction

**Example:**
```php
$result = $tron->freezeBalanceV2(1000000000, 'ENERGY', 'TOwner...');
```

#### `unfreezeBalanceV2($unfreezeBalance, $resource, $ownerAddress)`
Unstake TRX v2.

**Parameters:**
- `$unfreezeBalance` (int) - Unstake amount (sun)
- `$resource` (string) - Resource type: 'BANDWIDTH' or 'ENERGY'
- `$ownerAddress` (string) - Owner address

**Returns:** `array` - Unstake transaction

#### `cancelAllUnfreezeV2($ownerAddress)`
Cancel all unstake operations.

**Parameters:**
- `$ownerAddress` (string) - Owner address

**Returns:** `array` - Cancel transaction

### Resource Delegation

#### `delegateResource($balance, $resource, $receiverAddress, $ownerAddress, $lock = false)`
Delegate resources to other accounts.

**Parameters:**
- `$balance` (int) - Delegate amount (sun)
- `$resource` (string) - Resource type: 'BANDWIDTH' or 'ENERGY'
- `$receiverAddress` (string) - Receiver address
- `$ownerAddress` (string) - Delegator address
- `$lock` (bool) - Whether to lock

**Returns:** `array` - Delegate transaction

#### `undelegateResource($balance, $resource, $receiverAddress, $ownerAddress)`
Cancel resource delegation.

**Parameters:**
- `$balance` (int) - Cancel delegate amount (sun)
- `$resource` (string) - Resource type
- `$receiverAddress` (string) - Receiver address
- `$ownerAddress` (string) - Delegator address

**Returns:** `array` - Cancel delegate transaction

### Staking Queries

#### `getDelegatedResource($fromAddress, $toAddress)`
Get delegated resource information.

**Parameters:**
- `$fromAddress` (string) - Delegator address
- `$toAddress` (string) - Receiver address

**Returns:** `array` - Delegated resource information

#### `getDelegatedResourceAccountIndex($address)`
Get account's delegated resource index.

**Parameters:**
- `$address` (string) - Account address

**Returns:** `array` - Delegated resource index

#### `getAvailableUnfreezeCount($ownerAddress)`
Get available unstake count.

**Parameters:**
- `$ownerAddress` (string) - Owner address

**Returns:** `array` - Available unstake count

### Legacy Staking (Stake 1.0)

#### `freezeBalance($frozenBalance, $frozenDuration, $resource, $ownerAddress, $receiverAddress = null)`
Stake TRX (legacy method).

**Parameters:**
- `$frozenBalance` (int) - Stake amount
- `$frozenDuration` (int) - Stake duration in days
- `$resource` (string) - Resource type
- `$ownerAddress` (string) - Owner address
- `$receiverAddress` (string|null) - Receiver address

**Returns:** `array` - Stake transaction

#### `unfreezeBalance($resource, $ownerAddress, $receiverAddress = null)`
Unstake TRX (legacy method).

**Parameters:**
- `$resource` (string) - Resource type
- `$ownerAddress` (string) - Owner address
- `$receiverAddress` (string|null) - Receiver address

**Returns:** `array` - Unstake transaction

#### `withdrawBlockRewards($ownerAddress)`
Withdraw block rewards.

**Parameters:**
- `$ownerAddress` (string) - Owner address

**Returns:** `array` - Withdraw transaction

---

## Governance Functions

### Proposal Management

#### `createProposal($parameters, $ownerAddress)`
Create a governance proposal.

**Parameters:**
- `$parameters` (array) - Proposal parameters
- `$ownerAddress` (string) - Proposer address

**Returns:** `array` - Create proposal transaction

**Example:**
```php
$parameters = [
    ['key' => 0, 'value' => 1000000]  // Modify maintenance interval
];
$result = $tron->createProposal($parameters, 'TProposer...');
```

#### `approveProposal($proposalId, $ownerAddress, $isApproval = true)`
Approve or reject a proposal.

**Parameters:**
- `$proposalId` (int) - Proposal ID
- `$ownerAddress` (string) - Voter address
- `$isApproval` (bool) - Whether to approve

**Returns:** `array` - Vote transaction

#### `deleteProposal($proposalId, $ownerAddress)`
Delete a proposal.

**Parameters:**
- `$proposalId` (int) - Proposal ID
- `$ownerAddress` (string) - Proposer address

**Returns:** `array` - Delete transaction

### Proposal Queries

#### `getProposals()`
Get all proposals list.

**Returns:** `array` - Proposals list

#### `getProposal($proposalId)`
Get specific proposal information.

**Parameters:**
- `$proposalId` (int) - Proposal ID

**Returns:** `array` - Proposal information

---

## Exchange Functions

### Exchange Operations

#### `exchangeCreate($firstTokenId, $firstTokenBalance, $secondTokenId, $secondTokenBalance, $ownerAddress)`
Create a trading pair.

**Parameters:**
- `$firstTokenId` (string) - First token ID
- `$firstTokenBalance` (int) - First token amount
- `$secondTokenId` (string) - Second token ID
- `$secondTokenBalance` (int) - Second token amount
- `$ownerAddress` (string) - Creator address

**Returns:** `array` - Create transaction

#### `exchangeInject($exchangeId, $tokenId, $quant, $ownerAddress)`
Inject funds into trading pair.

**Parameters:**
- `$exchangeId` (int) - Exchange ID
- `$tokenId` (string) - Token ID
- `$quant` (int) - Inject amount
- `$ownerAddress` (string) - Owner address

**Returns:** `array` - Inject transaction

#### `exchangeWithdraw($exchangeId, $tokenId, $quant, $ownerAddress)`
Withdraw funds from trading pair.

**Parameters:**
- `$exchangeId` (int) - Exchange ID
- `$tokenId` (string) - Token ID
- `$quant` (int) - Withdraw amount
- `$ownerAddress` (string) - Owner address

**Returns:** `array` - Withdraw transaction

#### `exchangeTransaction($exchangeId, $tokenId, $quant, $expected, $ownerAddress)`
Execute exchange transaction.

**Parameters:**
- `$exchangeId` (int) - Exchange ID
- `$tokenId` (string) - Token ID
- `$quant` (int) - Transaction amount
- `$expected` (int) - Expected receive amount
- `$ownerAddress` (string) - Trader address

**Returns:** `array` - Transaction result

### Exchange Queries

#### `getExchange($exchangeId)`
Get trading pair information.

**Parameters:**
- `$exchangeId` (int) - Exchange ID

**Returns:** `array` - Trading pair information

#### `listExchanges()`
Get all trading pairs list.

**Returns:** `array` - Trading pairs list

---

## Market Functions

### Market Trading

#### `marketSellAsset($sellTokenId, $sellTokenQuantity, $buyTokenId, $buyTokenQuantity, $ownerAddress)`
Sell assets on the market.

**Parameters:**
- `$sellTokenId` (string) - Sell token ID
- `$sellTokenQuantity` (int) - Sell quantity
- `$buyTokenId` (string) - Buy token ID
- `$buyTokenQuantity` (int) - Buy quantity
- `$ownerAddress` (string) - Seller address

**Returns:** `array` - Sell transaction

#### `marketCancelOrder($orderId, $ownerAddress)`
Cancel market order.

**Parameters:**
- `$orderId` (string) - Order ID
- `$ownerAddress` (string) - Order owner address

**Returns:** `array` - Cancel transaction

### Market Queries

#### `getMarketOrderById($orderId)`
Get market order by ID.

**Parameters:**
- `$orderId` (string) - Order ID

**Returns:** `array` - Order information

#### `getMarketOrderByAccount($address)`
Get account's market orders.

**Parameters:**
- `$address` (string) - Account address

**Returns:** `array` - Order list

#### `getMarketPriceByPair($sellTokenId, $buyTokenId)`
Get market price for trading pair.

**Parameters:**
- `$sellTokenId` (string) - Sell token ID
- `$buyTokenId` (string) - Buy token ID

**Returns:** `array` - Price information

#### `getMarketOrderListByPair($sellTokenId, $buyTokenId)`
Get order list for trading pair.

**Parameters:**
- `$sellTokenId` (string) - Sell token ID
- `$buyTokenId` (string) - Buy token ID

**Returns:** `array` - Order list

---

## Privacy Transactions

### Privacy Transaction Creation

#### `createShieldedTransaction($transparentFromAddress, $fromAmount, $shieldedSpends, $shieldedOutputs, $transparentToAddress, $toAmount)`
Create a privacy transaction.

**Parameters:**
- `$transparentFromAddress` (string) - Transparent sender address
- `$fromAmount` (int) - Send amount
- `$shieldedSpends` (array) - Shielded inputs
- `$shieldedOutputs` (array) - Shielded outputs
- `$transparentToAddress` (string) - Transparent receiver address
- `$toAmount` (int) - Receive amount

**Returns:** `array` - Privacy transaction

#### `getShieldedTransactionHash($transaction)`
Get privacy transaction hash.

**Parameters:**
- `$transaction` (array) - Privacy transaction

**Returns:** `string` - Transaction hash

### Privacy Address Management

#### `getSpendingKey()`
Generate spending key.

**Returns:** `string` - Spending key

#### `getExpandedSpendingKey($spendingKey)`
Expand spending key.

**Parameters:**
- `$spendingKey` (string) - Spending key

**Returns:** `array` - Expanded key

#### `getShieldedPaymentAddress($ivk, $diversifier)`
Get shielded payment address.

**Parameters:**
- `$ivk` (string) - Incoming viewing key
- `$diversifier` (string) - Diversifier

**Returns:** `string` - Shielded address

### Privacy Transaction Queries

#### `scanNoteByIvk($startBlockNumber, $endBlockNumber, $ivk)`
Scan notes by incoming viewing key.

**Parameters:**
- `$startBlockNumber` (int) - Start block number
- `$endBlockNumber` (int) - End block number
- `$ivk` (string) - Incoming viewing key

**Returns:** `array` - Note list

#### `isNoteSpent($ak, $nk, $position)`
Check if note is spent.

**Parameters:**
- `$ak` (string) - Authorization key
- `$nk` (string) - Nullifier key
- `$position` (int) - Position

**Returns:** `bool` - Whether spent

---

## Resource Management

### Resource Pricing

#### `getEnergyPrices()`
Get energy price information.

**Returns:** `array` - Energy prices

#### `getBandwidthPrices()`
Get bandwidth price information.

**Returns:** `array` - Bandwidth prices

---

## Network Information

### Network Status

#### `listNodes()`
Get network node list.

**Returns:** `array` - Node list

---

## Utility Methods

### Address Conversion

#### `address2HexString($address)`
Convert Base58 address to hexadecimal string.

**Parameters:**
- `$address` (string) - Base58 address

**Returns:** `string` - Hexadecimal address

#### `hexString2Address($hexString)`
Convert hexadecimal string to Base58 address.

**Parameters:**
- `$hexString` (string) - Hexadecimal address

**Returns:** `string` - Base58 address

### Data Conversion

#### `fromHex($hexString)`
Convert from hexadecimal string.

**Parameters:**
- `$hexString` (string) - Hexadecimal string

**Returns:** `string` - Converted string

#### `toHex($string)`
Convert to hexadecimal string.

**Parameters:**
- `$string` (string) - String to convert

**Returns:** `string` - Hexadecimal string

#### `stringUtf8toHex($utf8String)`
Convert UTF-8 string to hexadecimal.

**Parameters:**
- `$utf8String` (string) - UTF-8 string

**Returns:** `string` - Hexadecimal string

#### `hexString2Utf8($hexString)`
Convert hexadecimal string to UTF-8.

**Parameters:**
- `$hexString` (string) - Hexadecimal string

**Returns:** `string` - UTF-8 string

### Numeric Conversion

#### `fromTron($amount)`
Convert from TRX to sun (1 TRX = 1,000,000 sun).

**Parameters:**
- `$amount` (float) - TRX amount

**Returns:** `int` - Sun amount

#### `toTron($amount)`
Convert from sun to TRX.

**Parameters:**
- `$amount` (int) - Sun amount

**Returns:** `float` - TRX amount

#### `toBigNumber($value)`
Convert to big number.

**Parameters:**
- `$value` (string|int) - Numeric value

**Returns:** `BigInteger` - Big number object

### Hash Functions

#### `sha3($string, $prefix = true)`
Calculate SHA3 hash.

**Parameters:**
- `$string` (string) - String to hash
- `$prefix` (bool) - Whether to add prefix

**Returns:** `string` - Hash value

#### `getNodeInfo()`
Get current node information.

**Returns:** `array` - Node information

#### `getChainParameters()`
Get chain parameters.

**Returns:** `array` - Chain parameters

#### `getBurnTrx()`
Get burned TRX information.

**Returns:** `array` - Burn information

---

## Utility Methods

### Encoding Conversion

#### `toUtf8($hex)`
Convert hexadecimal to UTF-8 string.

**Parameters:**
- `$hex` (string) - Hexadecimal string

**Returns:** `string` - UTF-8 string

---

## Error Handling

All methods will throw appropriate exceptions when encountering errors:

- `TronException` - General TRON-related errors
- `TRC20Exception` - TRC20 token-related errors
- `NotFoundException` - Resource not found errors
- `ErrorException` - Other errors

## Usage Examples

```php
use Jackillll\Tron\Tron;

// Initialize
$tron = new Tron();

// Check connection
if ($tron->isConnected()) {
    // Get account balance
    $balance = $tron->getBalance('TRX9Uhjxvb5RYiuqiH1qQD6KpBcBv4cWBY');
    
    // Send TRX
    $result = $tron->sendTransaction('TTo...', 100, 'TFrom...');
    
    // Vote for Super Representatives
    $votes = [['vote_address' => 'TSuper...', 'vote_count' => 100]];
    $voteResult = $tron->voteWitnessAccount($votes, 'TVoter...');
    
    // Stake TRX
    $stakeResult = $tron->freezeBalanceV2(1000000000, 'ENERGY', 'TOwner...');
}
```

## Important Notes

1. All amount parameters are in sun units (1 TRX = 1,000,000 sun)
2. Addresses must be in valid TRON address format
3. Private key operations require special care for secure storage
4. Some operations require TRX as transaction fees
5. Privacy transaction features require special key management

## Version Requirements

- PHP >= 7.4
- Laravel >= 8.0
- TRON network connection

---

*This documentation is based on the latest version of the Laravel Tron package. Please refer to the official documentation for updates.*

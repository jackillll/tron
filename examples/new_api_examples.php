<?php

/**
 * Laravel Tron Package - New API Examples
 * 
 * This file demonstrates the usage of newly added TRON API methods
 * that were missing from the original package implementation.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Jackillll\Tron\Tron;
use Jackillll\Tron\Exception\TronException;

// Initialize Tron instance
$tron = new Tron();

// Set your private key and address
$tron->setPrivateKey('your_private_key_here');
$tron->setAddress('your_address_here');

echo "=== Laravel Tron Package - New API Examples ===\n\n";

try {
    // ===== VOTING APIS =====
    echo "1. VOTING APIS\n";
    echo "---------------\n";
    
    // Vote for Super Representatives
    echo "Voting for Super Representatives...\n";
    $votes = [
        ['vote_address' => 'TRX9Jv1pdH2rn6TrDXh4tagSd5zp4K6UZ', 'vote_count' => 100],
        ['vote_address' => 'TLyqzVGLV1srkB7dToTAEqgDSfPtXRJZYH', 'vote_count' => 50]
    ];
    // $voteResult = $tron->voteWitnessAccount($votes);
    // echo "Vote transaction created: " . json_encode($voteResult) . "\n\n";
    
    // Get account votes
    echo "Getting account votes...\n";
    // $accountVotes = $tron->getAccountVotes();
    // echo "Account votes: " . json_encode($accountVotes) . "\n\n";
    
    // Get all witnesses (Super Representatives)
    echo "Getting all witnesses...\n";
    // $witnesses = $tron->getWitnesses();
    // echo "Total witnesses: " . count($witnesses) . "\n\n";
    
    // ===== STAKE 2.0 APIS =====
    echo "2. STAKE 2.0 APIS\n";
    echo "-----------------\n";
    
    // Freeze balance v2 (Stake 2.0)
    echo "Freezing balance v2...\n";
    // $freezeResult = $tron->freezeBalanceV2(1000000, 'ENERGY'); // 1 TRX for ENERGY
    // echo "Freeze v2 result: " . json_encode($freezeResult) . "\n\n";
    
    // Delegate resource
    echo "Delegating resource...\n";
    // $delegateResult = $tron->delegateResource('receiver_address', 500000, 'BANDWIDTH');
    // echo "Delegate result: " . json_encode($delegateResult) . "\n\n";
    
    // Get delegated resource
    echo "Getting delegated resource...\n";
    // $delegatedResource = $tron->getDelegatedResource('from_address', 'to_address');
    // echo "Delegated resource: " . json_encode($delegatedResource) . "\n\n";
    
    // ===== GOVERNANCE APIS =====
    echo "3. GOVERNANCE APIS\n";
    echo "------------------\n";
    
    // Create proposal
    echo "Creating proposal...\n";
    $parameters = [
        ['key' => 0, 'value' => 100000], // Example: modify maintenance time interval
    ];
    // $proposalResult = $tron->createProposal($parameters);
    // echo "Proposal created: " . json_encode($proposalResult) . "\n\n";
    
    // Get all proposals
    echo "Getting all proposals...\n";
    // $proposals = $tron->getProposals();
    // echo "Total proposals: " . count($proposals) . "\n\n";
    
    // Get chain parameters
    echo "Getting chain parameters...\n";
    // $chainParams = $tron->getChainParameters();
    // echo "Chain parameters: " . json_encode($chainParams) . "\n\n";
    
    // ===== EXCHANGE APIS =====
    echo "4. EXCHANGE APIS\n";
    echo "----------------\n";
    
    // Create exchange
    echo "Creating exchange...\n";
    // $exchangeResult = $tron->exchangeCreate('_', 1000000, '1000001', 2000000);
    // echo "Exchange created: " . json_encode($exchangeResult) . "\n\n";
    
    // Get exchange
    echo "Getting exchange by ID...\n";
    // $exchange = $tron->getExchange(1);
    // echo "Exchange details: " . json_encode($exchange) . "\n\n";
    
    // List all exchanges
    echo "Getting all exchanges...\n";
    // $exchanges = $tron->listExchanges();
    // echo "Total exchanges: " . count($exchanges) . "\n\n";
    
    // ===== MARKET APIS =====
    echo "5. MARKET APIS\n";
    echo "--------------\n";
    
    // Sell asset on market
    echo "Selling asset on market...\n";
    // $sellResult = $tron->marketSellAsset('1000001', 1000000, '1000002', 2000000);
    // echo "Market sell result: " . json_encode($sellResult) . "\n\n";
    
    // Get market orders by account
    echo "Getting market orders by account...\n";
    // $marketOrders = $tron->getMarketOrderByAccount();
    // echo "Market orders: " . json_encode($marketOrders) . "\n\n";
    
    // Get market price by pair
    echo "Getting market price by pair...\n";
    // $marketPrice = $tron->getMarketPriceByPair('1000001', '1000002');
    // echo "Market price: " . json_encode($marketPrice) . "\n\n";
    
    // ===== PRIVACY TRANSACTION APIS =====
    echo "6. PRIVACY TRANSACTION APIS\n";
    echo "----------------------------\n";
    
    // Get spending key
    echo "Getting spending key...\n";
    // $spendingKey = $tron->getSpendingKey();
    // echo "Spending key: " . json_encode($spendingKey) . "\n\n";
    
    // Get diversifier
    echo "Getting diversifier...\n";
    // $diversifier = $tron->getDiversifier();
    // echo "Diversifier: " . json_encode($diversifier) . "\n\n";
    
    // Create shielded transaction (example with minimal parameters)
    echo "Creating shielded transaction...\n";
    // $shieldedTx = $tron->createShieldedTransaction([], [], 'transparent_from_address', null, 1000000);
    // echo "Shielded transaction: " . json_encode($shieldedTx) . "\n\n";
    
    // ===== ADDITIONAL QUERY APIS =====
    echo "7. ADDITIONAL QUERY APIS\n";
    echo "------------------------\n";
    
    // Get node info
    echo "Getting node info...\n";
    // $nodeInfo = $tron->getNodeInfo();
    // echo "Node info: " . json_encode($nodeInfo) . "\n\n";
    
    // Get burn TRX
    echo "Getting burn TRX...\n";
    // $burnTrx = $tron->getBurnTrx();
    // echo "Burn TRX: " . json_encode($burnTrx) . "\n\n";
    
    // Get energy prices
    echo "Getting energy prices...\n";
    // $energyPrices = $tron->getEnergyPrices();
    // echo "Energy prices: " . json_encode($energyPrices) . "\n\n";
    
    // Get bandwidth prices
    echo "Getting bandwidth prices...\n";
    // $bandwidthPrices = $tron->getBandwidthPrices();
    // echo "Bandwidth prices: " . json_encode($bandwidthPrices) . "\n\n";
    
    echo "=== All examples completed successfully! ===\n";
    echo "Note: Most API calls are commented out to prevent actual transactions.\n";
    echo "Uncomment the lines you want to test with real data.\n";
    
} catch (TronException $e) {
    echo "Error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "General Error: " . $e->getMessage() . "\n";
}

/**
 * USAGE NOTES:
 * 
 * 1. VOTING:
 *    - Use voteWitnessAccount() to vote for Super Representatives
 *    - Use getAccountVotes() to check your current votes
 *    - Use getWitnesses() to get list of all Super Representatives
 * 
 * 2. STAKE 2.0:
 *    - Use freezeBalanceV2() instead of the old freezeBalance()
 *    - Use delegateResource() to delegate resources to other accounts
 *    - Use unfreezeBalanceV2() to unfreeze staked TRX
 * 
 * 3. GOVERNANCE:
 *    - Use createProposal() to create network governance proposals
 *    - Use approveProposal() to vote on proposals
 *    - Use getChainParameters() to get current network parameters
 * 
 * 4. EXCHANGE:
 *    - Use exchangeCreate() to create token exchanges
 *    - Use exchangeTransaction() to perform exchange trades
 *    - Use getExchange() to get exchange details
 * 
 * 5. MARKET:
 *    - Use marketSellAsset() to sell tokens on the market
 *    - Use marketCancelOrder() to cancel market orders
 *    - Use getMarketPriceByPair() to get market prices
 * 
 * 6. PRIVACY:
 *    - Use createShieldedTransaction() for privacy transactions
 *    - Use getSpendingKey() and related methods for key management
 *    - Use scanNoteByIvk() to scan for received notes
 */

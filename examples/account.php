<?php

/**
 * TRON Account Management Example
 *
 * This example demonstrates how to:
 * - Generate new TRON addresses
 * - Validate TRON addresses
 * - Display address in both hex and base58 formats
 * - Use HttpProvider with API authentication
 *
 * @package    Jackillll\Tron
 * @author     Jackillll <jackjack75383973@gmail.com>
 * @version    2.0.0
 * @since      1.0.0
 */

include_once __DIR__ . '/../vendor/autoload.php';

// 使用提供的API token
$headers = [
    'TRON-PRO-API-KEY' => '25ab81fb-6ee6-4b43-bab7-a67a8a3638f8'
];

$httpProvider = new \Jackillll\Tron\Provider\HttpProvider('https://api.trongrid.io', 30000, false, false, $headers);

try {
    $tron = new \Jackillll\Tron\Tron($httpProvider);

    echo "正在生成新的Tron地址...\n";
    $generateAddress = $tron->generateAddress(); // or createAddress()
    $isValid = $tron->isAddress($generateAddress->getAddress());

    echo "地址生成成功!\n";
    echo 'Address hex: ' . $generateAddress->getAddress() . "\n";
    echo 'Address base58: ' . $generateAddress->getAddress(true) . "\n";
    echo 'Private key: ' . $generateAddress->getPrivateKey() . "\n";
    echo 'Public key: ' . $generateAddress->getPublicKey() . "\n";
    echo 'Is Valid: ' . ($isValid ? 'Yes' : 'No') . "\n";

    echo 'Raw data: ' . json_encode($generateAddress->getRawData()) . "\n";
} catch (\Jackillll\Tron\Exception\TronException $e) {
    echo "错误: " . $e->getMessage() . "\n";
}

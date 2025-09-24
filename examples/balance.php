<?php

/**
 * TRON Balance Query Example
 *
 * This example demonstrates how to:
 * - Query TRX balance for a specific address
 * - Handle TRON API authentication
 * - Use HttpProvider for balance queries
 * - Display balance information in a readable format
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
} catch (\Jackillll\Tron\Exception\TronException $e) {
    exit($e->getMessage());
}

// 使用一个真实的Tron地址进行测试
$testAddress = 'TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t'; // USDT合约地址，用于测试
echo "正在查询地址余额: " . $testAddress . "\n";

try {
    $balance = $tron->getBalance($testAddress, true);
    echo "余额查询成功!\n";
    echo "TRX余额: " . $balance . " TRX\n";

    // 也查询一下原始余额（以sun为单位）
    $balanceInSun = $tron->getBalance($testAddress, false);
    echo "原始余额: " . $balanceInSun . " SUN\n";
} catch (Exception $e) {
    echo "查询余额时出错: " . $e->getMessage() . "\n";
}

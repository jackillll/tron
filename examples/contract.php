<?php

include_once __DIR__ . '/../vendor/autoload.php';

use Jackillll\Tron\Tron;

// 使用提供的API token
$headers = [
    'TRON-PRO-API-KEY' => '25ab81fb-6ee6-4b43-bab7-a67a8a3638f8'
];

$httpProvider = new \Jackillll\Tron\Provider\HttpProvider('https://api.trongrid.io', 30000, false, false, $headers);

try {
    $tron = new Tron($httpProvider);
    $contract = $tron->contract('TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t');  // Tether USDT https://tronscan.org/#/token20/TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t

    echo "正在查询USDT合约信息...\n";

    // Data
    echo "合约名称: " . $contract->name() . "\n";
    echo "合约符号: " . $contract->symbol() . "\n";
    echo "总供应量: " . $contract->totalSupply() . "\n";

    // 查询一个地址的余额（需要提供地址）
    $testAddress = 'TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t'; // 使用合约地址本身作为测试
    echo "地址 " . $testAddress . " 的USDT余额: " . $contract->balanceOf($testAddress) . "\n";

    //echo  $contract->transfer('to', 'amount', 'from');

} catch (\Jackillll\Tron\Exception\TronException $e) {
    echo "错误: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "错误: " . $e->getMessage() . "\n";
}

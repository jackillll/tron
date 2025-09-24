<?php
include_once __DIR__ . '/../vendor/autoload.php';

// 使用提供的API token
$headers = [
    'TRON-PRO-API-KEY' => '25ab81fb-6ee6-4b43-bab7-a67a8a3638f8'
];

// 使用solidity节点
$httpProvider = new \Jackillll\Tron\Provider\HttpProvider('https://api.trongrid.io', 30000, false, false, [], '/', 'solidity');

try {
    $tron = new \Jackillll\Tron\Tron($httpProvider);

    echo "Tron地址生成示例 (使用Solidity节点):\n";
    echo "节点类型: " . $httpProvider->getNodeType() . "\n";
    $connectionStatus = $tron->isConnected();
    echo "连接状态: " . (isset($connectionStatus['fullNode']) && $connectionStatus['fullNode'] ? '已连接' : '未连接') . "\n\n";

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

    // 测试查询一个已知地址的信息
    echo "\n测试查询已知地址信息:\n";
    $testAddress = 'TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t'; // USDT合约地址
    try {
        $accountInfo = $tron->getAccount($testAddress);
        echo "地址: " . $testAddress . "\n";
        echo "账户类型: " . (isset($accountInfo['type']) ? $accountInfo['type'] : 'Contract') . "\n";
        echo "余额: " . (isset($accountInfo['balance']) ? $accountInfo['balance'] : '0') . " SUN\n";
    } catch (Exception $e) {
        echo "查询账户信息时出错: " . $e->getMessage() . "\n";
    }
} catch (\Jackillll\Tron\Exception\TronException $e) {
    echo "错误: " . $e->getMessage() . "\n";
}

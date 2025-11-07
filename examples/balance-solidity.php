<?php
include_once __DIR__ . '/../vendor/autoload.php';

use Jackillll\Tron\Tron;
use Jackillll\Tron\Provider\HttpProvider;

// 使用提供的API token
$headers = [
    'TRON-PRO-API-KEY' => '25ab81fb-6ee6-4b43-bab7-a67a8a3638f8'
];

// 使用solidity节点 - 新的构造方式
$httpProvider = new HttpProvider('https://api.trongrid.io', [
    'timeout' => 30000,
    'headers' => $headers,
    'nodeType' => 'solidity'
]);

try {
    $tron = new \Jackillll\Tron\Tron($httpProvider);

    echo "余额查询示例 (使用Solidity节点):\n";
    echo "节点类型: " . $httpProvider->getNodeType() . "\n";
    $connectionStatus = $tron->isConnected();
    echo "连接状态: " . (isset($connectionStatus['fullNode']) && $connectionStatus['fullNode'] ? '已连接' : '未连接') . "\n\n";
} catch (\Jackillll\Tron\Exception\TronException $e) {
    exit($e->getMessage());
}

// 测试多个地址的余额查询
$testAddresses = [
    'TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t', // USDT合约地址
    'TLa2f6VPqDgRE67v1736s7bJ8Ray5wYjU7', // 另一个测试地址
    'TAUN6FwrnwwmaEqYcckffC7wYmbaS6cBiX'  // 另一个测试地址
];

foreach ($testAddresses as $testAddress) {
    echo "正在查询地址余额: " . $testAddress . "\n";

    try {
        $balance = $tron->getBalance($testAddress, true);
        echo "TRX余额: " . $balance . " TRX\n";

        // 也查询一下原始余额（以sun为单位）
        $balanceInSun = $tron->getBalance($testAddress, false);
        echo "原始余额: " . $balanceInSun . " SUN\n";

        // 查询账户信息
        $accountInfo = $tron->getAccount($testAddress);
        if (isset($accountInfo['type'])) {
            echo "账户类型: " . $accountInfo['type'] . "\n";
        }

        echo "---\n";
    } catch (Exception $e) {
        echo "查询余额时出错: " . $e->getMessage() . "\n";
        echo "---\n";
    }
}

// 测试URL构建
echo "\nURL构建测试:\n";
echo "基础URL: " . $httpProvider->getHost() . "\n";
echo "节点类型: " . $httpProvider->getNodeType() . "\n";
echo "说明: Solidity节点会自动为非wallet端点添加'solidity/'前缀\n";

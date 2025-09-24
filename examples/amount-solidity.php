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

    echo "TRX金额转换示例 (使用Solidity节点):\n";
    echo "节点类型: " . $httpProvider->getNodeType() . "\n";
    $connectionStatus = $tron->isConnected();
    echo "连接状态: " . (isset($connectionStatus['fullNode']) && $connectionStatus['fullNode'] ? '已连接' : '未连接') . "\n\n";

    /**
     * WARNING: When sending funds, you should not specify these parameters
     *
     * P.S: In the process of payment are automatically converted
     */

    $from = $tron->toTron(1.15); // 将1.15 TRX转换为SUN
    $to = $tron->fromTron(11500000); // 将11500000 SUN转换为TRX

    echo "1.15 TRX = " . $from . " SUN\n";
    echo "11500000 SUN = " . $to . " TRX\n";

    // 测试一些基本的查询功能
    echo "\n测试基本查询功能:\n";
    $currentBlock = $tron->getCurrentBlock();
    if (isset($currentBlock['blockHeader']['raw_data']['number'])) {
        echo "当前区块号: " . $currentBlock['blockHeader']['raw_data']['number'] . "\n";
    } else {
        echo "当前区块号: " . (isset($currentBlock['block_header']['raw_data']['number']) ? $currentBlock['block_header']['raw_data']['number'] : '未知') . "\n";
    }
    echo "区块哈希: " . (isset($currentBlock['blockID']) ? $currentBlock['blockID'] : '未知') . "\n";
} catch (\Jackillll\Tron\Exception\TronException $e) {
    echo "错误: " . $e->getMessage() . "\n";
}

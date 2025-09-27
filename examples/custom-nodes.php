<?php
include_once __DIR__ . '/../vendor/autoload.php';

use Jackillll\Tron\Provider\HttpProvider;
use Jackillll\Tron\Tron;

// 使用提供的API token
$headers = [
    'TRON-PRO-API-KEY' => '25ab81fb-6ee6-4b43-bab7-a67a8a3638f8'
];

echo "自定义节点配置示例:\n";

// 方法1: 使用单个HttpProvider（推荐）
try {
    $httpProvider = new HttpProvider('https://api.trongrid.io', [
        'timeout' => 30000,
        'headers' => $headers
    ]);
    $tron = new Tron($httpProvider);

    echo "方法1 - 单个HttpProvider: 初始化成功\n";

    // 测试连接
    $isConnected = $tron->isConnected();
    echo "连接状态: " . (count($isConnected) > 0 && $isConnected[0]['fullNode'] ? '已连接' : '未连接') . "\n\n";
} catch (\Jackillll\Tron\Exception\TronException $e) {
    echo "方法1错误: " . $e->getMessage() . "\n\n";
}

// 方法2: 使用不同节点类型
try {
    // FullNode 配置
    $fullNode = new HttpProvider('https://api.trongrid.io', [
        'timeout' => 30000,
        'headers' => $headers,
        'nodeType' => 'fullnode'
    ]);
    $tronFullNode = new Tron($fullNode);

    echo "方法2a - FullNode: 初始化成功\n";
    echo "节点类型: " . $fullNode->getNodeType() . "\n";

    // SolidityNode 配置
    $solidityNode = new HttpProvider('https://api.trongrid.io', [
        'timeout' => 30000,
        'headers' => $headers,
        'nodeType' => 'solidity'
    ]);
    $tronSolidityNode = new Tron($solidityNode);

    echo "方法2b - SolidityNode: 初始化成功\n";
    echo "节点类型: " . $solidityNode->getNodeType() . "\n\n";
} catch (\Jackillll\Tron\Exception\TronException $e) {
    echo "方法2错误: " . $e->getMessage() . "\n\n";
}

// 方法3: 动态切换节点类型
try {
    $dynamicProvider = new HttpProvider('https://api.trongrid.io', [
        'timeout' => 30000,
        'headers' => $headers
    ]);
    $tronDynamic = new Tron($dynamicProvider);

    echo "方法3 - 动态切换节点类型:\n";
    echo "初始节点类型: " . $dynamicProvider->getNodeType() . "\n";

    // 切换到 solidity 节点
    $dynamicProvider->setNodeType('solidity');
    echo "切换后节点类型: " . $dynamicProvider->getNodeType() . "\n";

    // 切换回 fullnode
    $dynamicProvider->setNodeType('fullnode');
    echo "最终节点类型: " . $dynamicProvider->getNodeType() . "\n\n";

    echo "节点类型说明:\n";
    echo "- fullnode: 实时数据，适用于交易广播和最新状态查询\n";
    echo "- solidity: 已确认数据，适用于历史数据和智能合约调用\n";
} catch (\Jackillll\Tron\Exception\TronException $e) {
    echo "方法3错误: " . $e->getMessage() . "\n";
}

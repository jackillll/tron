<?php

include_once __DIR__ . '/../vendor/autoload.php';

use Jackillll\Tron\Tron;
use Jackillll\Tron\Provider\HttpProvider;

echo "节点类型演示 (FullNode vs SolidityNode):\n";
echo "==========================================\n\n";

try {
    // 1. FullNode 示例
    echo "1. FullNode 配置:\n";
    $fullNodeProvider = new HttpProvider('https://api.trongrid.io', [
        'timeout' => 30000,
        'headers' => [
            'TRON-PRO-API-KEY' => '25ab81fb-6ee6-4b43-bab7-a67a8a3638f8'
        ],
        'nodeType' => 'fullnode'
    ]);

    $tronFullNode = new Tron($fullNodeProvider);

    echo "节点类型: " . $fullNodeProvider->getNodeType() . "\n";
    echo "连接状态: " . ($tronFullNode->isConnected() ? "已连接" : "未连接") . "\n";

    // 获取最新区块 (FullNode)
    $latestBlock = $tronFullNode->getLatestBlocks(1);
    if ($latestBlock && isset($latestBlock[0])) {
        echo "最新区块号: " . $latestBlock[0]['block_header']['raw_data']['number'] . "\n";
    }

    echo "\n";

    // 2. SolidityNode 示例
    echo "2. SolidityNode 配置:\n";
    $solidityNodeProvider = new HttpProvider('https://api.trongrid.io', [
        'timeout' => 30000,
        'headers' => [
            'TRON-PRO-API-KEY' => '25ab81fb-6ee6-4b43-bab7-a67a8a3638f8'
        ],
        'nodeType' => 'solidity'
    ]);

    $tronSolidityNode = new Tron($solidityNodeProvider);

    echo "节点类型: " . $solidityNodeProvider->getNodeType() . "\n";
    echo "连接状态: " . ($tronSolidityNode->isConnected() ? "已连接" : "未连接") . "\n";

    // 获取最新区块 (SolidityNode) - 通常会稍微滞后
    $solidityBlock = $tronSolidityNode->getLatestBlocks(1);
    if ($solidityBlock && isset($solidityBlock[0])) {
        echo "最新区块号: " . $solidityBlock[0]['block_header']['raw_data']['number'] . "\n";
    }

    echo "\n";

    // 3. 动态切换节点类型
    echo "3. 动态切换节点类型:\n";
    $dynamicProvider = new HttpProvider('https://api.trongrid.io', [
        'timeout' => 30000,
        'headers' => [
            'TRON-PRO-API-KEY' => '25ab81fb-6ee6-4b43-bab7-a67a8a3638f8'
        ]
    ]);

    $tronDynamic = new Tron($dynamicProvider);

    echo "初始节点类型: " . $dynamicProvider->getNodeType() . "\n";

    // 切换到 solidity 节点
    $dynamicProvider->setNodeType('solidity');
    echo "切换后节点类型: " . $dynamicProvider->getNodeType() . "\n";

    // 切换回 fullnode
    $dynamicProvider->setNodeType('fullnode');
    echo "再次切换后节点类型: " . $dynamicProvider->getNodeType() . "\n";

    echo "\n";

    // 4. 节点类型使用建议
    echo "4. 节点类型使用建议:\n";
    echo "FullNode: 适用于实时数据查询、交易广播\n";
    echo "SolidityNode: 适用于已确认的历史数据查询、智能合约调用\n";
    echo "- FullNode 数据更实时，但可能包含未确认的交易\n";
    echo "- SolidityNode 数据稍有延迟，但更稳定可靠\n";
} catch (\Exception $e) {
    echo "错误: " . $e->getMessage() . "\n";
}

echo "\n注意: 请将 'your-api-key-here' 替换为您的真实 TronGrid API Key\n";

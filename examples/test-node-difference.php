<?php

include_once __DIR__ . '/../vendor/autoload.php';

use Jackillll\Tron\Tron;
use Jackillll\Tron\Provider\HttpProvider;

// 使用真实的 TronGrid API Key
$headers = [
    'TRON-PRO-API-KEY' => '25ab81fb-6ee6-4b43-bab7-a67a8a3638f8'
];

echo "测试 FullNode 和 SolidityNode 的区别:\n";
echo "=====================================\n\n";

try {
    // 测试 FullNode
    echo "1. FullNode 测试:\n";
    $fullNodeProvider = new HttpProvider('https://api.trongrid.io', 30000, false, false, $headers, '/', 'fullnode');
    $tronFullNode = new Tron($fullNodeProvider);

    echo "节点类型: " . $fullNodeProvider->getNodeType() . "\n";
    echo "连接状态: " . ($fullNodeProvider->isConnected() ? '已连接' : '未连接') . "\n";

    // 测试 URL 构建
    echo "测试 URL 构建:\n";
    echo "- wallet/getnowblock -> " . $fullNodeProvider->getHost() . "/wallet/getnowblock\n";
    echo "- getblockbynum -> " . $fullNodeProvider->getHost() . "/getblockbynum\n\n";

    // 测试 SolidityNode
    echo "2. SolidityNode 测试:\n";
    $solidityNodeProvider = new HttpProvider('https://api.trongrid.io', 30000, false, false, $headers, '/', 'solidity');
    $tronSolidityNode = new Tron($solidityNodeProvider);

    echo "节点类型: " . $solidityNodeProvider->getNodeType() . "\n";
    echo "连接状态: " . ($solidityNodeProvider->isConnected() ? '已连接' : '未连接') . "\n";

    // 测试 URL 构建
    echo "测试 URL 构建:\n";
    echo "- wallet/getnowblock -> " . $solidityNodeProvider->getHost() . "/wallet/getnowblock\n";
    echo "- getblockbynum -> " . $solidityNodeProvider->getHost() . "/solidity/getblockbynum\n\n";

    // 动态切换测试
    echo "3. 动态切换测试:\n";
    $dynamicProvider = new HttpProvider('https://api.trongrid.io', 30000, false, false, $headers);

    echo "初始状态: " . $dynamicProvider->getNodeType() . "\n";

    $dynamicProvider->setNodeType('solidity');
    echo "切换到 solidity: " . $dynamicProvider->getNodeType() . "\n";

    $dynamicProvider->setNodeType('fullnode');
    echo "切换回 fullnode: " . $dynamicProvider->getNodeType() . "\n\n";

    echo "使用建议:\n";
    echo "- FullNode: 用于获取最新的区块链状态和广播交易\n";
    echo "- SolidityNode: 用于查询已确认的历史数据和智能合约状态\n";
    echo "- 对于实时数据查询，建议使用 FullNode\n";
    echo "- 对于历史数据和智能合约调用，建议使用 SolidityNode\n";
} catch (\Jackillll\Tron\Exception\TronException $e) {
    echo "错误: " . $e->getMessage() . "\n";
} catch (\Exception $e) {
    echo "系统错误: " . $e->getMessage() . "\n";
}

echo "\n注意: 请将 'your-api-key-here' 替换为您的真实 TronGrid API Key\n";

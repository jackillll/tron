<?php

include_once __DIR__ . '/../vendor/autoload.php';

use Jackillll\Tron\Tron;
use Jackillll\Tron\TronConfig;
use Jackillll\Tron\Provider\HttpProvider;

echo "基于新配置结构的示例:\n";
echo "================================\n\n";

// 新的配置结构（在实际Laravel项目中，这些值会从config/tron.php读取）
$config = [
    'network' => 'mainnet', // 可以改为 'testnet' 或 'nile'
    'use_solidity' => false, // 改为 true 使用 Solidity 节点
    'timeout' => 30000,
    'headers' => [
        'TRON-PRO-API-KEY' => '25ab81fb-6ee6-4b43-bab7-a67a8a3638f8'
    ],
    'networks' => [
        'mainnet' => [
            'host' => 'https://api.trongrid.io',
            'explorer' => 'https://tronscan.org',
        ],
        'testnet' => [
            'host' => 'https://api.shasta.trongrid.io',
            'explorer' => 'https://shasta.tronscan.org',
        ],
        'nile' => [
            'host' => 'https://nile.trongrid.io',
            'explorer' => 'https://nile.tronscan.org',
        ],
    ]
];

try {
    echo "1. 使用新配置结构创建 Tron 实例:\n";
    echo "网络: " . $config['network'] . "\n";
    echo "使用 Solidity 节点: " . ($config['use_solidity'] ? 'true' : 'false') . "\n";
    echo "API主机: " . $config['networks'][$config['network']]['host'] . "\n";

    // 方法1: 使用 TronConfig 助手类
    echo "\n方法1: 使用 TronConfig::createFromConfig()\n";
    $tron1 = TronConfig::createFromConfig($config);
    $provider1 = $tron1->getManager()->fullNode();
    echo "节点类型: " . $provider1->getNodeType() . "\n";
    echo "连接状态: " . ($provider1->isConnected() ? '已连接' : '未连接') . "\n";

    // 方法2: 使用 TronConfig 简化方法
    echo "\n方法2: 使用 TronConfig::create()\n";
    $tron2 = TronConfig::create($config['network'], $config['use_solidity'], $config['headers']);
    $provider2 = $tron2->getManager()->fullNode();
    echo "节点类型: " . $provider2->getNodeType() . "\n";
    echo "连接状态: " . ($provider2->isConnected() ? '已连接' : '未连接') . "\n";

    // 使用第一个实例进行后续测试
    $tron = $tron1;
    $provider = $provider1;

    // 测试基本功能
    echo "2. 测试基本功能:\n";

    // 查询账户信息
    $testAddress = 'TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t'; // USDT合约地址

    try {
        $account = $tron->getAccount($testAddress);
        echo "账户查询成功\n";
        echo "地址: " . $testAddress . "\n";
        if (isset($account['address'])) {
            echo "账户类型: " . (isset($account['type']) ? $account['type'] : '未知') . "\n";
        }
    } catch (Exception $e) {
        echo "账户查询错误: " . $e->getMessage() . "\n";
    }

    echo "\n3. URL构建测试:\n";
    echo "当前节点类型: " . $provider->getNodeType() . "\n";

    // 模拟不同接口的URL构建
    $testUrls = [
        'wallet/getnowblock',
        'getblockbynum',
        'getnowblock',
        'getaccount'
    ];

    foreach ($testUrls as $url) {
        $fullUrl = $provider->getHost() . '/';
        if ($provider->getNodeType() === 'solidity' && strpos($url, 'wallet/') !== 0) {
            $fullUrl .= 'solidity/';
        }
        $fullUrl .= $url;
        echo "- {$url} -> {$fullUrl}\n";
    }

    echo "\n4. 网络切换测试:\n";
    echo "可用网络: " . implode(', ', TronConfig::getAvailableNetworks()) . "\n";
    
    foreach (['mainnet', 'testnet', 'nile'] as $network) {
        echo "- {$network}: " . TronConfig::getNetworkHost($network) . "\n";
    }

    echo "\n5. 动态创建不同配置的实例:\n";
    
    // 创建 Solidity 节点实例
    $solidityTron = TronConfig::create('mainnet', true, $config['headers']);
    $solidityProvider = $solidityTron->getManager()->fullNode();
    echo "Solidity 节点实例 - 节点类型: " . $solidityProvider->getNodeType() . "\n";
    
    // 创建测试网实例
    $testnetTron = TronConfig::create('testnet', false, $config['headers']);
    $testnetProvider = $testnetTron->getManager()->fullNode();
    echo "测试网实例 - 主机: " . $testnetProvider->getHost() . "\n";
    echo "测试网实例 - 节点类型: " . $testnetProvider->getNodeType() . "\n";

} catch (\Jackillll\Tron\Exception\TronException $e) {
    echo "TRON API 错误: " . $e->getMessage() . "\n";
} catch (\Exception $e) {
    echo "系统错误: " . $e->getMessage() . "\n";
}

echo "\n新配置结构说明:\n";
echo "- network: 指定使用的网络 (mainnet, testnet, nile)\n";
echo "- use_solidity: 布尔值，true 使用 Solidity 节点，false 使用 Full 节点\n";
echo "- networks: 定义各个网络的配置信息\n";
echo "- 在Laravel项目中，可以通过 config('tron.network') 和 config('tron.use_solidity') 获取配置\n";
echo "- 环境变量: TRON_NETWORK, TRON_USE_SOLIDITY\n";
echo "- 当前使用的API密钥: " . $config['headers']['TRON-PRO-API-KEY'] . "\n";

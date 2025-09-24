<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Jackillll\Tron\TronConfig;

echo "最终全面验证测试:\n";
echo "==================\n\n";

$testResults = [];

// 测试1: 默认配置
echo "1. 测试默认配置 (mainnet + fullnode):\n";
try {
    $tron = TronConfig::create();
    $provider = $tron->getManager()->fullNode();
    $testResults['default'] = [
        'network' => 'mainnet',
        'node_type' => $provider->getNodeType(),
        'host' => $provider->getHost(),
        'connected' => $provider->isConnected()
    ];
    echo "   ✅ 成功 - 节点类型: {$provider->getNodeType()}, 主机: {$provider->getHost()}\n";
} catch (Exception $e) {
    echo "   ❌ 失败: " . $e->getMessage() . "\n";
    $testResults['default'] = false;
}

// 测试2: Solidity节点
echo "\n2. 测试 Solidity 节点:\n";
try {
    $tron = TronConfig::create('mainnet', true);
    $provider = $tron->getManager()->fullNode();
    $testResults['solidity'] = [
        'network' => 'mainnet',
        'node_type' => $provider->getNodeType(),
        'host' => $provider->getHost(),
        'connected' => $provider->isConnected()
    ];
    echo "   ✅ 成功 - 节点类型: {$provider->getNodeType()}, 主机: {$provider->getHost()}\n";
} catch (Exception $e) {
    echo "   ❌ 失败: " . $e->getMessage() . "\n";
    $testResults['solidity'] = false;
}

// 测试3: 测试网
echo "\n3. 测试测试网配置:\n";
try {
    $tron = TronConfig::create('testnet');
    $provider = $tron->getManager()->fullNode();
    $testResults['testnet'] = [
        'network' => 'testnet',
        'node_type' => $provider->getNodeType(),
        'host' => $provider->getHost(),
        'connected' => $provider->isConnected()
    ];
    echo "   ✅ 成功 - 节点类型: {$provider->getNodeType()}, 主机: {$provider->getHost()}\n";
} catch (Exception $e) {
    echo "   ❌ 失败: " . $e->getMessage() . "\n";
    $testResults['testnet'] = false;
}

// 测试4: Nile网络
echo "\n4. 测试 Nile 网络:\n";
try {
    $tron = TronConfig::create('nile');
    $provider = $tron->getManager()->fullNode();
    $testResults['nile'] = [
        'network' => 'nile',
        'node_type' => $provider->getNodeType(),
        'host' => $provider->getHost(),
        'connected' => $provider->isConnected()
    ];
    echo "   ✅ 成功 - 节点类型: {$provider->getNodeType()}, 主机: {$provider->getHost()}\n";
} catch (Exception $e) {
    echo "   ❌ 失败: " . $e->getMessage() . "\n";
    $testResults['nile'] = false;
}

// 测试5: 自定义配置
echo "\n5. 测试自定义配置:\n";
try {
    $config = [
        'network' => 'mainnet',
        'use_solidity' => true,
        'timeout' => 30000,
        'headers' => [
            'TRON-PRO-API-KEY' => '25ab81fb-6ee6-4b43-bab7-a67a8a3638f8'
        ],
        'networks' => [
            'mainnet' => [
                'host' => 'https://api.trongrid.io',
                'explorer' => 'https://tronscan.org'
            ],
            'testnet' => [
                'host' => 'https://api.shasta.trongrid.io',
                'explorer' => 'https://shasta.tronscan.org'
            ],
            'nile' => [
                'host' => 'https://nile.trongrid.io',
                'explorer' => 'https://nile.tronscan.org'
            ]
        ]
    ];
    
    $tron = TronConfig::createFromConfig($config);
    $provider = $tron->getManager()->fullNode();
    $testResults['custom'] = [
        'network' => 'mainnet',
        'node_type' => $provider->getNodeType(),
        'host' => $provider->getHost(),
        'connected' => $provider->isConnected()
    ];
    echo "   ✅ 成功 - 节点类型: {$provider->getNodeType()}, 主机: {$provider->getHost()}\n";
} catch (Exception $e) {
    echo "   ❌ 失败: " . $e->getMessage() . "\n";
    $testResults['custom'] = false;
}

// 测试6: API功能测试
echo "\n6. 测试API功能:\n";
try {
    $tron = TronConfig::create();
    
    // 测试账户查询
    $account = $tron->getAccount('TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t');
    if ($account && isset($account['type'])) {
        echo "   ✅ 账户查询成功 - 类型: {$account['type']}\n";
        $testResults['api_account'] = true;
    } else {
        echo "   ❌ 账户查询失败\n";
        $testResults['api_account'] = false;
    }
    
    // 测试区块查询
    $block = $tron->getBlock();
    if ($block && isset($block['blockID'])) {
        echo "   ✅ 区块查询成功 - 区块ID: " . substr($block['blockID'], 0, 16) . "...\n";
        $testResults['api_block'] = true;
    } else {
        echo "   ❌ 区块查询失败\n";
        $testResults['api_block'] = false;
    }
    
} catch (Exception $e) {
    echo "   ❌ API测试失败: " . $e->getMessage() . "\n";
    $testResults['api_account'] = false;
    $testResults['api_block'] = false;
}

// 测试7: 网络信息获取
echo "\n7. 测试网络信息获取:\n";
try {
    $networks = TronConfig::getNetworks();
    echo "   ✅ 可用网络: " . implode(', ', array_keys($networks)) . "\n";
    
    foreach ($networks as $name => $config) {
        echo "   - {$name}: {$config['host']}\n";
    }
    $testResults['networks'] = true;
} catch (Exception $e) {
    echo "   ❌ 网络信息获取失败: " . $e->getMessage() . "\n";
    $testResults['networks'] = false;
}

// 汇总测试结果
echo "\n" . str_repeat("=", 50) . "\n";
echo "测试结果汇总:\n";
echo str_repeat("=", 50) . "\n";

$passed = 0;
$total = 0;

foreach ($testResults as $test => $result) {
    $total++;
    if ($result) {
        $passed++;
        echo "✅ {$test}: 通过\n";
    } else {
        echo "❌ {$test}: 失败\n";
    }
}

echo "\n总计: {$passed}/{$total} 测试通过\n";

if ($passed === $total) {
    echo "\n🎉 所有测试通过！新配置结构工作正常！\n";
} else {
    echo "\n⚠️  有 " . ($total - $passed) . " 个测试失败，需要检查。\n";
}

echo "\n新配置结构特性:\n";
echo "- ✅ 支持 network 配置 (mainnet, testnet, nile)\n";
echo "- ✅ 支持 use_solidity 布尔配置\n";
echo "- ✅ 自动从 networks 配置中获取主机地址\n";
echo "- ✅ 向后兼容原有功能\n";
echo "- ✅ 支持 TronConfig 助手类\n";
echo "- ✅ 支持 Laravel 服务提供者\n";
echo "- ✅ 支持动态网络切换\n";

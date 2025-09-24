<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Jackillll\Tron\Tron;
use Jackillll\Tron\Provider\HttpProvider;
use Jackillll\Tron\TronConfig;

echo "=== Laravel Tron 包综合验证测试 ===\n\n";

$testsPassed = 0;
$totalTests = 0;

function runTest($testName, $testFunction)
{
    global $testsPassed, $totalTests;
    $totalTests++;

    echo "测试 {$totalTests}: {$testName}\n";

    try {
        $result = $testFunction();
        if ($result) {
            echo "   ✓ 通过\n\n";
            $testsPassed++;
        } else {
            echo "   ✗ 失败\n\n";
        }
    } catch (Exception $e) {
        echo "   ✗ 异常: " . $e->getMessage() . "\n\n";
    }
}

// 测试1: HttpProvider 基本功能
runTest("HttpProvider 基本功能", function () {
    $provider = new HttpProvider('https://api.trongrid.io');
    return $provider->getHost() === 'https://api.trongrid.io' &&
        $provider->getNodeType() === 'fullnode';
});

// 测试2: HttpProvider 工厂方法
runTest("HttpProvider 工厂方法", function () {
    $mainnet = HttpProvider::mainnet();
    $testnet = HttpProvider::testnet();
    $nile = HttpProvider::nile();

    return $mainnet->getHost() === 'https://api.trongrid.io' &&
        $testnet->getHost() === 'https://api.shasta.trongrid.io' &&
        $nile->getHost() === 'https://nile.trongrid.io';
});

// 测试3: HttpProvider 配置数组构造
runTest("HttpProvider 配置数组构造", function () {
    $provider = new HttpProvider([
        'host' => 'https://api.trongrid.io',
        'nodeType' => 'solidity',
        'timeout' => 60,
        'headers' => ['test' => 'value']
    ]);

    return $provider->getHost() === 'https://api.trongrid.io' &&
        $provider->getNodeType() === 'solidity' &&
        $provider->getTimeout() === 60 &&
        count($provider->getHeaders()) === 1;
});

// 测试4: TronConfig 默认配置
runTest("TronConfig 默认配置", function () {
    $tron = TronConfig::create();
    $provider = $tron->getManager()->fullNode();

    return $provider instanceof HttpProvider &&
        $provider->getHost() === 'https://api.trongrid.io' &&
        $provider->getNodeType() === 'fullnode';
});

// 测试5: TronConfig 网络配置
runTest("TronConfig 网络配置", function () {
    $tronTestnet = TronConfig::create('testnet');
    $tronNile = TronConfig::create('nile');

    $testnetProvider = $tronTestnet->getManager()->fullNode();
    $nileProvider = $tronNile->getManager()->fullNode();

    return $testnetProvider->getHost() === 'https://api.shasta.trongrid.io' &&
        $nileProvider->getHost() === 'https://nile.trongrid.io';
});

// 测试6: TronConfig Solidity节点
runTest("TronConfig Solidity节点", function () {
    $tron = TronConfig::create('mainnet', true); // useSolidity = true
    $provider = $tron->getManager()->solidityNode();

    return $provider instanceof HttpProvider &&
        $provider->getNodeType() === 'solidity';
});

// 测试7: TronConfig 自定义配置
runTest("TronConfig 自定义配置", function () {
    $customConfig = [
        'network' => 'mainnet',
        'timeout' => 15000,
        'headers' => ['X-Custom' => 'test'],
        'networks' => [
            'mainnet' => ['host' => 'https://custom.tron.network']
        ]
    ];

    $tron = TronConfig::createFromConfig($customConfig);
    $provider = $tron->getManager()->fullNode();

    return $provider->getHost() === 'https://custom.tron.network' &&
        $provider->getTimeout() === 15000;
});

// 测试8: 网络连接测试
runTest("网络连接测试", function () {
    $provider = HttpProvider::mainnet();
    return $provider->isConnected();
});

// 测试9: API 功能测试 - 获取账户信息
runTest("API 功能测试 - 获取账户信息", function () {
    $tron = TronConfig::create();

    try {
        $account = $tron->getAccount('TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t'); // USDT contract
        return is_array($account) && isset($account['address']);
    } catch (Exception $e) {
        return false; // 网络问题时返回false
    }
});

// 测试10: API 功能测试 - 获取最新区块
runTest("API 功能测试 - 获取最新区块", function () {
    $tron = TronConfig::create();
    try {
        $block = $tron->getCurrentBlock();
        return is_array($block) && isset($block['blockID']);
    } catch (Exception $e) {
        return false; // 网络问题时返回false
    }
});

// 测试11: 网络信息获取
runTest("网络信息获取", function () {
    $networks = TronConfig::getNetworks();
    return is_array($networks) &&
        isset($networks['mainnet']) &&
        isset($networks['testnet']) &&
        isset($networks['nile']);
});

// 测试12: 向后兼容性测试
runTest("向后兼容性测试", function () {
    $provider = new HttpProvider('https://api.trongrid.io');
    $provider->setStatusPage('test'); // 已弃用但应该仍然工作
    return $provider instanceof HttpProvider;
});

// 输出测试结果
echo "=== 测试结果 ===\n";
echo "通过: {$testsPassed}/{$totalTests}\n";

if ($testsPassed === $totalTests) {
    echo "🎉 所有测试通过! Laravel Tron 包和 HttpProvider 优化成功!\n";
    exit(0);
} else {
    echo "❌ 有 " . ($totalTests - $testsPassed) . " 个测试失败\n";
    exit(1);
}

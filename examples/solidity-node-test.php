<?php

include_once __DIR__ . '/../vendor/autoload.php';

use Jackillll\Tron\Tron;
use Jackillll\Tron\Provider\HttpProvider;

echo "SolidityNode 功能专项测试:\n";
echo "==========================\n\n";

// 使用真实的 TronGrid API Key
$headers = [
    'TRON-PRO-API-KEY' => '25ab81fb-6ee6-4b43-bab7-a67a8a3638f8'
];

try {
    // 创建 SolidityNode 提供者
    $solidityProvider = new HttpProvider('https://api.trongrid.io', 30000, false, false, $headers, '/', 'solidity');
    $tronSolidity = new Tron($solidityProvider);

    echo "1. SolidityNode 基本信息:\n";
    echo "节点类型: " . $solidityProvider->getNodeType() . "\n";
    echo "连接状态: " . ($solidityProvider->isConnected() ? '已连接' : '未连接') . "\n\n";

    // 测试获取最新区块（通过 solidity 节点）
    echo "2. 获取最新区块信息 (通过 SolidityNode):\n";
    try {
        $latestBlock = $tronSolidity->getLatestBlocks(1);
        if (!empty($latestBlock)) {
            $block = $latestBlock[0];
            echo "区块号: " . $block['block_header']['raw_data']['number'] . "\n";
            echo "区块哈希: " . $block['blockID'] . "\n";
            echo "时间戳: " . $block['block_header']['raw_data']['timestamp'] . "\n";
            echo "交易数量: " . (isset($block['transactions']) ? count($block['transactions']) : 0) . "\n";
        }
    } catch (Exception $e) {
        echo "获取区块信息错误: " . $e->getMessage() . "\n";
    }

    echo "\n3. 测试智能合约查询 (USDT合约):\n";
    $usdtContractAddress = 'TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t';

    try {
        // 获取合约信息
        $contract = $tronSolidity->contract($usdtContractAddress);
        if ($contract) {
            echo "合约地址: " . $usdtContractAddress . "\n";
            echo "合约名称: " . $contract->name() . "\n";
            echo "合约符号: " . $contract->symbol() . "\n";
            echo "小数位数: " . $contract->decimals() . "\n";
        }
    } catch (Exception $e) {
        echo "合约查询错误: " . $e->getMessage() . "\n";
    }

    echo "\n4. 测试账户信息查询:\n";
    $testAddress = 'TLPuze8b3iKEJgdbP18yF4ZcziDjbf5hgs'; // 一个测试地址

    try {
        $account = $tronSolidity->getAccount($testAddress);
        if ($account && isset($account['address'])) {
            echo "地址: " . $testAddress . "\n";
            echo "余额: " . (isset($account['balance']) ? $tronSolidity->fromTron($account['balance']) : '0') . " TRX\n";
            echo "账户类型: " . (isset($account['type']) ? $account['type'] : '普通账户') . "\n";
        } else {
            echo "账户不存在或无余额\n";
        }
    } catch (Exception $e) {
        echo "账户查询错误: " . $e->getMessage() . "\n";
    }

    echo "\n5. URL 构建验证:\n";
    $testApis = [
        'getaccount',
        'getcontract',
        'getblockbynum',
        'gettransactionbyid',
        'wallet/getnowblock'
    ];

    foreach ($testApis as $api) {
        $fullUrl = $solidityProvider->getHost() . '/';
        if ($solidityProvider->getNodeType() === 'solidity' && strpos($api, 'wallet/') !== 0) {
            $fullUrl .= 'solidity/';
        }
        $fullUrl .= $api;
        echo "- {$api} -> {$fullUrl}\n";
    }

    echo "\n6. 与 FullNode 的对比测试:\n";

    // 创建 FullNode 进行对比
    $fullNodeProvider = new HttpProvider('https://api.trongrid.io', 30000, false, false, $headers, '/', 'fullnode');
    $tronFullNode = new Tron($fullNodeProvider);

    echo "FullNode 连接状态: " . ($fullNodeProvider->isConnected() ? '已连接' : '未连接') . "\n";
    echo "SolidityNode 连接状态: " . ($solidityProvider->isConnected() ? '已连接' : '未连接') . "\n";

    // 比较最新区块号
    try {
        $fullNodeBlocks = $tronFullNode->getLatestBlocks(1);
        $solidityBlocks = $tronSolidity->getLatestBlocks(1);

        if (!empty($fullNodeBlocks) && !empty($solidityBlocks)) {
            $fullNodeBlockNum = $fullNodeBlocks[0]['block_header']['raw_data']['number'];
            $solidityBlockNum = $solidityBlocks[0]['block_header']['raw_data']['number'];

            echo "FullNode 最新区块: " . $fullNodeBlockNum . "\n";
            echo "SolidityNode 最新区块: " . $solidityBlockNum . "\n";
            echo "区块差异: " . ($fullNodeBlockNum - $solidityBlockNum) . " 个区块\n";
        }
    } catch (Exception $e) {
        echo "区块对比错误: " . $e->getMessage() . "\n";
    }
} catch (\Jackillll\Tron\Exception\TronException $e) {
    echo "TRON API 错误: " . $e->getMessage() . "\n";
} catch (\Exception $e) {
    echo "系统错误: " . $e->getMessage() . "\n";
}

echo "\n测试总结:\n";
echo "- SolidityNode 主要用于查询已确认的历史数据\n";
echo "- 数据相比 FullNode 可能有几个区块的延迟，但更稳定\n";
echo "- 适合用于智能合约调用、历史交易查询等场景\n";
echo "- API 请求会自动添加 'solidity/' 前缀（除了 wallet 接口）\n";

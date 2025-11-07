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
    $tron = new Tron($httpProvider);

    echo "智能合约查询示例 (使用Solidity节点):\n";
    echo "节点类型: " . $httpProvider->getNodeType() . "\n";
    $connectionStatus = $tron->isConnected();
    echo "连接状态: " . (isset($connectionStatus['fullNode']) && $connectionStatus['fullNode'] ? '已连接' : '未连接') . "\n\n";

    $contract = $tron->contract('TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t');  // Tether USDT https://tronscan.org/#/token20/TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t

    echo "正在查询USDT合约信息...\n";

    // Data
    echo "合约名称: " . $contract->name() . "\n";
    echo "合约符号: " . $contract->symbol() . "\n";
    echo "小数位数: " . $contract->decimals() . "\n";
    echo "总供应量: " . $contract->totalSupply() . "\n";

    // 查询一些地址的USDT余额
    $testAddresses = [
        'TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t', // 合约地址本身
        'TLa2f6VPqDgRE67v1736s7bJ8Ray5wYjU7', // 测试地址1
        'TAUN6FwrnwwmaEqYcckffC7wYmbaS6cBiX'  // 测试地址2
    ];

    echo "\n查询USDT余额:\n";
    foreach ($testAddresses as $address) {
        try {
            $balance = $contract->balanceOf($address);
            echo "地址 " . $address . " 的USDT余额: " . $balance . "\n";
        } catch (Exception $e) {
            echo "查询地址 " . $address . " 余额时出错: " . $e->getMessage() . "\n";
        }
    }

    // 测试其他TRC20合约
    echo "\n测试其他TRC20合约:\n";
    try {
        // JST (JUST) 合约
        $jstContract = $tron->contract('TCFLL5dx5ZJdKnWuesXxi1VPwjLVmWZZy9');
        echo "JST合约名称: " . $jstContract->name() . "\n";
        echo "JST合约符号: " . $jstContract->symbol() . "\n";
        echo "JST小数位数: " . $jstContract->decimals() . "\n";
    } catch (Exception $e) {
        echo "查询JST合约时出错: " . $e->getMessage() . "\n";
    }

    //echo  $contract->transfer('to', 'amount', 'from');

} catch (\Jackillll\Tron\Exception\TronException $e) {
    echo "错误: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "错误: " . $e->getMessage() . "\n";
}

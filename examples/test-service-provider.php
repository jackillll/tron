<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Jackillll\Tron\TronServiceProvider;
use Illuminate\Container\Container;
use Illuminate\Config\Repository;

echo "测试 TronServiceProvider 新配置结构:\n";
echo "=====================================\n\n";

try {
    // 模拟 Laravel 容器和配置
    $container = new Container();
    
    // 设置配置
    $config = new Repository([
        'tron' => [
            'network' => 'mainnet',
            'use_solidity' => false,
            'timeout' => 30000,
            'headers' => [
                'TRON-PRO-API-KEY' => '25ab81fb-6ee6-4b43-bab7-a67a8a3638f8'
            ],
            'private_key' => '',
            'address' => '',
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
        ]
    ]);
    
    $container->instance('config', $config);
    
    // 注册服务提供者
    $provider = new TronServiceProvider($container);
    $provider->register();
    
    // 获取 Tron 实例
    $tron = $container->make('tron');
    
    echo "1. 服务提供者注册成功\n";
    echo "2. Tron 实例创建成功\n";
    
    // 测试基本功能
    $provider = $tron->getManager()->fullNode();
    echo "3. 节点类型: " . $provider->getNodeType() . "\n";
    echo "4. 主机地址: " . $provider->getHost() . "\n";
    echo "5. 连接状态: " . ($provider->isConnected() ? '已连接' : '未连接') . "\n";
    
    // 测试账户查询
    $account = $tron->getAccount('TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t');
    if ($account && isset($account['type'])) {
        echo "6. 账户查询成功 - 类型: " . $account['type'] . "\n";
    } else {
        echo "6. 账户查询失败\n";
    }
    
    echo "\n✅ TronServiceProvider 新配置结构测试通过!\n";
    
} catch (Exception $e) {
    echo "❌ 错误: " . $e->getMessage() . "\n";
    echo "文件: " . $e->getFile() . "\n";
    echo "行号: " . $e->getLine() . "\n";
}

<?php
include_once __DIR__ . '/../vendor/autoload.php';

use Jackillll\Tron\Tron;

// 使用提供的API token
$headers = [
    'TRON-PRO-API-KEY' => '25ab81fb-6ee6-4b43-bab7-a67a8a3638f8'
];

$httpProvider = new \Jackillll\Tron\Provider\HttpProvider('https://api.trongrid.io', 30000, false, false, $headers);

try {
    $tron = new Tron($httpProvider);

    echo "通用功能示例:\n";
    echo "注意: 以下代码仅为演示，需要真实的地址和私钥才能执行\n\n";

    /**
     * check multi balances
     *
     * $address = [
     *   ['address', 'isFromTron'],
     *   ['address', 'isFromTron'],
     * ]
     */

    echo "1. 批量查询余额示例:\n";
    $addresses = [
        ['TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t', true], // USDT合约地址
        ['TT67rPNwgmpeimvHUMVzFfKsjL9GZ1wGw8', true], // 示例地址
    ];

    echo "正在查询多个地址的余额...\n";
    $check = $tron->balances($addresses);
    echo "余额查询结果: " . json_encode($check, JSON_PRETTY_PRINT) . "\n\n";

    /**
     * send one to many
     *
     * $address = [
     *   ['to address', 'amount float'],
     *   ['to address', 'amount float'],
     * ]
     *
     * toAddress format: TRWBqiqoFZysoAeyR1J35ibuyc8EvhUAoY
     */

    echo "2. 一对多发送示例:\n";
    $toArray = [
        ['TRWBqiqoFZysoAeyR1J35ibuyc8EvhUAoY', 0.1],
        ['TT67rPNwgmpeimvHUMVzFfKsjL9GZ1wGw8', 0.2],
    ];

    echo "要执行一对多发送，请:\n";
    echo "1. 设置私钥: \$tron->setPrivateKey('your_private_key');\n";
    echo "2. 调用: \$tron->sendOneToMany('from_address', \$toArray);\n";
    echo "3. 确保有足够的TRX余额支付所有交易\n";

    // 注释掉实际的发送代码，因为需要私钥
    /*
    $tron->setPrivateKey('your_private_key_here');
    $send = $tron->sendOneToMany('from_address', $toArray);
    echo "发送结果: " . json_encode($send, JSON_PRETTY_PRINT) . "\n";
    */
} catch (\Jackillll\Tron\Exception\TronException $e) {
    echo "错误: " . $e->getMessage() . "\n";
}

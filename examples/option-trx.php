<?php
include_once __DIR__ . '/../vendor/autoload.php';

// 使用提供的API token
$headers = [
    'TRON-PRO-API-KEY' => '25ab81fb-6ee6-4b43-bab7-a67a8a3638f8'
];

$httpProvider = new \Jackillll\Tron\Provider\HttpProvider('https://api.trongrid.io', 30000, false, false, $headers);

try {
    $tron = new \Jackillll\Tron\Tron($httpProvider);

    echo "TRX发送选项示例:\n";
    echo "注意: 以下代码仅为演示，需要真实的地址和私钥才能执行\n\n";

    // 示例地址（请替换为真实地址）
    $toAddress = 'TT67rPNwgmpeimvHUMVzFfKsjL9GZ1wGw8';
    $amount = 0.1;

    echo "发送到地址: " . $toAddress . "\n";
    echo "发送金额: " . $amount . " TRX\n\n";

    echo "可用的发送方法:\n";
    echo "1. sendTransaction(to, amount, message) - 发送带消息的交易\n";
    echo "2. send(to, amount) - 简单发送\n";
    echo "3. sendTrx(to, amount) - 发送TRX\n\n";

    // 注释掉实际的发送代码，因为需要私钥
    /*
    //option 1
    $result1 = $tron->sendTransaction($toAddress, $amount, 'hello');
    
    //option 2
    $result2 = $tron->send($toAddress, $amount);
    
    //option 3
    $result3 = $tron->sendTrx($toAddress, $amount);
    */

    echo "要执行实际交易，请:\n";
    echo "1. 设置发送方地址和私钥\n";
    echo "2. 取消注释上述代码\n";
    echo "3. 确保有足够的TRX余额\n";
} catch (\Jackillll\Tron\Exception\TronException $e) {
    echo "错误: " . $e->getMessage() . "\n";
}

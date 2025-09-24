<?php
include_once __DIR__ . '/../vendor/autoload.php';

// 使用提供的API token
$headers = [
    'TRON-PRO-API-KEY' => '25ab81fb-6ee6-4b43-bab7-a67a8a3638f8'
];

$httpProvider = new \Jackillll\Tron\Provider\HttpProvider('https://api.trongrid.io', 30000, false, false, $headers);

try {
    $tron = new \Jackillll\Tron\Tron($httpProvider);
} catch (\Jackillll\Tron\Exception\TronException $e) {
    exit($e->getMessage());
}

// 注意：这里需要真实的地址和私钥才能发送交易
// 为了演示目的，我们只显示如何设置，但不实际发送
echo "发送交易示例 (需要真实的地址和私钥)\n";
echo "使用方法:\n";
echo "\$tron->setAddress('your_address');\n";
echo "\$tron->setPrivateKey('your_private_key');\n";
echo "\$transfer = \$tron->send('ToAddress', 1);\n";

// 如果你有真实的地址和私钥，可以取消注释下面的代码
/*
$tron->setAddress('your_address_here');
$tron->setPrivateKey('your_private_key_here');

try {
    $transfer = $tron->send('ToAddress', 1);
    var_dump($transfer);
} catch (\Jackillll\Tron\Exception\TronException $e) {
    die($e->getMessage());
}
*/

<?php
include_once __DIR__ . '/../vendor/autoload.php';

// 使用提供的API token
$headers = [
    'TRON-PRO-API-KEY' => '25ab81fb-6ee6-4b43-bab7-a67a8a3638f8'
];

$httpProvider = new \Jackillll\Tron\Provider\HttpProvider('https://api.trongrid.io', 30000, false, false, $headers);

try {
    $tron = new \Jackillll\Tron\Tron($httpProvider);

    echo "地址格式转换示例:\n";

    $address = 'TT67rPNwgmpeimvHUMVzFfKsjL9GZ1wGw8';
    $hexAddress = $tron->toHex($address);
    echo "Base58地址: " . $address . "\n";
    echo "转换为Hex: " . $hexAddress . "\n";

    $convertedBack = $tron->fromHex($hexAddress);
    echo "Hex转回Base58: " . $convertedBack . "\n";
} catch (\Jackillll\Tron\Exception\TronException $e) {
    echo "错误: " . $e->getMessage() . "\n";
}

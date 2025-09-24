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

echo "检查连接状态...\n";
$isConnected = $tron->isConnected();
echo "连接状态: " . ($isConnected ? "已连接" : "未连接") . "\n";

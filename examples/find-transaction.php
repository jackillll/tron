<?php
include_once __DIR__ . '/../vendor/autoload.php';

// 使用提供的API token
$headers = [
    'TRON-PRO-API-KEY' => '25ab81fb-6ee6-4b43-bab7-a67a8a3638f8'
];

$httpProvider = new \Jackillll\Tron\Provider\HttpProvider('https://api.trongrid.io', 30000, false, false, $headers);

try {
    $tron = new \Jackillll\Tron\Tron($httpProvider);

    echo "查询交易详情示例:\n";

    // 使用一个真实的交易ID进行测试
    $txId = 'b4b3f8c8e8f8c8e8f8c8e8f8c8e8f8c8e8f8c8e8f8c8e8f8c8e8f8c8e8f8c8e8'; // 示例交易ID，请替换为真实的交易ID
    echo "正在查询交易ID: " . $txId . "\n";

    $detail = $tron->getTransaction($txId);

    if ($detail) {
        echo "交易查询成功!\n";
        echo "交易详情: " . json_encode($detail, JSON_PRETTY_PRINT) . "\n";
    } else {
        echo "未找到该交易或交易ID无效\n";
    }
} catch (\Jackillll\Tron\Exception\TronException $e) {
    echo "错误: " . $e->getMessage() . "\n";
}

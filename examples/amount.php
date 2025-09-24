<?php
include_once __DIR__ . '/../vendor/autoload.php';

// 使用提供的API token
$headers = [
    'TRON-PRO-API-KEY' => '25ab81fb-6ee6-4b43-bab7-a67a8a3638f8'
];

$httpProvider = new \Jackillll\Tron\Provider\HttpProvider('https://api.trongrid.io', 30000, false, false, $headers);

try {
    $tron = new \Jackillll\Tron\Tron($httpProvider);

    echo "TRX金额转换示例:\n";

    /**
     * WARNING: When sending funds, you should not specify these parameters
     *
     * P.S: In the process of payment are automatically converted
     */

    $from = $tron->toTron(1.15); // 将1.15 TRX转换为SUN
    $to = $tron->fromTron(11500000); // 将11500000 SUN转换为TRX

    echo "1.15 TRX = " . $from . " SUN\n";
    echo "11500000 SUN = " . $to . " TRX\n";
} catch (\Jackillll\Tron\Exception\TronException $e) {
    echo "错误: " . $e->getMessage() . "\n";
}

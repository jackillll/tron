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

echo "TransactionBuilder示例 (需要真实的地址和私钥)\n";
echo "使用方法:\n";
echo "1. 创建交易: \$transaction = \$tron->getTransactionBuilder()->sendTrx('to', 2, 'fromAddress');\n";
echo "2. 签名交易: \$signedTransaction = \$tron->signTransaction(\$transaction);\n";
echo "3. 发送交易: \$response = \$tron->sendRawTransaction(\$signedTransaction);\n";

// 如果你有真实的地址和私钥，可以取消注释下面的代码
/*
try {
    $transaction = $tron->getTransactionBuilder()->sendTrx('to_address', 2, 'from_address');
    $signedTransaction = $tron->signTransaction($transaction);
    $response = $tron->sendRawTransaction($signedTransaction);
    var_dump($response);
} catch (\Jackillll\Tron\Exception\TronException $e) {
    die($e->getMessage());
}
*/

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

    // 直接调用API测试
    $result = $tron->getManager()->request('wallet/triggerconstantcontract', [
        'contract_address' => $tron->address2HexString('TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t'),
        'function_selector' => 'name()',
        'parameter' => '',
        'owner_address' => '410000000000000000000000000000000000000000',
    ]);

    echo "API响应:\n";
    print_r($result);

    if (isset($result['constant_result'][0])) {
        echo "\n尝试解码结果:\n";

        // 手动解码字符串
        $hexResult = $result['constant_result'][0];
        echo "原始十六进制: " . $hexResult . "\n";

        // 使用我们的Ethabi解码器
        $eth_abi = new \Jackillll\Tron\Support\Ethabi();
        $func_abi = [
            'name' => 'name',
            'outputs' => [
                ['name' => '', 'type' => 'string']
            ]
        ];

        try {
            $decoded = $eth_abi->decodeParameters($func_abi, $hexResult);
            echo "解码结果: ";
            print_r($decoded);
        } catch (Exception $e) {
            echo "解码错误: " . $e->getMessage() . "\n";
        }
    }
} catch (Exception $e) {
    echo "错误: " . $e->getMessage() . "\n";
    echo "堆栈跟踪:\n";
    echo $e->getTraceAsString() . "\n";
}

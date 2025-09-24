<?php
include_once __DIR__ . '/../vendor/autoload.php';

// 使用提供的API token
$headers = [
    'TRON-PRO-API-KEY' => '25ab81fb-6ee6-4b43-bab7-a67a8a3638f8'
];

$httpProvider = new \Jackillll\Tron\Provider\HttpProvider('https://api.trongrid.io', 30000, false, false, $headers);

try {
    $tron = new \Jackillll\Tron\Tron($httpProvider);

    echo "合约余额查询示例:\n";

    // 使用一个真实的地址进行测试
    $testAddress = 'TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t'; // USDT合约地址
    echo "正在查询地址的合约余额: " . $testAddress . "\n\n";

    // 注意: contractbalance方法可能不存在，这里使用替代方法
    // 如果需要查询特定合约的余额，可以使用TRC20Contract

    try {
        // 查询USDT余额作为示例
        $contract = $tron->contract('TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t');
        $balance = $contract->balanceOf('TT67rPNwgmpeimvHUMVzFfKsjL9GZ1wGw8');
        $name = $contract->name();
        $symbol = $contract->symbol();
        $decimals = $contract->decimals();

        echo "合约信息:\n";
        echo "名称: " . $name . "\n";
        echo "符号: " . $symbol . "\n";
        echo "小数位: " . $decimals . "\n";
        echo "余额: " . $balance . "\n";
    } catch (Exception $e) {
        echo "查询合约余额时出错: " . $e->getMessage() . "\n";
        echo "注意: contractbalance方法可能不可用，请使用TRC20Contract类查询特定代币余额\n";
    }
} catch (\Jackillll\Tron\Exception\TronException $e) {
    echo "错误: " . $e->getMessage() . "\n";
}

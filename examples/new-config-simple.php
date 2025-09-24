<?php

/**
 * TRON New Configuration Structure Example
 *
 * This example demonstrates the new simplified configuration structure:
 * - Using TronConfig helper class for easy setup
 * - Network selection (mainnet, testnet, nile)
 * - Node type selection (fullnode vs solidity)
 * - Dynamic configuration switching
 * - Comparison between different configuration methods
 *
 * @package    Jackillll\Tron
 * @author     Jackillll <jackjack75383973@gmail.com>
 * @version    2.0.0
 * @since      2.0.0
 */

include_once __DIR__ . '/../vendor/autoload.php';

use Jackillll\Tron\TronConfig;

echo "新配置结构简单示例:\n";
echo "====================\n\n";

try {
    // 1. 使用默认配置（主网 + Full节点）
    echo "1. 默认配置 (主网 + Full节点):\n";
    $tron1 = TronConfig::create();
    $provider1 = $tron1->getManager()->fullNode();
    echo "网络: mainnet\n";
    echo "节点类型: " . $provider1->getNodeType() . "\n";
    echo "主机: " . $provider1->getHost() . "\n\n";

    // 2. 使用 Solidity 节点
    echo "2. 主网 + Solidity节点:\n";
    $tron2 = TronConfig::create('mainnet', true);
    $provider2 = $tron2->getManager()->fullNode();
    echo "网络: mainnet\n";
    echo "节点类型: " . $provider2->getNodeType() . "\n";
    echo "主机: " . $provider2->getHost() . "\n\n";

    // 3. 使用测试网
    echo "3. 测试网 + Full节点:\n";
    $tron3 = TronConfig::create('testnet', false);
    $provider3 = $tron3->getManager()->fullNode();
    echo "网络: testnet\n";
    echo "节点类型: " . $provider3->getNodeType() . "\n";
    echo "主机: " . $provider3->getHost() . "\n\n";

    // 4. 测试基本功能
    echo "4. 测试基本功能 (使用主网 Full节点):\n";
    $testAddress = 'TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t'; // USDT合约地址
    
    $account = $tron1->getAccount($testAddress);
    echo "查询地址: " . $testAddress . "\n";
    if (isset($account['address'])) {
        echo "账户类型: " . (isset($account['type']) ? $account['type'] : '未知') . "\n";
        echo "查询成功!\n";
    } else {
        echo "账户不存在或查询失败\n";
    }

    echo "\n5. 可用网络列表:\n";
    $networks = TronConfig::getAvailableNetworks();
    foreach ($networks as $network) {
        echo "- {$network}: " . TronConfig::getNetworkHost($network) . "\n";
    }

} catch (\Jackillll\Tron\Exception\TronException $e) {
    echo "TRON API 错误: " . $e->getMessage() . "\n";
} catch (\Exception $e) {
    echo "系统错误: " . $e->getMessage() . "\n";
}

echo "\n使用说明:\n";
echo "TronConfig::create(\$network, \$useSolidity, \$headers, \$timeout)\n";
echo "- \$network: 'mainnet', 'testnet', 'nile' (默认: 'mainnet')\n";
echo "- \$useSolidity: true/false (默认: false)\n";
echo "- \$headers: 自定义请求头数组 (默认: [])\n";
echo "- \$timeout: 超时时间毫秒 (默认: 30000)\n";

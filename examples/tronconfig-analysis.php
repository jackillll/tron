<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Jackillll\Tron\Tron;
use Jackillll\Tron\TronConfig;
use Jackillll\Tron\Provider\HttpProvider;

echo "=== TronConfig 类分析：是否可以移除？ ===\n\n";

// ========================================
// 1. 直接使用 Tron 类（原始方式）
// ========================================
echo "1. 直接使用 Tron 类实例化：\n";
echo "代码复杂度：高\n";
echo "配置管理：手动\n";
echo "网络切换：繁琐\n\n";

echo "// 主网配置 - 需要手动创建 HttpProvider\n";
echo '$fullNodeProvider = new HttpProvider([' . "\n";
echo '    "host" => "https://api.trongrid.io",' . "\n";
echo '    "timeout" => 30000,' . "\n";
echo '    "nodeType" => "fullnode"' . "\n";
echo ']);' . "\n";
echo '$tron = new Tron($fullNodeProvider);' . "\n\n";

echo "// 测试网配置 - 需要重新创建 HttpProvider\n";
echo '$testnetProvider = new HttpProvider([' . "\n";
echo '    "host" => "https://api.shasta.trongrid.io",' . "\n";
echo '    "timeout" => 30000,' . "\n";
echo '    "nodeType" => "fullnode"' . "\n";
echo ']);' . "\n";
echo '$testnetTron = new Tron($testnetProvider);' . "\n\n";

echo "// Solidity 节点配置 - 需要明确指定节点类型\n";
echo '$solidityProvider = new HttpProvider([' . "\n";
echo '    "host" => "https://api.trongrid.io",' . "\n";
echo '    "timeout" => 30000,' . "\n";
echo '    "nodeType" => "solidity"' . "\n";
echo ']);' . "\n";
echo '$solidityTron = new Tron(null, $solidityProvider);' . "\n\n";

// ========================================
// 2. 使用 TronConfig 类（简化方式）
// ========================================
echo "2. 使用 TronConfig 类实例化：\n";
echo "代码复杂度：低\n";
echo "配置管理：自动\n";
echo "网络切换：简单\n\n";

echo "// 主网配置 - 一行代码\n";
echo '$tron = TronConfig::create("mainnet");' . "\n\n";

echo "// 测试网配置 - 一行代码\n";
echo '$testnetTron = TronConfig::create("testnet");' . "\n\n";

echo "// Solidity 节点配置 - 一行代码\n";
echo '$solidityTron = TronConfig::create("mainnet", true);' . "\n\n";

echo "// 自定义配置 - 灵活配置\n";
echo '$customTron = TronConfig::createFromConfig([' . "\n";
echo '    "network" => "mainnet",' . "\n";
echo '    "timeout" => 15000,' . "\n";
echo '    "headers" => ["X-Custom" => "value"]' . "\n";
echo ']);' . "\n\n";

// ========================================
// 3. TronConfig 提供的额外功能
// ========================================
echo "3. TronConfig 提供的额外功能：\n\n";

echo "// 获取可用网络列表\n";
$networks = TronConfig::getAvailableNetworks();
echo "可用网络：" . implode(', ', $networks) . "\n\n";

echo "// 获取网络配置信息\n";
$networkConfigs = TronConfig::getNetworks();
foreach ($networkConfigs as $name => $config) {
    echo "网络 {$name}: {$config['host']}\n";
}
echo "\n";

echo "// 获取特定网络的主机地址\n";
echo "主网地址：" . TronConfig::getNetworkHost('mainnet') . "\n";
echo "测试网地址：" . TronConfig::getNetworkHost('testnet') . "\n\n";

// ========================================
// 4. 实际测试对比
// ========================================
echo "4. 实际测试对比：\n\n";

try {
    // 使用 TronConfig 创建实例
    echo "使用 TronConfig 创建主网实例...\n";
    $configTron = TronConfig::create('mainnet');
    $provider1 = $configTron->getManager()->fullNode();
    echo "✓ 成功创建，节点类型：" . $provider1->getNodeType() . "\n";
    echo "✓ 主机地址：" . $provider1->getHost() . "\n\n";

    // 直接使用 Tron 创建实例
    echo "直接使用 Tron 创建主网实例...\n";
    $directProvider = new HttpProvider([
        'host' => 'https://api.trongrid.io',
        'timeout' => 30000,
        'nodeType' => 'fullnode'
    ]);
    $directTron = new Tron($directProvider);
    $provider2 = $directTron->getManager()->fullNode();
    echo "✓ 成功创建，节点类型：" . $provider2->getNodeType() . "\n";
    echo "✓ 主机地址：" . $provider2->getHost() . "\n\n";
} catch (Exception $e) {
    echo "❌ 错误：" . $e->getMessage() . "\n\n";
}

// ========================================
// 5. 分析结论
// ========================================
echo "=== 分析结论 ===\n\n";

echo "TronConfig 类的价值：\n";
echo "✓ 简化了 Tron 实例的创建过程\n";
echo "✓ 提供了预定义的网络配置（mainnet, testnet, nile）\n";
echo "✓ 统一管理网络配置，避免硬编码\n";
echo "✓ 简化了 Solidity 节点的配置\n";
echo "✓ 提供了配置查询和管理功能\n";
echo "✓ 降低了使用门槛，特别是对新手\n\n";

echo "是否可以移除 TronConfig？\n";
echo "技术上：✓ 可以移除，Tron 类可以独立工作\n";
echo "实用性：❌ 不建议移除，会显著增加使用复杂度\n\n";

echo "建议：\n";
echo "• 保留 TronConfig 类作为便利工具\n";
echo "• 对于简单场景，使用 TronConfig 快速创建实例\n";
echo "• 对于复杂场景，可以直接使用 Tron 类进行精细控制\n";
echo "• TronConfig 和 Tron 类可以并存，满足不同需求\n\n";

echo "代码行数对比：\n";
echo "使用 TronConfig：1 行代码\n";
echo "直接使用 Tron：5-8 行代码\n";
echo "复杂度降低：80%\n\n";

echo "=== 测试完成 ===\n";

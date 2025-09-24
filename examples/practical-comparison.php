<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Jackillll\Tron\Tron;
use Jackillll\Tron\TronConfig;
use Jackillll\Tron\Provider\HttpProvider;

echo "=== 实际项目中的使用对比 ===\n\n";

// ========================================
// 场景1：多环境配置
// ========================================
echo "场景1：多环境配置（开发、测试、生产）\n";
echo "----------------------------------------\n\n";

echo "❌ 不使用 TronConfig（复杂方式）：\n";
echo '```php' . "\n";
echo 'class TronService {' . "\n";
echo '    private $tron;' . "\n";
echo '    ' . "\n";
echo '    public function __construct($environment = "production") {' . "\n";
echo '        switch ($environment) {' . "\n";
echo '            case "development":' . "\n";
echo '                $provider = new HttpProvider([' . "\n";
echo '                    "host" => "https://nile.trongrid.io",' . "\n";
echo '                    "timeout" => 30000,' . "\n";
echo '                    "nodeType" => "fullnode"' . "\n";
echo '                ]);' . "\n";
echo '                break;' . "\n";
echo '            case "testing":' . "\n";
echo '                $provider = new HttpProvider([' . "\n";
echo '                    "host" => "https://api.shasta.trongrid.io",' . "\n";
echo '                    "timeout" => 30000,' . "\n";
echo '                    "nodeType" => "fullnode"' . "\n";
echo '                ]);' . "\n";
echo '                break;' . "\n";
echo '            case "production":' . "\n";
echo '                $provider = new HttpProvider([' . "\n";
echo '                    "host" => "https://api.trongrid.io",' . "\n";
echo '                    "timeout" => 30000,' . "\n";
echo '                    "nodeType" => "fullnode"' . "\n";
echo '                ]);' . "\n";
echo '                break;' . "\n";
echo '            default:' . "\n";
echo '                throw new Exception("Unknown environment");' . "\n";
echo '        }' . "\n";
echo '        $this->tron = new Tron($provider);' . "\n";
echo '    }' . "\n";
echo '}' . "\n";
echo '```' . "\n";
echo "代码行数：~25 行\n";
echo "维护难度：高（需要手动维护所有网络配置）\n\n";

echo "✅ 使用 TronConfig（简单方式）：\n";
echo '```php' . "\n";
echo 'class TronService {' . "\n";
echo '    private $tron;' . "\n";
echo '    ' . "\n";
echo '    public function __construct($environment = "production") {' . "\n";
echo '        $networkMap = [' . "\n";
echo '            "development" => "nile",' . "\n";
echo '            "testing" => "testnet",' . "\n";
echo '            "production" => "mainnet"' . "\n";
echo '        ];' . "\n";
echo '        ' . "\n";
echo '        $network = $networkMap[$environment] ?? "mainnet";' . "\n";
echo '        $this->tron = TronConfig::create($network);' . "\n";
echo '    }' . "\n";
echo '}' . "\n";
echo '```' . "\n";
echo "代码行数：~12 行\n";
echo "维护难度：低（网络配置由 TronConfig 管理）\n\n";

// ========================================
// 场景2：Solidity 节点切换
// ========================================
echo "场景2：Solidity 节点切换\n";
echo "----------------------------------------\n\n";

echo "❌ 不使用 TronConfig：\n";
echo '```php' . "\n";
echo 'class ContractService {' . "\n";
echo '    public function readContract($useFullNode = true) {' . "\n";
echo '        if ($useFullNode) {' . "\n";
echo '            $provider = new HttpProvider([' . "\n";
echo '                "host" => "https://api.trongrid.io",' . "\n";
echo '                "nodeType" => "fullnode"' . "\n";
echo '            ]);' . "\n";
echo '            $tron = new Tron($provider);' . "\n";
echo '        } else {' . "\n";
echo '            $solidityProvider = new HttpProvider([' . "\n";
echo '                "host" => "https://api.trongrid.io",' . "\n";
echo '                "nodeType" => "solidity"' . "\n";
echo '            ]);' . "\n";
echo '            $tron = new Tron(null, $solidityProvider);' . "\n";
echo '        }' . "\n";
echo '        // 使用 $tron 进行合约调用' . "\n";
echo '    }' . "\n";
echo '}' . "\n";
echo '```' . "\n\n";

echo "✅ 使用 TronConfig：\n";
echo '```php' . "\n";
echo 'class ContractService {' . "\n";
echo '    public function readContract($useFullNode = true) {' . "\n";
echo '        $tron = TronConfig::create("mainnet", !$useFullNode);' . "\n";
echo '        // 使用 $tron 进行合约调用' . "\n";
echo '    }' . "\n";
echo '}' . "\n";
echo '```' . "\n\n";

// ========================================
// 场景3：配置管理
// ========================================
echo "场景3：配置管理和网络信息查询\n";
echo "----------------------------------------\n\n";

echo "❌ 不使用 TronConfig：\n";
echo "需要自己维护网络配置数组，手动管理所有网络信息\n\n";

echo "✅ 使用 TronConfig：\n";
echo '```php' . "\n";
echo '// 获取所有可用网络' . "\n";
echo '$networks = TronConfig::getAvailableNetworks();' . "\n";
echo '// 获取网络配置' . "\n";
echo '$config = TronConfig::getNetworks();' . "\n";
echo '// 获取特定网络主机' . "\n";
echo '$host = TronConfig::getNetworkHost("mainnet");' . "\n";
echo '```' . "\n\n";

// ========================================
// 实际测试
// ========================================
echo "实际测试：创建不同配置的 Tron 实例\n";
echo "----------------------------------------\n\n";

try {
    // 测试1：主网 FullNode
    echo "1. 创建主网 FullNode...\n";
    $mainnetFull = TronConfig::create('mainnet', false);
    $provider = $mainnetFull->getManager()->fullNode();
    echo "   ✓ 节点类型：{$provider->getNodeType()}\n";
    echo "   ✓ 主机：{$provider->getHost()}\n\n";

    // 测试2：主网 SolidityNode
    echo "2. 创建主网 SolidityNode...\n";
    $mainnetSolidity = TronConfig::create('mainnet', true);
    $solidityProvider = $mainnetSolidity->getManager()->solidityNode();
    echo "   ✓ 节点类型：{$solidityProvider->getNodeType()}\n";
    echo "   ✓ 主机：{$solidityProvider->getHost()}\n\n";

    // 测试3：测试网
    echo "3. 创建测试网实例...\n";
    $testnet = TronConfig::create('testnet');
    $testProvider = $testnet->getManager()->fullNode();
    echo "   ✓ 节点类型：{$testProvider->getNodeType()}\n";
    echo "   ✓ 主机：{$testProvider->getHost()}\n\n";

    // 测试4：自定义配置
    echo "4. 创建自定义配置实例...\n";
    $custom = TronConfig::createFromConfig([
        'network' => 'mainnet',
        'timeout' => 15000,
        'headers' => ['X-API-Key' => 'test-key']
    ]);
    $customProvider = $custom->getManager()->fullNode();
    echo "   ✓ 节点类型：{$customProvider->getNodeType()}\n";
    echo "   ✓ 主机：{$customProvider->getHost()}\n";
    echo "   ✓ 超时：{$customProvider->getTimeout()}ms\n\n";
} catch (Exception $e) {
    echo "❌ 错误：{$e->getMessage()}\n\n";
}

// ========================================
// 总结
// ========================================
echo "=== 总结 ===\n\n";

echo "TronConfig 类的核心价值：\n\n";

echo "1. 🎯 简化 API\n";
echo "   • 将复杂的 HttpProvider 创建过程封装\n";
echo "   • 提供语义化的方法名\n";
echo "   • 减少样板代码\n\n";

echo "2. 📋 配置管理\n";
echo "   • 预定义常用网络配置\n";
echo "   • 统一管理网络信息\n";
echo "   • 避免配置分散和重复\n\n";

echo "3. 🔧 开发体验\n";
echo "   • 降低学习成本\n";
echo "   • 减少配置错误\n";
echo "   • 提高开发效率\n\n";

echo "4. 🏗️ 架构优势\n";
echo "   • 关注点分离\n";
echo "   • 配置与业务逻辑解耦\n";
echo "   • 便于测试和维护\n\n";

echo "结论：\n";
echo "虽然技术上可以移除 TronConfig 类，但这会：\n";
echo "❌ 显著增加代码复杂度\n";
echo "❌ 降低开发效率\n";
echo "❌ 增加配置错误的风险\n";
echo "❌ 影响代码可维护性\n\n";

echo "建议：保留 TronConfig 类，它是一个有价值的便利工具！\n\n";

echo "使用场景建议：\n";
echo "• 🟢 简单场景：使用 TronConfig\n";
echo "• 🟡 复杂场景：可以直接使用 Tron + HttpProvider\n";
echo "• 🔵 混合使用：根据具体需求选择合适的方式\n\n";

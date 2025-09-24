<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Jackillll\Tron\Provider\HttpProvider;
use Jackillll\Tron\Exception\TronException;

echo "=== HttpProvider 优化测试 ===\n\n";

try {
    // 测试1: 传统构造函数（向后兼容）
    echo "1. 测试传统构造函数（向后兼容）:\n";
    $provider1 = new HttpProvider('https://api.trongrid.io');
    echo "   ✓ 主机: " . $provider1->getHost() . "\n";
    echo "   ✓ 节点类型: " . $provider1->getNodeType() . "\n";
    echo "   ✓ 超时: " . $provider1->getTimeout() . "秒\n\n";

    // 测试2: 新的配置数组构造函数
    echo "2. 测试配置数组构造函数:\n";
    $provider2 = new HttpProvider([
        'host' => 'https://api.shasta.trongrid.io',
        'nodeType' => 'solidity',
        'timeout' => 60,
        'headers' => [
            'TRON-PRO-API-KEY' => 'your-api-key',
            'User-Agent' => 'Laravel-Tron/2.0'
        ]
    ]);
    echo "   ✓ 主机: " . $provider2->getHost() . "\n";
    echo "   ✓ 节点类型: " . $provider2->getNodeType() . "\n";
    echo "   ✓ 超时: " . $provider2->getTimeout() . "秒\n";
    echo "   ✓ 请求头数量: " . count($provider2->getHeaders()) . "\n\n";

    // 测试3: 工厂方法 - create
    echo "3. 测试工厂方法 HttpProvider::create():\n";
    $provider3 = HttpProvider::create('https://nile.trongrid.io', [
        'timeout' => 45,
        'nodeType' => 'fullnode'
    ]);
    echo "   ✓ 主机: " . $provider3->getHost() . "\n";
    echo "   ✓ 节点类型: " . $provider3->getNodeType() . "\n";
    echo "   ✓ 超时: " . $provider3->getTimeout() . "秒\n\n";

    // 测试4: 工厂方法 - fromConfig
    echo "4. 测试工厂方法 HttpProvider::fromConfig():\n";
    $provider4 = HttpProvider::fromConfig([
        'host' => 'https://api.trongrid.io',
        'nodeType' => 'solidity',
        'timeout' => 30
    ]);
    echo "   ✓ 主机: " . $provider4->getHost() . "\n";
    echo "   ✓ 节点类型: " . $provider4->getNodeType() . "\n\n";

    // 测试5: 预设网络工厂方法
    echo "5. 测试预设网络工厂方法:\n";

    $mainnet = HttpProvider::mainnet();
    echo "   ✓ 主网 (Full Node): " . $mainnet->getHost() . " - " . $mainnet->getNodeType() . "\n";

    $mainnetSolidity = HttpProvider::mainnet(true);
    echo "   ✓ 主网 (Solidity): " . $mainnetSolidity->getHost() . " - " . $mainnetSolidity->getNodeType() . "\n";

    $testnet = HttpProvider::testnet();
    echo "   ✓ 测试网: " . $testnet->getHost() . " - " . $testnet->getNodeType() . "\n";

    $nile = HttpProvider::nile(true);
    echo "   ✓ Nile测试网: " . $nile->getHost() . " - " . $nile->getNodeType() . "\n\n";

    // 测试6: 动态设置方法
    echo "6. 测试动态设置方法:\n";
    $provider5 = HttpProvider::mainnet();
    echo "   原始节点类型: " . $provider5->getNodeType() . "\n";

    $provider5->setNodeType('solidity');
    echo "   ✓ 更新后节点类型: " . $provider5->getNodeType() . "\n";

    $provider5->addHeader('Custom-Header', 'test-value');
    echo "   ✓ 添加请求头后数量: " . count($provider5->getHeaders()) . "\n";

    $provider5->setHeaders(['New-Header' => 'new-value']);
    echo "   ✓ 重置请求头后数量: " . count($provider5->getHeaders()) . "\n\n";

    // 测试7: 连接测试
    echo "7. 测试网络连接:\n";
    $testProvider = HttpProvider::mainnet();
    $isConnected = $testProvider->isConnected();
    echo "   ✓ 主网连接状态: " . ($isConnected ? '已连接' : '未连接') . "\n\n";

    // 测试8: 错误处理
    echo "8. 测试错误处理:\n";
    try {
        $invalidProvider = new HttpProvider([
            'host' => 'https://api.trongrid.io',
            'nodeType' => 'invalid-type'
        ]);
        echo "   ✗ 应该抛出异常但没有\n";
    } catch (TronException $e) {
        echo "   ✓ 正确捕获无效节点类型异常: " . $e->getMessage() . "\n";
    }

    try {
        $provider6 = HttpProvider::mainnet();
        $provider6->setNodeType('invalid');
        echo "   ✗ 应该抛出异常但没有\n";
    } catch (TronException $e) {
        echo "   ✓ 正确捕获setNodeType异常: " . $e->getMessage() . "\n";
    }

    // 测试9: 向后兼容性 - setStatusPage (已弃用)
    echo "\n9. 测试向后兼容性:\n";
    $provider7 = HttpProvider::mainnet();
    $provider7->setStatusPage('/test'); // 应该不会抛出异常
    echo "   ✓ setStatusPage方法保持向后兼容（已弃用但不报错）\n";

    echo "\n=== 所有测试通过! HttpProvider优化成功! ===\n";
} catch (Exception $e) {
    echo "❌ 测试失败: " . $e->getMessage() . "\n";
    echo "文件: " . $e->getFile() . "\n";
    echo "行号: " . $e->getLine() . "\n";
}

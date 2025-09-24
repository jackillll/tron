# Laravel Tron 包 - 完整API方法文档

## 概述

Laravel Tron 包提供了与 TRON 区块链网络交互的完整功能。本文档详细介绍了所有可用的 API 方法。

## 目录

1. [基础功能](#基础功能)
2. [账户管理](#账户管理)
3. [交易操作](#交易操作)
4. [区块查询](#区块查询)
5. [智能合约](#智能合约)
6. [代币管理](#代币管理)
7. [投票功能](#投票功能)
8. [Stake 2.0 质押](#stake-20-质押)
9. [治理功能](#治理功能)
10. [交易所功能](#交易所功能)
11. [市场功能](#市场功能)
12. [隐私交易](#隐私交易)
13. [资源管理](#资源管理)
14. [网络信息](#网络信息)

---

## 基础功能

### 连接管理

#### `isConnected()`
检查与 TRON 网络的连接状态。

**返回值：** `bool` - 连接状态

**示例：**
```php
$isConnected = $tron->isConnected();
```

#### `validateAddress($address)`
验证 TRON 地址的有效性。

**参数：**
- `$address` (string) - 要验证的地址

**返回值：** `array` - 验证结果

**示例：**
```php
$result = $tron->validateAddress('TRX9Uhjxvb5RYiuqiH1qQD6KpBcBv4cWBY');
```

#### `isAddress($address)`
检查字符串是否为有效的 TRON 地址。

**参数：**
- `$address` (string) - 要检查的地址

**返回值：** `bool` - 是否为有效地址

**示例：**
```php
$isValid = $tron->isAddress('TRX9Uhjxvb5RYiuqiH1qQD6KpBcBv4cWBY');
```

### 地址转换

#### `getAddressHex($address)`
将 Base58 地址转换为十六进制格式。

**参数：**
- `$address` (string) - Base58 地址

**返回值：** `string` - 十六进制地址

#### `getBase58CheckAddress($hexAddress)`
将十六进制地址转换为 Base58 格式。

**参数：**
- `$hexAddress` (string) - 十六进制地址

**返回值：** `string` - Base58 地址

#### `generateAddress()`
生成新的 TRON 地址。

**返回值：** `array` - 包含地址和私钥的数组

---

## 账户管理

### 账户信息

#### `getAccount($address)`
获取账户详细信息。

**参数：**
- `$address` (string) - 账户地址

**返回值：** `array` - 账户信息

**示例：**
```php
$account = $tron->getAccount('TRX9Uhjxvb5RYiuqiH1qQD6KpBcBv4cWBY');
```

#### `getAccountResources($address)`
获取账户资源信息（带宽、能量等）。

**参数：**
- `$address` (string) - 账户地址

**返回值：** `array` - 资源信息

#### `createAccount($ownerAddress, $accountAddress)`
创建新账户。

**参数：**
- `$ownerAddress` (string) - 创建者地址
- `$accountAddress` (string) - 新账户地址

**返回值：** `array` - 交易信息

#### `registerAccount($address, $accountName)`
注册账户名称。

**参数：**
- `$address` (string) - 账户地址
- `$accountName` (string) - 账户名称

**返回值：** `array` - 交易信息

#### `changeAccountName($address, $accountName)`
更改账户名称。

**参数：**
- `$address` (string) - 账户地址
- `$accountName` (string) - 新账户名称

**返回值：** `array` - 交易信息

### 余额查询

#### `getBalance($address, $fromTron = false)`
获取 TRX 余额。

**参数：**
- `$address` (string) - 账户地址
- `$fromTron` (bool) - 是否从 TRON 网络获取

**返回值：** `float` - TRX 余额

**示例：**
```php
$balance = $tron->getBalance('TRX9Uhjxvb5RYiuqiH1qQD6KpBcBv4cWBY');
```

#### `getTokenBalance($address, $tokenId, $fromTron = false)`
获取代币余额。

**参数：**
- `$address` (string) - 账户地址
- `$tokenId` (string) - 代币ID或合约地址
- `$fromTron` (bool) - 是否从 TRON 网络获取

**返回值：** `float` - 代币余额

#### `getBandwidth($address)`
获取账户带宽信息。

**参数：**
- `$address` (string) - 账户地址

**返回值：** `array` - 带宽信息

---

## 交易操作

### TRX 转账

#### `sendTransaction($to, $amount, $from)`
发送 TRX 交易。

**参数：**
- `$to` (string) - 接收地址
- `$amount` (float) - 转账金额
- `$from` (string) - 发送地址

**返回值：** `array` - 交易信息

**示例：**
```php
$result = $tron->sendTransaction('TTo...', 100, 'TFrom...');
```

#### `send($to, $amount, $from)`
发送 TRX（sendTransaction 的别名）。

#### `sendTrx($to, $amount, $from)`
发送 TRX（sendTransaction 的别名）。

### 代币转账

#### `sendTokenTransaction($to, $amount, $tokenId, $from)`
发送代币交易。

**参数：**
- `$to` (string) - 接收地址
- `$amount` (float) - 转账金额
- `$tokenId` (string) - 代币ID
- `$from` (string) - 发送地址

**返回值：** `array` - 交易信息

#### `sendToken($to, $amount, $tokenId, $from)`
发送代币（sendTokenTransaction 的别名）。

### 交易签名和广播

#### `signTransaction($transaction, $privateKey)`
签名交易。

**参数：**
- `$transaction` (array) - 交易对象
- `$privateKey` (string) - 私钥

**返回值：** `array` - 签名后的交易

#### `sendRawTransaction($signedTransaction)`
广播已签名的交易。

**参数：**
- `$signedTransaction` (array) - 已签名的交易

**返回值：** `array` - 广播结果

### 交易查询

#### `getTransaction($txId)`
根据交易ID获取交易详情。

**参数：**
- `$txId` (string) - 交易ID

**返回值：** `array` - 交易详情

#### `getTransactionInfo($txId)`
获取交易执行信息。

**参数：**
- `$txId` (string) - 交易ID

**返回值：** `array` - 交易执行信息

#### `getTransactionsToAddress($address, $limit = 30, $offset = 0)`
获取发送到指定地址的交易列表。

**参数：**
- `$address` (string) - 地址
- `$limit` (int) - 限制数量
- `$offset` (int) - 偏移量

**返回值：** `array` - 交易列表

#### `getTransactionsFromAddress($address, $limit = 30, $offset = 0)`
获取从指定地址发送的交易列表。

**参数：**
- `$address` (string) - 地址
- `$limit` (int) - 限制数量
- `$offset` (int) - 偏移量

**返回值：** `array` - 交易列表

#### `getTransactionsRelated($address, $direction = 'all', $limit = 30, $offset = 0)`
获取与地址相关的交易。

**参数：**
- `$address` (string) - 地址
- `$direction` (string) - 方向：'all', 'from', 'to'
- `$limit` (int) - 限制数量
- `$offset` (int) - 偏移量

**返回值：** `array` - 交易列表

#### `getTransactionCount()`
获取网络总交易数量。

**返回值：** `int` - 交易总数

---

## 区块查询

### 区块信息

#### `getCurrentBlock()`
获取当前最新区块。

**返回值：** `array` - 区块信息

#### `getBlock($block)`
根据区块号或哈希获取区块。

**参数：**
- `$block` (int|string) - 区块号或哈希

**返回值：** `array` - 区块信息

#### `getBlockByHash($blockHash)`
根据区块哈希获取区块。

**参数：**
- `$blockHash` (string) - 区块哈希

**返回值：** `array` - 区块信息

#### `getBlockByNumber($blockNumber)`
根据区块号获取区块。

**参数：**
- `$blockNumber` (int) - 区块号

**返回值：** `array` - 区块信息

#### `getBlockRange($start, $end)`
获取区块范围。

**参数：**
- `$start` (int) - 起始区块号
- `$end` (int) - 结束区块号

**返回值：** `array` - 区块列表

#### `getLatestBlocks($limit = 1)`
获取最新的区块列表。

**参数：**
- `$limit` (int) - 限制数量

**返回值：** `array` - 区块列表

### 区块交易

#### `getBlockTransactionCount($block)`
获取区块中的交易数量。

**参数：**
- `$block` (int|string) - 区块号或哈希

**返回值：** `int` - 交易数量

#### `getTransactionFromBlock($block, $index)`
从区块中获取指定索引的交易。

**参数：**
- `$block` (int|string) - 区块号或哈希
- `$index` (int) - 交易索引

**返回值：** `array` - 交易信息

---

## 智能合约

### 合约实例化

#### `contract($contractAddress, $abi = null)`
创建智能合约实例（主要用于 TRC20 代币）。

**参数：**
- `$contractAddress` (string) - 合约地址
- `$abi` (string|null) - 合约ABI（可选）

**返回值：** `TRC20Contract` - TRC20合约实例

**示例：**
```php
$contract = $tron->contract('TLa2f6VPqDgRE67v1736s7bJ8Ray5wYjU7');
$balance = $contract->balanceOf('TRX9Uhjxvb5RYiuqiH1qQD6KpBcBv4cWBY');
```

### 合约部署

#### `deployContract($abi, $bytecode, $parameters, $feeLimit, $from)`
部署智能合约。

**参数：**
- `$abi` (array) - 合约ABI
- `$bytecode` (string) - 合约字节码
- `$parameters` (array) - 构造函数参数
- `$feeLimit` (int) - 费用限制
- `$from` (string) - 部署者地址

**返回值：** `array` - 部署结果

### 合约调用

#### `getEventResult($contractAddress, $eventName = null, $blockNumber = null)`
获取合约事件结果。

**参数：**
- `$contractAddress` (string) - 合约地址
- `$eventName` (string|null) - 事件名称
- `$blockNumber` (int|null) - 区块号

**返回值：** `array` - 事件结果

#### `getEventByTransactionID($txId)`
根据交易ID获取事件。

**参数：**
- `$txId` (string) - 交易ID

**返回值：** `array` - 事件信息

---

## 代币管理

### 代币创建

#### `createToken($options, $issuerAddress)`
创建新代币。

**参数：**
- `$options` (array) - 代币参数
- `$issuerAddress` (string) - 发行者地址

**返回值：** `array` - 创建结果

#### `updateToken($description, $url, $freeBandwidth, $freeBandwidthLimit, $ownerAddress)`
更新代币信息。

**参数：**
- `$description` (string) - 代币描述
- `$url` (string) - 代币网址
- `$freeBandwidth` (int) - 免费带宽
- `$freeBandwidthLimit` (int) - 免费带宽限制
- `$ownerAddress` (string) - 所有者地址

**返回值：** `array` - 更新结果

### 代币查询

#### `getTokensIssuedByAddress($address)`
获取地址发行的代币列表。

**参数：**
- `$address` (string) - 地址

**返回值：** `array` - 代币列表

#### `getTokenFromID($tokenId)`
根据ID获取代币信息。

**参数：**
- `$tokenId` (string) - 代币ID

**返回值：** `array` - 代币信息

#### `getTokenByID($tokenId)`
根据ID获取代币信息（getTokenFromID 的别名）。

#### `listTokens($limit = 0, $offset = 0)`
获取代币列表。

**参数：**
- `$limit` (int) - 限制数量
- `$offset` (int) - 偏移量

**返回值：** `array` - 代币列表

### 代币交易

#### `purchaseToken($tokenId, $amount, $buyerAddress)`
购买代币。

**参数：**
- `$tokenId` (string) - 代币ID
- `$amount` (int) - 购买数量
- `$buyerAddress` (string) - 购买者地址

**返回值：** `array` - 购买结果

---

## 投票功能

### 投票操作

#### `voteWitnessAccount($votes, $voterAddress)`
投票给超级代表。

**参数：**
- `$votes` (array) - 投票列表，格式：[['vote_address' => 'address', 'vote_count' => count]]
- `$voterAddress` (string) - 投票者地址

**返回值：** `array` - 投票交易

**示例：**
```php
$votes = [
    ['vote_address' => 'TSuper...', 'vote_count' => 100],
    ['vote_address' => 'TSuper2...', 'vote_count' => 50]
];
$result = $tron->voteWitnessAccount($votes, 'TVoter...');
```

### 投票查询

#### `getAccountVotes($address)`
获取账户的投票信息。

**参数：**
- `$address` (string) - 账户地址

**返回值：** `array` - 投票信息

#### `getWitnesses()`
获取所有超级代表列表。

**返回值：** `array` - 超级代表列表

#### `getWitness($address)`
获取特定超级代表信息。

**参数：**
- `$address` (string) - 超级代表地址

**返回值：** `array` - 超级代表信息

#### `getBrokerage($address)`
获取超级代表的佣金信息。

**参数：**
- `$address` (string) - 超级代表地址

**返回值：** `array` - 佣金信息

#### `getReward($address)`
获取账户的奖励信息。

**参数：**
- `$address` (string) - 账户地址

**返回值：** `array` - 奖励信息

### 超级代表

#### `listSuperRepresentatives()`
获取超级代表列表。

**返回值：** `array` - 超级代表列表

#### `applyForSuperRepresentative($address, $url)`
申请成为超级代表。

**参数：**
- `$address` (string) - 申请者地址
- `$url` (string) - 超级代表网址

**返回值：** `array` - 申请结果

#### `timeUntilNextVoteCycle()`
获取距离下次投票周期的时间。

**返回值：** `int` - 剩余时间（秒）

---

## Stake 2.0 质押

### 质押操作

#### `freezeBalanceV2($frozenBalance, $resource, $ownerAddress)`
质押 TRX v2（Stake 2.0）。

**参数：**
- `$frozenBalance` (int) - 质押金额（sun）
- `$resource` (string) - 资源类型：'BANDWIDTH' 或 'ENERGY'
- `$ownerAddress` (string) - 所有者地址

**返回值：** `array` - 质押交易

**示例：**
```php
$result = $tron->freezeBalanceV2(1000000000, 'ENERGY', 'TOwner...');
```

#### `unfreezeBalanceV2($unfreezeBalance, $resource, $ownerAddress)`
解质押 TRX v2。

**参数：**
- `$unfreezeBalance` (int) - 解质押金额（sun）
- `$resource` (string) - 资源类型：'BANDWIDTH' 或 'ENERGY'
- `$ownerAddress` (string) - 所有者地址

**返回值：** `array` - 解质押交易

#### `cancelAllUnfreezeV2($ownerAddress)`
取消所有解质押操作。

**参数：**
- `$ownerAddress` (string) - 所有者地址

**返回值：** `array` - 取消交易

### 资源委托

#### `delegateResource($balance, $resource, $receiverAddress, $ownerAddress, $lock = false)`
委托资源给其他账户。

**参数：**
- `$balance` (int) - 委托金额（sun）
- `$resource` (string) - 资源类型：'BANDWIDTH' 或 'ENERGY'
- `$receiverAddress` (string) - 接收者地址
- `$ownerAddress` (string) - 委托者地址
- `$lock` (bool) - 是否锁定

**返回值：** `array` - 委托交易

#### `undelegateResource($balance, $resource, $receiverAddress, $ownerAddress)`
取消资源委托。

**参数：**
- `$balance` (int) - 取消委托金额（sun）
- `$resource` (string) - 资源类型
- `$receiverAddress` (string) - 接收者地址
- `$ownerAddress` (string) - 委托者地址

**返回值：** `array` - 取消委托交易

### 质押查询

#### `getDelegatedResource($fromAddress, $toAddress)`
获取委托资源信息。

**参数：**
- `$fromAddress` (string) - 委托者地址
- `$toAddress` (string) - 接收者地址

**返回值：** `array` - 委托资源信息

#### `getDelegatedResourceAccountIndex($address)`
获取账户的委托资源索引。

**参数：**
- `$address` (string) - 账户地址

**返回值：** `array` - 委托资源索引

#### `getAvailableUnfreezeCount($ownerAddress)`
获取可用的解质押次数。

**参数：**
- `$ownerAddress` (string) - 所有者地址

**返回值：** `array` - 可用解质押次数

### 传统质押（Stake 1.0）

#### `freezeBalance($frozenBalance, $frozenDuration, $resource, $ownerAddress, $receiverAddress = null)`
质押 TRX（传统方式）。

**参数：**
- `$frozenBalance` (int) - 质押金额
- `$frozenDuration` (int) - 质押天数
- `$resource` (string) - 资源类型
- `$ownerAddress` (string) - 所有者地址
- `$receiverAddress` (string|null) - 接收者地址

**返回值：** `array` - 质押交易

#### `unfreezeBalance($resource, $ownerAddress, $receiverAddress = null)`
解质押 TRX（传统方式）。

**参数：**
- `$resource` (string) - 资源类型
- `$ownerAddress` (string) - 所有者地址
- `$receiverAddress` (string|null) - 接收者地址

**返回值：** `array` - 解质押交易

#### `withdrawBlockRewards($ownerAddress)`
提取区块奖励。

**参数：**
- `$ownerAddress` (string) - 所有者地址

**返回值：** `array` - 提取交易

---

## 治理功能

### 提案管理

#### `createProposal($parameters, $ownerAddress)`
创建治理提案。

**参数：**
- `$parameters` (array) - 提案参数
- `$ownerAddress` (string) - 提案者地址

**返回值：** `array` - 创建提案交易

**示例：**
```php
$parameters = [
    ['key' => 0, 'value' => 1000000]  // 修改维护间隔
];
$result = $tron->createProposal($parameters, 'TProposer...');
```

#### `approveProposal($proposalId, $ownerAddress, $isApproval = true)`
批准或拒绝提案。

**参数：**
- `$proposalId` (int) - 提案ID
- `$ownerAddress` (string) - 投票者地址
- `$isApproval` (bool) - 是否批准

**返回值：** `array` - 投票交易

#### `deleteProposal($proposalId, $ownerAddress)`
删除提案。

**参数：**
- `$proposalId` (int) - 提案ID
- `$ownerAddress` (string) - 提案者地址

**返回值：** `array` - 删除交易

### 提案查询

#### `getProposals()`
获取所有提案列表。

**返回值：** `array` - 提案列表

#### `getProposal($proposalId)`
获取特定提案信息。

**参数：**
- `$proposalId` (int) - 提案ID

**返回值：** `array` - 提案信息

---

## 交易所功能

### 交易所操作

#### `exchangeCreate($firstTokenId, $firstTokenBalance, $secondTokenId, $secondTokenBalance, $ownerAddress)`
创建交易对。

**参数：**
- `$firstTokenId` (string) - 第一个代币ID
- `$firstTokenBalance` (int) - 第一个代币数量
- `$secondTokenId` (string) - 第二个代币ID
- `$secondTokenBalance` (int) - 第二个代币数量
- `$ownerAddress` (string) - 创建者地址

**返回值：** `array` - 创建交易

#### `exchangeInject($exchangeId, $tokenId, $quant, $ownerAddress)`
向交易对注入资金。

**参数：**
- `$exchangeId` (int) - 交易对ID
- `$tokenId` (string) - 代币ID
- `$quant` (int) - 注入数量
- `$ownerAddress` (string) - 所有者地址

**返回值：** `array` - 注入交易

#### `exchangeWithdraw($exchangeId, $tokenId, $quant, $ownerAddress)`
从交易对提取资金。

**参数：**
- `$exchangeId` (int) - 交易对ID
- `$tokenId` (string) - 代币ID
- `$quant` (int) - 提取数量
- `$ownerAddress` (string) - 所有者地址

**返回值：** `array` - 提取交易

#### `exchangeTransaction($exchangeId, $tokenId, $quant, $expected, $ownerAddress)`
执行交易所交易。

**参数：**
- `$exchangeId` (int) - 交易对ID
- `$tokenId` (string) - 代币ID
- `$quant` (int) - 交易数量
- `$expected` (int) - 期望获得数量
- `$ownerAddress` (string) - 交易者地址

**返回值：** `array` - 交易结果

### 交易所查询

#### `getExchange($exchangeId)`
获取交易对信息。

**参数：**
- `$exchangeId` (int) - 交易对ID

**返回值：** `array` - 交易对信息

#### `listExchanges()`
获取所有交易对列表。

**返回值：** `array` - 交易对列表

---

## 市场功能

### 市场交易

#### `marketSellAsset($sellTokenId, $sellTokenQuantity, $buyTokenId, $buyTokenQuantity, $ownerAddress)`
在市场上卖出资产。

**参数：**
- `$sellTokenId` (string) - 卖出代币ID
- `$sellTokenQuantity` (int) - 卖出数量
- `$buyTokenId` (string) - 购买代币ID
- `$buyTokenQuantity` (int) - 购买数量
- `$ownerAddress` (string) - 卖家地址

**返回值：** `array` - 卖出交易

#### `marketCancelOrder($orderId, $ownerAddress)`
取消市场订单。

**参数：**
- `$orderId` (string) - 订单ID
- `$ownerAddress` (string) - 订单所有者地址

**返回值：** `array` - 取消交易

### 市场查询

#### `getMarketOrderById($orderId)`
根据ID获取市场订单。

**参数：**
- `$orderId` (string) - 订单ID

**返回值：** `array` - 订单信息

#### `getMarketOrderByAccount($address)`
获取账户的市场订单。

**参数：**
- `$address` (string) - 账户地址

**返回值：** `array` - 订单列表

#### `getMarketPriceByPair($sellTokenId, $buyTokenId)`
获取交易对的市场价格。

**参数：**
- `$sellTokenId` (string) - 卖出代币ID
- `$buyTokenId` (string) - 购买代币ID

**返回值：** `array` - 价格信息

#### `getMarketOrderListByPair($sellTokenId, $buyTokenId)`
获取交易对的订单列表。

**参数：**
- `$sellTokenId` (string) - 卖出代币ID
- `$buyTokenId` (string) - 购买代币ID

**返回值：** `array` - 订单列表

---

## 隐私交易

### 隐私交易创建

#### `createShieldedTransaction($transparentFromAddress, $fromAmount, $shieldedSpends, $shieldedOutputs, $transparentToAddress, $toAmount)`
创建隐私交易。

**参数：**
- `$transparentFromAddress` (string) - 透明发送地址
- `$fromAmount` (int) - 发送金额
- `$shieldedSpends` (array) - 隐私输入
- `$shieldedOutputs` (array) - 隐私输出
- `$transparentToAddress` (string) - 透明接收地址
- `$toAmount` (int) - 接收金额

**返回值：** `array` - 隐私交易

#### `getShieldedTransactionHash($transaction)`
获取隐私交易哈希。

**参数：**
- `$transaction` (array) - 隐私交易

**返回值：** `string` - 交易哈希

### 隐私地址管理

#### `getSpendingKey()`
生成支出密钥。

**返回值：** `string` - 支出密钥

#### `getExpandedSpendingKey($spendingKey)`
扩展支出密钥。

**参数：**
- `$spendingKey` (string) - 支出密钥

**返回值：** `array` - 扩展密钥

#### `getShieldedPaymentAddress($ivk, $diversifier)`
获取隐私支付地址。

**参数：**
- `$ivk` (string) - 传入查看密钥
- `$diversifier` (string) - 多样化器

**返回值：** `string` - 隐私地址

### 隐私交易查询

#### `scanNoteByIvk($startBlockNumber, $endBlockNumber, $ivk)`
通过传入查看密钥扫描票据。

**参数：**
- `$startBlockNumber` (int) - 起始区块号
- `$endBlockNumber` (int) - 结束区块号
- `$ivk` (string) - 传入查看密钥

**返回值：** `array` - 票据列表

#### `isNoteSpent($ak, $nk, $position)`
检查票据是否已花费。

**参数：**
- `$ak` (string) - 授权密钥
- `$nk` (string) - 无效化密钥
- `$position` (int) - 位置

**返回值：** `bool` - 是否已花费

---

## 资源管理

### 资源价格

#### `getEnergyPrices()`
获取能量价格信息。

**返回值：** `array` - 能量价格

#### `getBandwidthPrices()`
获取带宽价格信息。

**返回值：** `array` - 带宽价格

---

## 网络信息

### 网络状态

#### `listNodes()`
获取网络节点列表。

**返回值：** `array` - 节点列表

---

## 工具方法

### 地址转换

#### `address2HexString($address)`
将 Base58 地址转换为十六进制字符串。

**参数：**
- `$address` (string) - Base58 地址

**返回值：** `string` - 十六进制地址

#### `hexString2Address($hexString)`
将十六进制字符串转换为 Base58 地址。

**参数：**
- `$hexString` (string) - 十六进制地址

**返回值：** `string` - Base58 地址

### 数据转换

#### `fromHex($hexString)`
从十六进制字符串转换。

**参数：**
- `$hexString` (string) - 十六进制字符串

**返回值：** `string` - 转换后的字符串

#### `toHex($string)`
转换为十六进制字符串。

**参数：**
- `$string` (string) - 要转换的字符串

**返回值：** `string` - 十六进制字符串

#### `stringUtf8toHex($utf8String)`
将 UTF-8 字符串转换为十六进制。

**参数：**
- `$utf8String` (string) - UTF-8 字符串

**返回值：** `string` - 十六进制字符串

#### `hexString2Utf8($hexString)`
将十六进制字符串转换为 UTF-8。

**参数：**
- `$hexString` (string) - 十六进制字符串

**返回值：** `string` - UTF-8 字符串

### 数值转换

#### `fromTron($amount)`
从 TRX 转换为 sun（1 TRX = 1,000,000 sun）。

**参数：**
- `$amount` (float) - TRX 数量

**返回值：** `int` - sun 数量

#### `toTron($amount)`
从 sun 转换为 TRX。

**参数：**
- `$amount` (int) - sun 数量

**返回值：** `float` - TRX 数量

#### `toBigNumber($value)`
转换为大数。

**参数：**
- `$value` (string|int) - 数值

**返回值：** `BigInteger` - 大数对象

### 哈希函数

#### `sha3($string, $prefix = true)`
计算 SHA3 哈希。

**参数：**
- `$string` (string) - 要哈希的字符串
- `$prefix` (bool) - 是否添加前缀

**返回值：** `string` - 哈希值

#### `getNodeInfo()`
获取当前节点信息。

**返回值：** `array` - 节点信息

#### `getChainParameters()`
获取链参数。

**返回值：** `array` - 链参数

#### `getBurnTrx()`
获取销毁的 TRX 信息。

**返回值：** `array` - 销毁信息

---

## 工具方法

### 编码转换

#### `toUtf8($hex)`
将十六进制转换为 UTF-8 字符串。

**参数：**
- `$hex` (string) - 十六进制字符串

**返回值：** `string` - UTF-8 字符串

---

## 错误处理

所有方法在遇到错误时都会抛出相应的异常：

- `TronException` - 一般 TRON 相关错误
- `TRC20Exception` - TRC20 代币相关错误
- `NotFoundException` - 资源未找到错误
- `ErrorException` - 其他错误

## 使用示例

```php
use Jackillll\Tron\Tron;

// 初始化
$tron = new Tron();

// 检查连接
if ($tron->isConnected()) {
    // 获取账户余额
    $balance = $tron->getBalance('TRX9Uhjxvb5RYiuqiH1qQD6KpBcBv4cWBY');
    
    // 发送 TRX
    $result = $tron->sendTransaction('TTo...', 100, 'TFrom...');
    
    // 投票给超级代表
    $votes = [['vote_address' => 'TSuper...', 'vote_count' => 100]];
    $voteResult = $tron->voteWitnessAccount($votes, 'TVoter...');
    
    // 质押 TRX
    $stakeResult = $tron->freezeBalanceV2(1000000000, 'ENERGY', 'TOwner...');
}
```

## 注意事项

1. 所有金额参数都以 sun 为单位（1 TRX = 1,000,000 sun）
2. 地址必须是有效的 TRON 地址格式
3. 私钥操作需要特别小心，确保安全存储
4. 某些操作需要消耗 TRX 作为手续费
5. 隐私交易功能需要特殊的密钥管理

## 版本要求

- PHP >= 7.4
- Laravel >= 8.0
- TRON 网络连接

---

*本文档基于 Laravel Tron 包的最新版本编写，如有更新请参考官方文档。*

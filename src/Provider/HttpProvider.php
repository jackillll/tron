<?php

/**
 * Laravel Tron API Package - HTTP Provider
 *
 * A PHP API for interacting with Tron (TRX) blockchain with Laravel integration
 * Based on the original iexbase/tron-api package
 *
 * @author  Jackillll <jackjack75383973@gmail.com>
 * @author  Shamsudin Serderov <steein.shamsudin@gmail.com> (Original Author)
 * @license https://github.com/jackillll/tron/blob/master/LICENSE (MIT License)
 * @version 2.0.0
 * @link    https://github.com/jackillll/tron
 * @package Jackillll\Tron\Provider
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Jackillll\Tron\Provider;

use GuzzleHttp\{Psr7\Request, Client, ClientInterface};
use Psr\Http\Message\StreamInterface;
use Jackillll\Tron\Exception\{NotFoundException, TronException};
use Jackillll\Tron\Support\Utils;

/**
 * HTTP Provider
 *
 * HTTP provider implementation for TRON blockchain API communication.
 * This class handles HTTP requests to TRON network nodes including:
 * - Full Node API requests
 * - Solidity Node API requests
 * - Event Server API requests
 * - Custom HTTP headers and authentication
 * - Request timeout management
 * - Connection status monitoring
 *
 * Features:
 * - Multiple constructor options (string host or configuration array)
 * - Factory methods for common network configurations
 * - Support for different node types (fullnode, solidity)
 * - Configurable timeouts and custom headers
 * - Built-in connection testing
 * - Guzzle HTTP client integration
 *
 * @package Jackillll\Tron\Provider
 * @author  Jackillll <jackjack75383973@gmail.com>
 * @since   2.0.0
 */
class HttpProvider implements HttpProviderInterface
{
    /**
     * HTTP Client Handler
     *
     * @var ClientInterface
     */
    protected ClientInterface $httpClient;

    /**
     * Server or RPC URL
     *
     * @var string
     */
    protected string $host;

    /**
     * Request timeout in milliseconds
     *
     * @var int
     */
    protected int $timeout;

    /**
     * Custom HTTP headers
     *
     * @var array
     */
    protected array $headers;

    /**
     * Node type (fullnode or solidity)
     *
     * @var string
     */
    protected string $nodeType;

    /**
     * Default configuration values
     *
     * @var array
     */
    private const DEFAULT_CONFIG = [
        'timeout' => 30000,
        'headers' => [],
        'nodeType' => 'fullnode',
        'connectTimeout' => 10,
        'retries' => 3
    ];

    /**
     * Valid node types
     *
     * @var array
     */
    private const VALID_NODE_TYPES = ['fullnode', 'solidity'];

    /**
     * Create an HttpProvider object
     *
     * @param string|array $hostOrConfig Host URL or configuration array
     * @param array $config Additional configuration options
     * @throws TronException
     */
    public function __construct($hostOrConfig, array $config = [])
    {
        // Handle both old and new constructor signatures
        if (is_string($hostOrConfig)) {
            $this->initializeFromHost($hostOrConfig, $config);
        } elseif (is_array($hostOrConfig)) {
            $this->initializeFromConfig($hostOrConfig);
        } else {
            throw new TronException('Invalid constructor parameters. Expected string host or array config.');
        }

        $this->validateConfiguration();
        $this->httpClient = $this->createHttpClient();
    }

    /**
     * Initialize from host string (backward compatibility)
     *
     * @param string $host
     * @param array $config
     */
    private function initializeFromHost(string $host, array $config): void
    {
        $this->host = $host;
        $this->timeout = $config['timeout'] ?? self::DEFAULT_CONFIG['timeout'];
        $this->headers = $config['headers'] ?? self::DEFAULT_CONFIG['headers'];
        $this->nodeType = $config['nodeType'] ?? self::DEFAULT_CONFIG['nodeType'];
    }

    /**
     * Initialize from configuration array
     *
     * @param array $config
     * @throws TronException
     */
    private function initializeFromConfig(array $config): void
    {
        if (!isset($config['host'])) {
            throw new TronException('Host is required in configuration array');
        }

        $this->host = $config['host'];
        $this->timeout = $config['timeout'] ?? self::DEFAULT_CONFIG['timeout'];
        $this->headers = $config['headers'] ?? self::DEFAULT_CONFIG['headers'];
        $this->nodeType = $config['nodeType'] ?? self::DEFAULT_CONFIG['nodeType'];
    }

    /**
     * Validate configuration parameters
     *
     * @throws TronException
     */
    private function validateConfiguration(): void
    {
        if (!Utils::isValidUrl($this->host)) {
            throw new TronException('Invalid URL provided to HttpProvider');
        }

        if ($this->timeout < 0) {
            throw new TronException('Invalid timeout duration provided');
        }

        if (!is_array($this->headers)) {
            throw new TronException('Headers must be an array');
        }

        if (!in_array($this->nodeType, self::VALID_NODE_TYPES)) {
            throw new TronException('Invalid node type. Must be "fullnode" or "solidity"');
        }
    }

    /**
     * Create HTTP client instance
     *
     * @return ClientInterface
     */
    private function createHttpClient(): ClientInterface
    {
        return new Client([
            'base_uri' => $this->host,
            'timeout' => $this->timeout / 1000, // Convert to seconds for Guzzle
            'connect_timeout' => 10,
            'headers' => $this->headers
        ]);
    }

    /**
     * Create HttpProvider from host URL (factory method)
     *
     * @param string $host
     * @param array $options
     * @return static
     * @throws TronException
     */
    public static function create(string $host, array $options = []): self
    {
        return new self($host, $options);
    }

    /**
     * Create HttpProvider from configuration array (factory method)
     *
     * @param array $config
     * @return static
     * @throws TronException
     */
    public static function fromConfig(array $config): self
    {
        return new self($config);
    }

    /**
     * Create HttpProvider for mainnet
     *
     * @param bool $useSolidity
     * @param array $options
     * @return static
     * @throws TronException
     */
    public static function mainnet(bool $useSolidity = false, array $options = []): self
    {
        $config = array_merge($options, [
            'host' => 'https://api.trongrid.io',
            'nodeType' => $useSolidity ? 'solidity' : 'fullnode'
        ]);
        
        return new self($config);
    }

    /**
     * Create HttpProvider for testnet
     *
     * @param bool $useSolidity
     * @param array $options
     * @return static
     * @throws TronException
     */
    public static function testnet(bool $useSolidity = false, array $options = []): self
    {
        $config = array_merge($options, [
            'host' => 'https://api.shasta.trongrid.io',
            'nodeType' => $useSolidity ? 'solidity' : 'fullnode'
        ]);
        
        return new self($config);
    }

    /**
     * Create HttpProvider for Nile testnet
     *
     * @param bool $useSolidity
     * @param array $options
     * @return static
     * @throws TronException
     */
    public static function nile(bool $useSolidity = false, array $options = []): self
    {
        $config = array_merge($options, [
            'host' => 'https://nile.trongrid.io',
            'nodeType' => $useSolidity ? 'solidity' : 'fullnode'
        ]);
        
        return new self($config);
    }

    /**
     * Enter a new page (deprecated - kept for backward compatibility)
     *
     * @param string $page
     * @deprecated This method is deprecated and will be removed in future versions
     */
    public function setStatusPage(string $page = '/'): void
    {
        // This method is kept for backward compatibility but does nothing
        // as statusPage functionality has been removed
    }

    /**
     * Check connection to the Tron network
     *
     * @return bool
     */
    public function isConnected(): bool
    {
        try {
            $response = $this->request('wallet/getnowblock');
            
            return isset($response['blockID']) || isset($response['block_header']);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get the host URL
     *
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * Get the timeout value
     *
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * Get the node type
     *
     * @return string
     */
    public function getNodeType(): string
    {
        return $this->nodeType;
    }

    /**
     * Get the headers
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Set the node type
     *
     * @param string $nodeType
     * @throws TronException
     */
    public function setNodeType(string $nodeType): void
    {
        if (!in_array($nodeType, self::VALID_NODE_TYPES)) {
            throw new TronException(
                'Invalid node type. Must be one of: ' . implode(', ', self::VALID_NODE_TYPES)
            );
        }
        $this->nodeType = $nodeType;
    }

    /**
     * Set headers
     *
     * @param array $headers
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
        
        // Update the HTTP client with new headers
        $this->httpClient = $this->createHttpClient();
    }

    /**
     * Add a header
     *
     * @param string $name
     * @param string $value
     */
    public function addHeader(string $name, string $value): void
    {
        $this->headers[$name] = $value;
        
        // Update the HTTP client with new headers
        $this->httpClient = $this->createHttpClient();
    }

    /**
     * We send requests to the server
     *
     * @param $url
     * @param array $payload
     * @param string $method
     * @return array|mixed
     * @throws TronException
     */
    public function request($url, array $payload = [], string $method = 'get'): array
    {
        $method = strtoupper($method);

        if (!in_array($method, ['GET', 'POST'])) {
            throw new TronException('The method is not defined');
        }

        // Add solidity prefix for solidity node requests
        if ($this->nodeType === 'solidity') {
            // Only add solidity prefix if not already present and not for wallet endpoints
            if (strpos($url, 'solidity/') !== 0 && strpos($url, 'wallet/') !== 0) {
                $url = 'solidity/' . $url;
            }
        }

        $options = [
            'headers'   => $this->headers,
            'body'      => json_encode($payload)
        ];

        $request = new Request($method, $url, $options['headers'], $options['body']);
        $rawResponse = $this->httpClient->send($request, $options);

        return $this->decodeBody(
            $rawResponse->getBody(),
            $rawResponse->getStatusCode()
        );
    }

    /**
     * Convert the original answer to an array
     *
     * @param StreamInterface $stream
     * @param int $status
     * @return array|mixed
     */
    protected function decodeBody(StreamInterface $stream, int $status): array
    {
        $decodedBody = json_decode($stream->getContents(), true);

        if ((string)$stream == 'OK') {
            $decodedBody = [
                'status'    =>  1
            ];
        } elseif ($decodedBody == null or !is_array($decodedBody)) {
            $decodedBody = [];
        }

        if ($status == 404) {
            throw new NotFoundException('Page not found');
        }

        return $decodedBody;
    }
}

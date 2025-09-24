<?php declare(strict_types=1);

/**
 * Laravel Tron API Package - HTTP Provider Interface
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

namespace Jackillll\Tron\Provider;

/**
 * HTTP Provider Interface
 *
 * Defines the contract for HTTP providers that communicate with Tron nodes.
 * Implementations should handle network requests, connection management,
 * and provide methods for interacting with both Full and Solidity nodes.
 *
 * @package Jackillll\Tron\Provider
 * @author  Jackillll <jackjack75383973@gmail.com>
 * @since   2.0.0
 */
interface HttpProviderInterface
{
    /**
     * Set the status page endpoint for health checks
     *
     * @param string $page The endpoint path for status checks (default: '/')
     * @return void
     */
    public function setStatusPage(string $page = '/'): void;

    /**
     * Check if the provider can connect to the Tron node
     *
     * Performs a health check to verify connectivity to the configured
     * Tron node endpoint.
     *
     * @return bool True if connection is successful, false otherwise
     */
    public function isConnected(): bool;

    /**
     * Send HTTP request to the Tron node
     *
     * Sends a request to the specified endpoint with the given payload.
     * Supports GET and POST methods for interacting with Tron API.
     *
     * @param string $url The API endpoint URL
     * @param array $payload Request payload data
     * @param string $method HTTP method ('get' or 'post')
     * @return array Response data from the Tron node
     * @throws \Jackillll\Tron\Exception\TronException On request failure
     */
    public function request($url, array $payload = [], string $method = 'get'): array;
}

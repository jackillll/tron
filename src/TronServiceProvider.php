<?php declare(strict_types=1);

/**
 * Laravel Tron API Package - Service Provider
 *
 * A PHP API for interacting with Tron (TRX) blockchain with Laravel integration
 * Based on the original iexbase/tron-api package
 *
 * @author  Jackillll <jackjack75383973@gmail.com>
 * @author  Shamsudin Serderov <steein.shamsudin@gmail.com> (Original Author)
 * @license https://github.com/jackillll/tron/blob/master/LICENSE (MIT License)
 * @version 2.0.0
 * @link    https://github.com/jackillll/tron
 * @package Jackillll\Tron
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jackillll\Tron;

use Illuminate\Support\ServiceProvider;
use Jackillll\Tron\Provider\HttpProvider;

/**
 * Tron Service Provider
 *
 * Laravel service provider for the Tron API package. Handles registration
 * of the Tron service in the Laravel container, configuration publishing,
 * and provides singleton access to the Tron client instance.
 *
 * Features:
 * - Automatic configuration loading from config/tron.php
 * - Network-based configuration (mainnet, testnet, nile)
 * - HTTP provider initialization with custom headers and timeouts
 * - Singleton service registration for optimal performance
 * - Configuration publishing for customization
 *
 * @package Jackillll\Tron
 * @author  Jackillll <jackjack75383973@gmail.com>
 * @since   2.0.0
 */
class TronServiceProvider extends ServiceProvider
{
    /**
     * Register the Tron service in the Laravel container
     *
     * Creates a singleton instance of the Tron client with configuration
     * loaded from config/tron.php. Supports multiple networks (mainnet,
     * testnet, nile) and automatically configures HTTP provider with
     * appropriate headers, timeouts, and node types.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton('tron', function ($app) {
            $config = $app['config']['tron'] ?? [];

            // Get network configuration
            $network = $config['network'] ?? 'mainnet';
            $networks = $config['networks'] ?? [];
            
            // Get host from networks configuration
            $host = $networks[$network]['host'] ?? 'https://api.trongrid.io';
            
            $timeout = $config['timeout'] ?? 30000;
            $headers = $config['headers'] ?? [];
            $useSolidity = $config['use_solidity'] ?? false;
            
            // Determine node type based on use_solidity boolean
            $nodeType = $useSolidity ? 'solidity' : 'fullnode';

            $httpProvider = new HttpProvider(
                $host, 
                $timeout, 
                false, 
                false, 
                $headers, 
                '/', 
                $nodeType
            );

            return new Tron($httpProvider);
        });

        $this->app->alias('tron', Tron::class);
    }

    /**
     * Bootstrap the Tron service
     *
     * Publishes the configuration file to the Laravel application's
     * config directory, allowing users to customize Tron settings
     * including network selection, API keys, and timeout values.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/tron.php' => config_path('tron.php'),
        ], 'tron-config');
    }

    /**
     * Get the services provided by the provider
     *
     * Returns an array of service names that this provider registers.
     * Used by Laravel for deferred service loading optimization.
     *
     * @return array<string> Array of provided service names
     */
    public function provides(): array
    {
        return ['tron', Tron::class];
    }
}

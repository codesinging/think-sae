<?php


namespace CodeSinging\ThinkSae;


use think\facade\Config;
use think\Service;

class ThinkSaeService extends Service
{

    /**
     * Register service
     */
    public function register()
    {
    }

    /**
     * Bootstrap service
     */
    public function boot()
    {
        if (defined('SAE_APPNAME')) {
            $this->mergeConfig();
        }
    }

    /**
     * Merge configuration
     */
    private function mergeConfig()
    {
        // Get the Sae driver configuration
        $saeConfig = Config::get('sae');

        // Get the cache stores
        $cacheStores = Config::get('cache.stores');
        $cacheStores[$saeConfig['cache']['default']] = $saeConfig['cache']['stores'][$saeConfig['cache']['default']];

        // Merge the cache stores to the cache configuration
        Config::set([
            'default' => $saeConfig['cache']['default'],
            'stores' => $cacheStores
        ], 'cache');

        // Get the log channels
        $logChannels = Config::get('log.channels');
        $logChannels[$saeConfig['log']['default']] = $saeConfig['log']['channels'][$saeConfig['log']['default']];

        // Merge the log channel to the log configuration
        Config::set([
            'default' => $saeConfig['log']['default'],
            'channels' => $logChannels,
        ], 'log');

        // Merge the view configuration
        Config::set([
            'compile_type' => $saeConfig['view']['compile_type']
        ], 'view');

        // Get the database connections
        $databaseConnections = Config::get('database.connections');
        $databaseConnections[$saeConfig['database']['default']] = $saeConfig['database']['connections'][$saeConfig['database']['default']];

        // Merge the database configuration
        Config::set([
            'default' => $saeConfig['database']['default'],
            'connections' => $databaseConnections,
        ], 'database');
    }
}
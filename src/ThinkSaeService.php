<?php
/**
 * Author:  CodeSinging (The code is singing)
 * Email:   codesinging@gmail.com
 * Github:  https://github.com/codesinging
 * Time:    2020-05-18 21:13:30
 */

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
        $cacheStores['sae'] = $saeConfig['cache']['stores']['sae'];

        // Merge the cache stores to the cache configuration
        Config::set([
            'default' => 'sae',
            'stores' => $cacheStores
        ], 'cache');

        // Get the log channels
        $logChannels = Config::get('log.channels');
        $logChannels['sae'] = $saeConfig['log']['channels']['sae'];

        // Merge the log channel to the log configuration
        Config::set([
            'default' => 'sae',
            'channels' => $logChannels,
        ], 'log');

        // Merge the view configuration
        Config::set([
            'compile_type' => $saeConfig['view']['compile_type']
        ], 'view');

        // Get the database connections
        $databaseConnections = Config::get('database.connections');
        $databaseConnections['sae'] = $saeConfig['database']['connections']['sae'];

        // Merge the database configuration
        Config::set([
            'default' => 'sae',
            'connections' => $databaseConnections,
        ], 'database');

        // Merge the session configuration
        $sessionConfig = $saeConfig['session'];
        Config::set([
            'type' => $sessionConfig['type'],
        ], 'session');
    }
}
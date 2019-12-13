<?php
/**
 * Author: CodeSinging <codesinging@gmail.com>
 * Time: 2019/12/13 15:23
 */

use think\facade\Config;

if (defined('SAE_APPNAME')){
    Config::load(__DIR__.'/config/database.php', 'database');
    Config::load(__DIR__.'/config/cache.php', 'cache');
    Config::load(__DIR__.'/config/log.php', 'log');
    Config::load(__DIR__.'/config/template.php', 'template');
}

<?php
/**
 * Author: CodeSinging <codesinging@gmail.com>
 * Time: 2019/12/13 15:35
 */

return [
    // 数据库类型
    'type' => 'mysql',
    // 服务器地址
    'hostname' => SAE_MYSQL_HOST_M . ',' . SAE_MYSQL_HOST_S,
    // 数据库名
    'database' => SAE_MYSQL_DB,
    // 用户名
    'username' => SAE_MYSQL_USER,
    // 密码
    'password' => SAE_MYSQL_PASS,
    // 端口
    'hostport' => SAE_MYSQL_PORT,
    // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'deploy' => 1,
    // 数据库读写是否分离 主从式有效
    'rw_separate' => true,
];
<?php
/**
 * Author:  CodeSinging (The code is singing)
 * Email:   codesinging@gmail.com
 * Github:  https://github.com/codesinging
 * Time:    2020-05-18 21:13:30
 */

namespace CodeSinging\ThinkSae\Drivers;


use think\Exception;

class Template
{
    private $cache;
    private $contents = [];

    public function __construct()
    {
        $this->cache = new \Memcached();
        if (!$this->cache) {
            throw new Exception('新建 Memcached 实例错误');
        }
    }

    /**
     * 写入编译缓存
     * @access public
     * @param string $cacheFile 缓存的文件名
     * @param string $content 缓存的内容
     * @return void
     * @throws Exception
     */
    public function write(string $cacheFile, string $content): void
    {
        $content = $_SERVER['REQUEST_TIME'] . $content;

        if ($this->cache->set($cacheFile, $content, 0)) {
            $this->contents[$cacheFile] = $content;
            return;
        }
        throw new Exception('Sae memcached write error: ' . $cacheFile);
    }

    /**
     * 读取编译编译
     * @access public
     * @param string $cacheFile 缓存的文件名
     * @param array $vars 变量数组
     * @return void
     */
    public function read(string $cacheFile, array $vars = []): void
    {
        if (!empty($vars) && is_array($vars)) {
            // 模板阵列变量分解成为独立变量
            extract($vars, EXTR_OVERWRITE);
        }

        eval('?>' . $this->get($cacheFile, 'content'));
    }

    /**
     * 检查编译缓存是否有效
     * @access public
     * @param string $cacheFile 缓存的文件名
     * @param int $cacheTime 缓存时间
     * @return bool
     */
    public function check(string $cacheFile, int $cacheTime): bool
    {
        $mtime = $this->get($cacheFile, 'mtime');
        if (0 != $cacheTime && $_SERVER['REQUEST_TIME'] > $mtime + $cacheTime) {
            // 缓存是否在有效期
            return false;
        }
        return true;
    }

    /**
     * 读取文件信息
     * @access private
     *
     * @param string $filename 文件名
     * @param string $name 信息名 mtime或者content
     *
     * @return boolean
     */
    private function get($filename, $name)
    {
        if (!isset($this->contents[$filename])) {
            $this->contents[$filename] = $this->cache->get($filename);
        }
        $content = $this->contents[$filename];
        if (false === $content) {
            return false;
        }
        $info = array(
            'mtime' => substr($content, 0, 10),
            'content' => substr($content, 10),
        );
        return $info[$name];
    }
}
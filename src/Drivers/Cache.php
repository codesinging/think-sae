<?php
/**
 * Author:  CodeSinging (The code is singing)
 * Email:   codesinging@gmail.com
 * Github:  https://github.com/codesinging
 * Time:    2020-05-18 21:13:30
 */

namespace CodeSinging\ThinkSae\Drivers;


use think\cache\Driver;
use think\contract\CacheHandlerInterface;

/**
 * Sae Memcache cache driver for ThinkPHP 6
 * @package CodeSinging\ThinkSae\Drivers
 */
class Cache extends Driver implements CacheHandlerInterface
{
    /**
     * Cache handler
     * @var object
     */
    protected $handler = null;

    /**
     * Cache options
     * @var array
     */
    protected $options = [
        'expire' => 0,
        'timeout' => 0,
        'prefix' => '',
        'tag_prefix' => 'tag:',
        'serialize' => [],
    ];

    /**
     * Cache constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        if (!empty($options)) {
            $this->options = array_merge($this->options, $options);
        }

        $this->handler = new \Memcached();
    }

    /**
     * @param string $name
     * @param int $step
     * @return bool|false|int
     */
    public function inc(string $name, int $step = 1)
    {
        $key = $this->getCacheKey($name);

        if ($this->handler->get($key)) {
            return $this->handler->increment($key, $step);
        }

        return $this->handler->set($key, $step);
    }

    /**
     * @param string $name
     * @param int $step
     * @return false|int
     */
    public function dec(string $name, int $step = 1)
    {
        $key = $this->getCacheKey($name);
        $value = $this->handler->get($key) - $step;
        $res = $this->handler->set($key, $value);

        return !$res ? false : $value;
    }

    /**
     * Clear cache tag
     * @param array $keys
     */
    public function clearTag(array $keys)
    {
        $this->handler->deleteMulti($keys);
    }

    /**
     * Get cache value
     * @param string $key
     * @param null $default
     * @return mixed|string
     */
    public function get($key, $default = null)
    {
        $value = $this->handler->get($this->getCacheKey($key));
        return false !== $value ? $this->unserialize($value) : $default;
    }

    /**
     * Set cache value
     * @param string $key
     * @param mixed $value
     * @param null $expire
     * @return bool
     */
    public function set($key, $value, $expire = null)
    {
        if (is_null($expire)) {
            $expire = $this->options['expire'];
        }

        $key = $this->getCacheKey($key);
        $expire = $this->getExpireTime($expire);
        $value = $this->serialize($value);

        if ($this->handler->set($key, $value, $expire)) {
            return true;
        }

        return false;
    }

    /**
     * Delete a cache
     * @param string $key
     * @param bool $ttl
     * @return bool
     */
    public function delete($key, $ttl = false)
    {
        $key = $this->getCacheKey($key);
        return false === $ttl ? $this->handler->delete($key) : $this->handler->delete($key, $ttl);
    }

    /**
     * Clear all the caches
     * @return bool
     */
    public function clear()
    {
        return $this->handler->flush();
    }

    /**
     * Determine whether the cache existed.
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        $key = $this->getCacheKey($key);
        return $this->handler->get($key) ? true : false;
    }

    /**
     * Get cache key with prefix
     * @param string $name
     * @return string
     */
    public function getCacheKey(string $name): string
    {
        return $this->getAppVersion() . '/' . parent::getCacheKey($name);
    }

    /**
     * Get SAE app version
     * @return string
     */
    private function getAppVersion()
    {
        return $_SERVER['HTTP_APPVERSION'];
    }
}
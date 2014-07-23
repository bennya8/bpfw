<?php

/**
 * File Adapter
 * @namespace System\Cache\Adapter
 * @package system.cache.adapter.file
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013-2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Cache\Adapter;

use System\Cache\Cache;

class File extends Cache
{
    protected $path = 'Runtime/Cache';

    protected $node = 10;

    /**
     * Fetch cache data with given key
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        $file = $this->getKeyPath($key);
        return is_file($file) ? unserialize(file_get_contents($file)) : false;
    }

    /**
     * Write cache data with given key and value
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value)
    {
        return file_put_contents($this->getKeyPath($key), serialize($value));
    }

    /**
     * Delete cache data with given key
     * @param $key
     * @return mixed
     */
    public function remove($key)
    {
        return unlink($this->getKeyPath($key));
    }

    /**
     * Checks if the given key in the cache data
     * @param $key
     * @return mixed
     */
    public function has($key)
    {
        return is_file($this->getKeyPath($key));
    }

    /**
     * Free all data from cache data
     * @return mixed
     */
    public function flush()
    {
        for ($i = 0, $len = $this->node; $i < $len; $i++) {
            $path = ROOT_PATH . $this->path . '/' . $i . '/';
            if (is_dir($path)) {
                $files = scandir($path);
                foreach ($files as $file) {
                    if ($file !== '.' && $file !== '..' && is_file($path . $file)) {
                        unlink($path . $file);
                    }
                }
            }
        }
    }

    /**
     * Open a cache server connection
     * @return mixed
     */
    public function open()
    {
        for ($i = 0, $len = $this->node; $i < $len; $i++) {
            $nodePath = ROOT_PATH . $this->path . '/' . $i;
            if (!is_dir($nodePath)) mkdir($nodePath, 0777, true);
        }
    }

    /**
     * Close a cache server connect
     * @return mixed
     */
    public function close()
    {
        return true;
    }

    protected function getNodeKey($key)
    {
        return abs(crc32($key)) % $this->node;
    }

    protected function getKeyPath($key)
    {
        return ROOT_PATH . $this->path . '/' . $this->getNodeKey($key) . '/' . md5($key);
    }
}
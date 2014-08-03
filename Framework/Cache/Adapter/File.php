<?php

/**
 * File Adapter
 * @namespace System\Cache\Adapter
 * @package system.cache.adapter.file
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Cache\Adapter;

use System\Cache\Cache;

class File extends Cache
{

    /**
     * File cache path
     * @var string
     */
    protected $filePath = 'Runtime/Cache';

    /**
     * File cache node numbers
     * @var int
     */
    protected $fileNode = 10;

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
     * @access public
     * @param $key
     * @return mixed
     */
    public function has($key)
    {
        return is_file($this->getKeyPath($key));
    }

    /**
     * Increment numeric item's value
     * @access public
     * @param $key
     * @param int $offset
     * @param int $initialValue
     * @param int $expiry
     * @return mixed
     */
    public function increment($key, $offset = 1, $initialValue = 0, $expiry = 0)
    {
        // TODO: Implement increment() method.
    }

    /**
     * Decrement numeric item's value
     * @access public
     * @param $key
     * @param int $offset
     * @param int $initialValue
     * @param int $expiry
     * @return mixed
     */
    public function decrement($key, $offset = 1, $initialValue = 0, $expiry = 0)
    {
        // TODO: Implement decrement() method.
    }


    /**
     * Free all data from cache data
     * @access public
     * @return bool
     */
    public function flush()
    {
        for ($i = 0, $len = $this->fileNode; $i < $len; $i++) {
            $path = ROOT_PATH . $this->filePath . '/' . $i . '/';
            if (is_dir($path)) {
                $files = scandir($path);
                foreach ($files as $file) {
                    if ($file !== '.' && $file !== '..' && is_file($path . $file)) {
                        unlink($path . $file);
                    }
                }
            }
        }
        return true;
    }

    /**
     * Open a cache server connection
     * @access public
     * @return bool
     */
    public function open()
    {
        for ($i = 0, $len = $this->fileNode; $i < $len; $i++) {
            $nodePath = APP_PATH . $this->filePath . '/' . $i;
            if (!is_dir($nodePath)) mkdir($nodePath, 0777, true);
        }
        return true;
    }

    /**
     * Close a cache server connection
     * @access public
     * @return bool
     */
    public function close()
    {
        return true;
    }

    /**
     * Get cache key node
     * @access protected
     * @param string $key
     * @return int
     */
    protected function getNodeKey($key)
    {
        return abs(crc32($key)) % $this->fileNode;
    }

    /**
     * Get cache key path
     * @access protected
     * @param string $key
     * @return string
     */
    protected function getKeyPath($key)
    {
        return ROOT_PATH . $this->filePath . '/' . $this->getNodeKey($key) . '/' . md5($key);
    }

}
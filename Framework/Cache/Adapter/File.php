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

    public function get($key)
    {
        $file = $this->getKeyPath($key);
        return is_file($file) ? unserialize(file_get_contents($file)) : false;
    }

    public function set($key, $value)
    {
        return file_put_contents($this->getKeyPath($key), serialize($value));
    }

    public function remove($key)
    {
        return unlink($this->getKeyPath($key));
    }

    public function has($key)
    {
        return is_file($this->getKeyPath($key));
    }

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

    public function open()
    {
        for ($i = 0, $len = $this->node; $i < $len; $i++) {
            $nodePath = ROOT_PATH . $this->path . '/' . $i;
            if (!is_dir($nodePath)) mkdir($nodePath, 0777, true);
        }
    }

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
<?php

/**
 * Cache component abstract class
 * @namespace System\Cache
 * @package system.cache.cache
 * @author Benny <benny_a8@live.com>
 * @copyright ©2012-2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Cache;

use System\Core\Di,
    System\Core\Component;

abstract class Cache extends Component
{
    /**
     * Cache instance
     * @var object
     */
    private static $_instance = null;

    /**
     * Support list of cache adapter
     * @var array
     */
    private static $_drivers = array(
        'apc' => 'System\\Cache\\Adapter\\Apc',
        'file' => 'System\\Cache\\Adapter\\File',
        'memcached' => 'System\\Cache\\Adapter\\Memcached',
        'mongodb' => 'System\\Cache\\Adapter\\Mongodbs',
        'redis' => 'System\\Cache\\Adapter\\Redis',
        'xcache' => 'System\\Cache\\Adapter\\Xcache'
    );

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->config = $this->getDI('config')->get('component')['cache'];
        $adapter = $this->config['adapter'];
        if (!empty($this->config[$adapter]) && is_array($this->config[$adapter])) {
            foreach ($this->config[$adapter] as $propKey => $propValue) {
                if (property_exists($this, $propKey)) {
                    $this->$propKey = $propValue;
                }
            }
        }
        $this->open();
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * Cache factory
     * @throws \Exception
     * @return object
     */
    public static function factory()
    {
        $config = Di::factory()->get('config')->get('component')['cache'];
        if (!isset(self::$_drivers[$config['adapter']])) {
            throw new \Exception('unknown cache adapter');
        }
        $class = self::$_drivers[$config['adapter']];
        if (!self::$_instance instanceof $class) {
            self::$_instance = new $class();
        }
        return self::$_instance;
    }

    /**
     * Fetch cache data with given key
     * @param $key
     * @return mixed
     */
    abstract public function get($key);

    /**
     * Write cache data with given key and value
     * @param $key
     * @param $value
     * @return mixed
     */
    abstract public function set($key, $value);

    /**
     * Delete cache data with given key
     * @param $key
     * @return mixed
     */
    abstract public function remove($key);

    /**
     * Checks if the given key in the cache data
     * @param $key
     * @return mixed
     */
    abstract public function has($key);

    /**
     * Free all data from cache data
     * @return mixed
     */
    abstract public function flush();

    /**
     * Open a cache server connection
     * @return mixed
     */
    abstract public function open();

    /**
     * Close a cache server connect
     * @return mixed
     */
    abstract public function close();
}
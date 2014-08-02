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

use System\Core\Di;
use System\Core\Component;

abstract class Cache extends Component
{

    /**
     * Cache instance
     * @access private
     * @var object
     */
    private static $_instance = null;

    /**
     * Support list of cache adapter
     * @access private
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
        parent::__construct('cache');
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
     * @access public
     * @param string $adapter
     * @throws \Exception
     * @return object
     */
    public static function factory($adapter = '')
    {
        if (empty($adapter)) {
            $config = DI::factory()->get('config')->get('component');
            $adapter = $config['cache']['adapter'];
        }
        if (!isset(self::$_drivers[$adapter])) {
            throw new \Exception('unknown cache adapter');
        }
        $class = self::$_drivers[$adapter];
        if (!self::$_instance instanceof $class) {
            self::$_instance = new $class();
        }
        return self::$_instance;
    }

    /**
     * Fetch cache data with given key
     * @access public
     * @param $key
     * @return mixed
     */
    abstract public function get($key);

    /**
     * Write cache data with given key and value
     * @access public
     * @param $key
     * @param $value
     * @return mixed
     */
    abstract public function set($key, $value);

    /**
     * Delete cache data with given key
     * @access public
     * @param $key
     * @return mixed
     */
    abstract public function remove($key);

    /**
     * Checks if the given key in the cache data
     * @access public
     * @param $key
     * @return mixed
     */
    abstract public function has($key);

    /**
     * Increment numeric item's value
     * @param $key
     * @param int $offset
     * @param int $initialValue
     * @param int $expiry
     * @return mixed
     */
    abstract public function increment($key, $offset = 1, $initialValue = 0, $expiry = 0);

    /**
     * Decrement numeric item's value
     * @param $key
     * @param int $offset
     * @param int $initialValue
     * @param int $expiry
     * @return mixed
     */
    abstract public function decrement($key, $offset = 1, $initialValue = 0, $expiry = 0);

    /**
     * Free all data from cache data
     * @access public
     * @return bool
     */
    abstract public function flush();

    /**
     * Open a cache server connection
     * @access public
     * @return bool
     */
    abstract public function open();

    /**
     * Close a cache server connection
     * @access public
     * @return bool
     */
    abstract public function close();

}
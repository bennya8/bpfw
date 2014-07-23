<?php

/**
 * Session component abstract class
 * @namespace System\Session\Adapter
 * @package system.session.adapter.session
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Session;

use System\Core\Component;
use System\Core\DI;

abstract class Session extends Component
{
    /**
     * Session instance
     * @var object
     */
    private static $_instance;

    /**
     * Support list of session adapter
     * @var array
     */
    private static $_drivers = array(
        'database' => 'System\\Session\\Adapter\\Database',
        'file' => 'System\\Session\\Adapter\\File',
        'memcache' => 'System\\Session\\Adapter\\Memcache',
        'redis' => 'System\\Session\\Adapter\\Redis'
    );

    public function __construct()
    {
        parent::__construct('session');
    }

    /**
     * Session factory
     * @throws \Exception
     * @return object
     */
    public static function factory()
    {
        $config = DI::factory()->get('config')->get('component');
        $config = $config['session'];
        if (!isset(self::$_drivers[$config['adapter']])) {
            throw new \Exception('unknown session adapter');
        }
        $class = self::$_drivers[$config['adapter']];
        if (!self::$_instance instanceof $class) {
            self::$_instance = new $class();
        }
        return self::$_instance;
    }

    /**
     * Fetch session data with given key
     * @param $key
     * @return mixed
     */
    abstract public function get($key);

    /**
     * Write session data with given key and value
     * @param $key
     * @param $value
     * @return mixed
     */
    abstract public function set($key, $value);

    /**
     * Delete session data with given key
     * @param $key
     * @return mixed
     */
    abstract public function delete($key);

    /**
     * Checks if the given key in the session data
     * @param $key
     * @return mixed
     */
    abstract public function has($key);

    /**
     * Free all data from session data
     * @return mixed
     */
    abstract public function flush();

    /**
     * Destroy session
     * @return mixed
     */
    abstract public function destroy();

    /**
     * Get flash data with given key
     * @param $key
     * @return mixed
     */
    abstract public function getFlash($key);

    /**
     * Set flash data with key and value
     * @param $key
     * @param $value
     * @return mixed
     */
    abstract public function setFlash($key, $value);

    /**
     * Session open / connect method handler
     * @return mixed
     */
    abstract protected function _open();

    /**
     * Session close / disconnect method handler
     * @return mixed
     */
    abstract protected function _close();

    /**
     * Session fetch data method handler
     * @return mixed
     */
    abstract protected function _read();

    /**
     * Session write data method handler
     * @return mixed
     */
    abstract protected function _write();

    /**
     * Session destroy method handler
     * @return mixed
     */
    abstract protected function _destroy();

    /**
     * Session garbage collection method handler
     * @return mixed
     */
    abstract protected function _gc();
}
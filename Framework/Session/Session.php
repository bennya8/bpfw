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
     * @access private
     * @var object
     */
    private static $_instance;

    /**
     * Support list of session adapter
     * @access private
     * @var array
     */
    private static $_drivers = array(
        'database' => 'System\\Session\\Adapter\\Database',
        'file' => 'System\\Session\\Adapter\\File',
        'memcached' => 'System\\Session\\Adapter\\Memcached',
        'redis' => 'System\\Session\\Adapter\\Redis'
    );

    /**
     * Cache key prefix
     * @access protected
     * @var string
     */
    protected $prefix = 'sess_';

    /**
     * Cookie key name
     * @access protected
     * @var string
     */
    protected $name = 'session-connect';

    /**
     * Cookie expire
     * @access protected
     * @var int
     */
    protected $expire = 3600;

    /**
     * Encrypt session data
     * @access protected
     * @var bool
     */
    protected $encrypt = false;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct('session');
        session_name($this->name);
        session_cache_expire($this->expire);
        session_set_save_handler(
            array($this, '_open'),
            array($this, '_close'),
            array($this, '_read'),
            array($this, '_write'),
            array($this, '_destroy'),
            array($this, '_gc')
        );
    }

    /**
     * Fetch session data with given key
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     * Write session data with given key and value
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Delete session data with given key
     * @param $key
     * @return mixed
     */
    public function delete($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * Checks if the given key in the session data
     * @param $key
     * @return mixed
     */
    public function has($key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Free all data from session data
     * @return mixed
     */
    public function flush()
    {
        unset($_SESSION);
    }

    /**
     * Destroy session
     * @return mixed
     */
    public function destroy()
    {
        session_destroy();
    }

    /**
     * Get flash data with given key
     * @param $key
     * @return mixed
     */
    public function getFlash($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set flash data with key and value
     * @param $key
     * @param $value
     * @return mixed
     */
    public function setFlash($key, $value)
    {
        $key = 'flash_' . $key;
        $_SESSION[$key] = $value;
    }

    /**
     * Session factory
     * @access public
     * @param string $adapter
     * @throws \Exception
     * @return object
     */
    public static function factory($adapter = '')
    {
        if (empty($adapter)) {
            $config = DI::factory()->get('config')->get('component');
            $adapter = $config['session']['adapter'];
        }
        if (!isset(self::$_drivers[$adapter])) {
            throw new \Exception('unknown session adapter', E_ERROR);
        }
        $class = self::$_drivers[$adapter];
        if (!self::$_instance instanceof $class) {
            self::$_instance = new $class();
        }
        return self::$_instance;
    }

    /**
     * Session open / connect method handler
     * @access protected
     * @return boolean
     */
    abstract protected function _open();

    /**
     * Session close / disconnect method handler
     * @access protected
     * @return boolean
     */
    abstract protected function _close();

    /**
     * Session fetch data method handler
     * @access protected
     * @param array $data
     * @return array
     */
    abstract protected function _read($data);

    /**
     * Session write data method handler
     * @access protected
     * @param array $data
     * @return void
     */
    abstract protected function _write($data);

    /**
     * Session destroy method handler
     * @access protected
     * @param string $data
     * @return void
     */
    abstract protected function _destroy($data);

    /**
     * Session garbage collection method handler
     * @access protected
     * @param int $expire
     * @return void
     */
    abstract protected function _gc($expire);

}
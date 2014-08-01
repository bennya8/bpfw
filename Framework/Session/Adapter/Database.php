<?php

/**
 * Database Session
 * @namespace System\Session\Adapter
 * @package system.session.adapter.database
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Session\Adapter;

use System\Core\DI;
use System\Core\Request;
use System\Session\Session;

class Database extends Session
{
    private $_db;

    protected $databaseTable = 'pre_session';

    /**
     * Session open / connect method handler
     * @return bool
     */
    protected function _open()
    {
        $this->_db = DI::factory()->get('database');
        $sql = 'CREATE TABLE IF NOT EXISTS `' . $this->databaseTable . '` (
                  `session_id` varchar(40) NOT NULL,
                  `expire` int(10) unsigned NOT NULL,
                  `ip_address` varchar(60) NOT NULL,
                  `user_agent` varchar(120) NOT NULL,
                  `user_data` text NOT NULL,
                  PRIMARY KEY (`session_id`),
                  KEY `last_activity_idx` (`expire`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8';
        $this->_db->execute($sql);
        return (boolean)$this->_db;
    }

    /**
     * Session close / disconnect method handler
     * @return bool
     */
    protected function _close()
    {
        return true;
    }

    /**
     * Session fetch data method handler
     * @param array $data session data
     * @return array
     */
    protected function _read($data)
    {
        $sql = "SELECT user_data FROM {$this->databaseTable} WHERE `session_id` = '{$data[0]}'";
        $row = $this->_db->query($sql);
        return isset($row[0]) ? unserialize($row[0]['user_data']) : array();
    }

    /**
     * Session write data method handler
     * @param array $data session data
     * @return void
     */
    protected function _write($data)
    {
        $expire = time() + $this->expire;
        $user_data = serialize($data[1]);
        $sql = "SELECT session_id FROM {$this->databaseTable} WHERE `session_id` = '{$data[0]}'";
        $exist = $this->_db->query($sql);
        if ($exist) {
            $sql = "UPDATE {$this->databaseTable} SET `user_data` = '{$user_data}' , `expire` = '{$expire}'
                    WHERE `session_id` = '{$data[0]}'";
            $this->_db->execute($sql);
        } else {
            $request = new Request();
            $sql = "INSERT INTO {$this->databaseTable} (session_id,expire,ip_address,user_agent,user_data)
                    VALUES ('{$data[0]}','{$expire}','{$request->getUserIp()}','{$request->getUserAgent()}','{$user_data}')";
            $this->_db->execute($sql);
        }
    }

    /**
     * Session destroy method handler
     * @param array $data session data
     * @return void
     */
    protected function _destroy($data)
    {
        $sql = "DELETE FROM {$this->databaseTable} WHERE `session_id` = '{$data[0]}'";
        $this->_db->execute($sql);
    }

    /**
     * Session garbage collection method handler
     * @param int $expire
     * @return void
     */
    protected function _gc($expire)
    {
        $sql = "DELETE FROM {$this->databaseTable} WHERE `expire` <= {$expire}";
        $this->_db->execute($sql);
    }
}
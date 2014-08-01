<?php

/**
 * File Session
 * @namespace System\Session\Adapter
 * @package system.session.adapter.file
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Session\Adapter;

use System\Session\Session;

class File extends Session
{

    protected $filePath = 'Runtime/Session';

    /**
     * Session open / connect method handler
     * @return mixed
     */
    protected function _open()
    {
        return true;
    }

    /**
     * Session close / disconnect method handler
     * @return mixed
     */
    protected function _close()
    {
        return true;
    }

    /**
     * Session fetch data method handler
     * @param $data
     * @return mixed
     */
    protected function _read($data)
    {
        $file = APP_PATH . $this->filePath . '/' . $data[0];
        return is_file($file) ? unserialize(file_get_contents($file)) : array();
    }

    /**
     * Session write data method handler
     * @param $data
     * @return void
     */
    protected function _write($data)
    {
        $file = APP_PATH . $this->filePath . '/' . $data[0];
        file_put_contents($file, serialize($data[1]));
    }

    /**
     * Session destroy method handler
     * @param $data
     * @return void
     */
    protected function _destroy($data)
    {
        $file = APP_PATH . $this->filePath . '/' . $data[0];
        if (is_file($file)) unlink($file);
    }

    /**
     * Session garbage collection method handler
     * @param $expire
     * @return void
     */
    public function _gc($expire)
    {
        $path = APP_PATH . $this->filePath . '/';
        $files = scandir($path);
        $ignores = array('.', '..', '.DS_Store', '.svn', '.git');
        foreach ($files as $file) {
            if (!in_array($file, $ignores) && filemtime($path . $file) + $this->expire <= $expire) {
                unlink($path . $file);
            }
        }
    }

}
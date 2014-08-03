<?php

/**
 * Logger
 * @namespace System\Core
 * @package system.core.logger
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Core;

class Logger extends Component
{

    /**
     * Log trace level
     * @var string
     */
    protected $level = 'notice,info,warning,error,sql';

    /**
     * File path
     * @var string
     */
    protected $path = 'Runtime/Logs';

    /**
     * File name with format
     * @var string
     */
    protected $format = 'Ymd';

    /**
     * File volumes size
     * @var int
     */
    protected $size = 204800;

    /**
     * File extension
     * @var string
     */
    protected $extension = '.log';

    private $_logs = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct('logger');
        if (!is_dir(APP_PATH . $this->path)) mkdir(APP_PATH . $this->path, 0664, true);
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        $content = '';
        foreach ($this->_logs as $log) {
            $content .= $log . "\r\n";
        }
        $filename = APP_PATH . $this->path . '/' . date($this->format) . $this->extension;
        file_put_contents($filename, $content, FILE_APPEND | LOCK_EX);
    }

    /**
     * Log a message
     * @param mixed $message
     * @param string $type
     */
    public function log($message, $type = 'notice')
    {
        if (strpos($this->level, $type) !== false) {
            $this->_logs[] = date('y-m-d H:i:s') . ' [' . $type . '] ' . "\r\n" . var_export($message, true);
        }
    }

}
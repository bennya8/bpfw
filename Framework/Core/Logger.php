<?php

/**
 * Logger
 * @namespace System\Core;
 * @package system.core.logger
 * @author Benny <benny_a8@live.com>
 * @copyright ©2012-2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Core;

class Logger extends Component
{
    const NOTICE = 'Notice Error';
    const INFO = 'Info Error';
    const WARNING = 'Warning Error';
    const ERROR = 'Fatal Error';

    protected $filePath = '/Runtime/Logs/';
    protected $fileName = '';
    protected $fileSize = 204800;
    protected $fileFormat = 'Ymd';
    protected $fileExtension = '.log';

    public function __construct($fileName = '')
    {
        parent::__construct();

        $filePath = ROOT_PATH . $this->filePath;
        if (!empty($filename)) {
            if (!file_exists($filePath)) mkdir($filePath, 0755, true);
            $this->fileName = $filePath . date($this->fileFormat) . $this->fileExtension;
        } else {
            $this->fileName = $filePath . $fileName . $this->fileExtension;
        }
    }

    public function log($message, $type = self::INFO)
    {
        $breakLine = str_repeat("\r\n", 2);
        $content = date('Y-m-d H:i:s') . ' ' . $type . $breakLine;
        if (is_array($message) || is_object($message)) {
            $content .= var_export($message, true) . $breakLine;
        }
        file_put_contents($this->fileName, $content, FILE_APPEND);
    }
}
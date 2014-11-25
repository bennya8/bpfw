<?php

/**
 * @todo Upload helper
 * @namespace System\Helper;
 * @package system.helper.upload
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Helper;

class Upload
{

    private $_allowMimeType = array(
        'image/jpeg' => '.jpg',
        'image/gif' => '.git',
        'image/png' => '.png'
    );

    private $_uploadPath = '/upload/';

    private $_uploadMaxSize = 204800;


    public function getFiles($destDir)
    {
        if (!empty($_FILES)) {
            $uploadFiles = array();
            foreach ($_FILES as $field => $file) {
                if (is_string($file['name'])) {

                    if (array_key_exists($file['type'], $this->_allowMimeType)) {

                        $uploadName = md5(microtime()) . $this->_allowMimeType[$file['type']];
                        move_uploaded_file($file['tmp_name'], $this->_uploadPath . $uploadName);

                        $uploadFiles[$field]['state'] = 'success';
                        $uploadFiles[$field]['url'] = '/upload/' . $uploadName;
                        $uploadFiles[$field]['message'] = '';
                    } else {

                        $uploadFiles[$field]['state'] = 'error';
                        $uploadFiles[$field]['url'] = '';
                        $uploadFiles[$field]['message'] = 'file not allow';
                    }
                } else if (is_array($file['name'])) {
                    //@todo

                }
            }
            return $uploadFiles;
        } else {
            return false;
        }
    }
}




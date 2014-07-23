<?php

namespace System\Helper;

/**
 * 批量上传文件
 */
class FileUpload
{


    protected $path = 'Public/uploads';
    protected $maxSize = 10240;
    protected $allowType = array();
    protected $errorCode = 0;
    protected $errorMessage = '';


    public function uploadFile($name)
    {
        if (!isset($_FILES[$name])){




        }
        var_dump($_FILES);
    }

    protected function checkType(){

    }

}
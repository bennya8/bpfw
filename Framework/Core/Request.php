<?php

namespace System\Core;

class Request extends Component
{

    public function getData()
    {
    }

    public function get()
    {
    }

    public function getPost()
    {
    }


    public function isPost()
    {
    }

    public function isGet()
    {
    }

    public function isAjax()
    {
    }

    public function isPut()
    {
    }

    public function isDelete()
    {
    }


    public function getUserAgent()
    {
    }

    public function getUserIp()
    {
    }

    /**
     * 递归添加转义字符
     * @param mixed $data
     * @return mixed
     */
    public function filterEscape($data)
    {
        if (is_string($data)) return addslashes($data);
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $data[$k] = $this->filterEscape($v);
            }
        }
        return $data;
    }

    /**
     * 递归去除转义字符
     * @param mixed $data
     * @return mixed
     */
    public function filterUnescape($data)
    {
        if (is_string($data)) return stripslashes($data);
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $data[$k] = $this->filterUnescape($v);
            }
        }
        return $data;
    }
}

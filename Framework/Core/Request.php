<?php

namespace System\Core;

class Request //extends Component
{

    public function getParam()
    {


    }

    public function get($key, $default = '', $filter = false)
    {
        $_GET[$key] = isset($_GET[$key]) ? $_GET[$key] : $default;
        if ($filter) {
            $_GET[$key] = $this->filter($_GET[$key], $filter);
        } else {

        }
        return $_GET[$key];
    }

    public function getPost()
    {
    }


    public function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    public function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function isPut()
    {
        return $_SERVER['REQUEST_METHOD'] === 'PUT';
    }

    public function isDelete()
    {
        return $_SERVER['REQUEST_METHOD'] === 'DELETE';
    }

    public function isAjax()
    {


    }


    public function getUserAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    public function getUserIp()
    {
//        return $_SERVER['SERVER_NAME'];
    }

    public function filter($value, $filter)
    {
        $functions = array();
        if (is_string($filter) && strpos(',', $filter) !== false) {
            $functions = implode(',', $filter);
        }

        $value = call_user_func_array($functions, $value);

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


$_GET['user'] = "sdsd'f'''f";
$Request = new Request();
$resut = $Request->getUserIp();

var_dump($resut);
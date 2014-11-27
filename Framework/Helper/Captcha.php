<?php

/**
 * Captcha helper
 * @namespace System\Helper;
 * @package system.helper.captcha
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Helper;

class Captcha
{

    /**
     * Image width
     * @property int
     */
    public $width = 70;

    /**
     * @property int
     */
    public $height = 20;

    /**
     * Enable case sensitive validation
     * @property bool
     */
    public $caseSensitive = false;

    /**
     * Generate captcha binary data with jpeg format
     * @throws \Exception
     * @return void
     */
    public function generate()
    {
        if ($this->available()) {
            @ob_clean();
            $im = imagecreate($this->width, $this->height);
            $bgcolor = imagecolorallocate($im, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
            $fontcolor = imagecolorallocate($im, mt_rand(0, 160), mt_rand(0, 160), mt_rand(0, 160));
            $linecolor = imagecolorallocate($im, mt_rand(160, 255), mt_rand(160, 255), mt_rand(160, 255));
            $linecolor2 = imagecolorallocate($im, mt_rand(160, 255), mt_rand(160, 255), mt_rand(160, 255));
            imagefill($im, 0, 0, $bgcolor);
            $string = 'abcdefghijkmnopqrstuvxyzABCDEFGHIJKLJMPQRSTUVXYZ23456789';
            $char = substr(str_shuffle($string), 0, 6);
            imagestring($im, 12, 8, 2, $char, $fontcolor);
            $_SESSION['captcha_word'] = $char;
            imageline($im, 0, mt_rand(0, $this->height), $this->width, mt_rand(0, $this->height), $linecolor);
            imageline($im, 0, mt_rand(0, $this->height), $this->width, mt_rand(0, $this->height), $linecolor2);
            imagejpeg($im);
            header("content-type: image/jpeg");
            imagedestroy($im);
        } else {
            throw new \Exception('gd2 module not install', 500);
        }
    }

    /**
     * Validate captcha
     * @param $captcha
     * @return boolean
     */
    public function validate($captcha)
    {
        if ($this->caseSensitive) {
            return (boolean)$_SESSION['captcha_word'] === $captcha;
        } else {
            return (boolean)strtolower($_SESSION['captcha_word']) === strtolower($captcha);
        }
    }

    /**
     * Check gd extension available
     * @return bool
     */
    public function available()
    {
        return function_exists('gd_info');
    }

}
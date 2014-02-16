<?php

class JavascriptHelper
{

	/**
	 * 弹出Alert提示框
	 * @access public
	 * @param string $msg 提示信息
	 * @return void
	 */
	public static function Alert($msg)
	{
		echo '<script type="text/javascript">alert("' . $msg . '"); </script>';
	}

	public static function HistoryBack($back = '-1')
	{
		echo '<script type="text/javascript">history.back(' . $back . ')</script>';
	}

}
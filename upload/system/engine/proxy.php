<?php
/**
 * @package		OpenCart
 * @author		Daniel Kerr
 * @copyright	Copyright (c) 2005 - 2017, OpenCart, Ltd. (https://www.opencart.com/)
 * @license		https://opensource.org/licenses/GPL-3.0
 * @link		https://www.opencart.com
*/

/**
* Proxy class
*/
class Proxy {
    /**
     * 
     *
     * @param	string	$key
     */	
	public function &__get($key) {
		return $this->{$key};
	}	

    /**
     * 当设置类中不存在或者受保护的属性时，自动调用该方法
     *
     * @param	string	$key
	 * @param	string	$value
     */	
	public function __set($key, $value) {
		 $this->{$key} = $value;
	}

    /**
     * 在proxy代理类中，由于没有getCategory()方法，自动调用了魔术方法__call();
     * @param $key 方法名
     * @param $args 以数组的形式代表参数的集合
     * @return mixed
     */
	public function __call($key, $args) {
		$arg_data = array();

        // 返回包含方法名以及参数的数组，即array($key,$args)
		$args = func_get_args();
		
		foreach ($args as $arg) {
			if ($arg instanceof Ref) {
				$arg_data[] =& $arg->getRef();
			} else {
				$arg_data[] =& $arg;
			}
		}

		// $this->{$key} 指的是上文提到的通过$this->callback()返回的匿名函数
		if (isset($this->{$key})) {
		    // 执行该匿名函数,$arg_data:参数数组
            // 通过call_user_func_array(),最终执行到system/engine/loader.php中callback()方法里面的代码
			return call_user_func_array($this->{$key}, $arg_data);	
		} else {
			$trace = debug_backtrace();

			exit('<b>Notice</b>:  Undefined property: Proxy::' . $key . ' in <b>' . $trace[1]['file'] . '</b> on line <b>' . $trace[1]['line'] . '</b>');
		}
	}
}
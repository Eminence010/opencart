<?php
/**
 * @package		OpenCart
 * @author		Daniel Kerr
 * @copyright	Copyright (c) 2005 - 2017, OpenCart, Ltd. (https://www.opencart.com/)
 * @license		https://opensource.org/licenses/GPL-3.0
 * @link		https://www.opencart.com
*/

/**
 * Registry class
 * Registry是一个单例（Singleton），在index.php起始页面中，
 * 首先作为构造函数参数传递给所要用到的类创建类实例，并随之将这个类实例设置到这个“注册表”中，
 * 这个注册表就像是一个共享的数据总线一样，把各个模块/数据串联在一起。
*/
final class Registry {
	private $data = array();

	/**
     * 
     *
     * @param	string	$key
	 * 
	 * @return	mixed
     */
	public function get($key) {
		return (isset($this->data[$key]) ? $this->data[$key] : null);
	}

    /**
     * 
     *
     * @param	string	$key
	 * @param	string	$value
     */	
	public function set($key, $value) {
		$this->data[$key] = $value;
	}
	
    /**
     * 
     *
     * @param	string	$key
	 *
	 * @return	bool
     */
	public function has($key) {
		return isset($this->data[$key]);
	}
}
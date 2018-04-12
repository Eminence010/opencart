<?php
/**
 * @package        OpenCart
 * @author        Daniel Kerr
 * @copyright    Copyright (c) 2005 - 2017, OpenCart, Ltd. (https://www.opencart.com/)
 * @license        https://opensource.org/licenses/GPL-3.0
 * @link        https://www.opencart.com
 */

/**
 * Action class
 * 动作转向，也就是路径，比如 catalog下面的类ControllerAccountAddress就是对于account/address
 */
class Action {
	private $id;
	private $route;
	private $method = 'index';

	/**
	 * Constructor
	 *
	 * @param    string $route  文件路径+方法。
	 */
	public function __construct($route) {
		$this->id = $route;

		// explode 使用一个字符串分割另一个字符串
		$parts = explode('/', preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route));

		// Break apart the route
		while ($parts) {
		    // implode 将一个一维数组的值转化为字符串
			$file = DIR_APPLICATION . 'controller/' . implode('/', $parts) . '.php';

			// 参数是文件，method默认是index方法
			if (is_file($file)) {
			    // implode — 将一个一维数组的值转化为字符串
				$this->route = implode('/', $parts);

				break;
			} else {    // 参数是 文件+方法名
			    // 弹出并返回 array 数组的最后一个单元，并将数组 array 的长度减一
				$this->method = array_pop($parts);
			}
		}
	}

	/**
	 *
	 *
	 * @return    string
	 *
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 *
	 *
	 * @param    object $registry
	 * @param    array $args
	 */
	public function execute($registry, array $args = array()) {
		// Stop any magical methods being called
		if (substr($this->method, 0, 2) == '__') {
			return new \Exception('Error: Calls to magic methods are not allowed!');
		}

		$file = DIR_APPLICATION . 'controller/' . $this->route . '.php';
		$class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $this->route);

		// Initialize the class
		if (is_file($file)) {
			include_once($file);

			// 创建各个controller的实例
			$controller = new $class($registry);
		} else {
			return new \Exception('Error: Could not call ' . $this->route . '/' . $this->method . '!');
		}

        // 反射调用方法
		$reflection = new ReflectionClass($class);

		if ($reflection->hasMethod($this->method) && $reflection->getMethod($this->method)->getNumberOfRequiredParameters() <= count($args)) {
			return call_user_func_array(array($controller, $this->method), $args);
		} else {
			return new \Exception('Error: Could not call ' . $this->route . '/' . $this->method . '!');
		}
	}
}

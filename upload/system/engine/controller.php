<?php
/**
 * @package        OpenCart
 * @author        Daniel Kerr
 * @copyright    Copyright (c) 2005 - 2017, OpenCart, Ltd. (https://www.opencart.com/)
 * @license        https://opensource.org/licenses/GPL-3.0
 * @link        https://www.opencart.com
 */

/**
 * Controller class
 * 所有控制器的基类
 *
 * @property Document document
 * @property Loader load
 * @property Request request
 * @property Language language
 * @property Session session
 * @property Response response
 * @property Url url
 * @property Config config
 */
abstract class Controller {
	protected $registry;

	public function __construct($registry) {
		$this->registry = $registry;
	}

    // __get(), __set()函数在获取/设置非类定义成员变量的时候，会由PHP自动调用。
	public function __get($key) {
		return $this->registry->get($key);
	}

	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}
}
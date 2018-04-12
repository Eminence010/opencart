<?php
// Version
define('VERSION', '3.1.0.0b');

// Configuration
if (is_file('config.php')) {	// 如果文件存在且为正常的文件，则返回 true。
	require_once('config.php');	// 在脚本执行期间包含并运行指定文件.该文件中的代码已经被包含了，则不会再次包含
}

// Install
// 检查配置文件中是否配置了 项目目录，没有，跳转到安装。
if (!defined('DIR_APPLICATION')) {	// 检查某常量是否存在
	header('Location: ../install/index.php');	// 向客户端发送原始的 HTTP 报头
	exit;
}

// Startup
require_once(DIR_SYSTEM . 'startup.php');

start('admin');
<?php
//访问index.php，安全过滤、加载配置文件、核心启动文件、函数库、类库
// Version
define('VERSION', '3.1.0.0b');

// Configuration
if (is_file('config.php')) {
	require_once('config.php');
}

// Install
if (!defined('DIR_APPLICATION')) {
	header('Location: install/index.php');
	exit;
}

// Startup
require_once(DIR_SYSTEM . 'startup.php');

start('catalog');
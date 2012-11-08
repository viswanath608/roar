<?php

/*
	Roar
*/

define('DS', '/');
define('ENV', getenv('APP_ENV'));
define('VERSION', '0.1');

define('PATH', dirname(__FILE__) . DS);
define('APP', PATH . 'roar' . DS);
define('SYS', PATH . 'system' . DS);

require SYS . 'bootstrap.php';
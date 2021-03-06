<?php

require __DIR__ . '/../vendor/autoload.php';

if (!class_exists('Tester\Assert')) {
	echo "Install Nette Tester using `composer update --dev`\n";
	exit(1);
}

date_default_timezone_set('Europe/Prague');

Tester\Environment::setup();

define('TEMP_DIR', __DIR__ . '/temp');
//\Tester\Helpers::purge(__DIR__ . '/temp');

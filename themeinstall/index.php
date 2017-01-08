<?php

$changes = 0;
$writes = 0;

require('ugrsr.class.php');

$path = realpath(dirname(__FILE__) . '/../') . '/';
if(!$path) die('COULD NOT DETERMINE CORRECT FILE PATH');

if(!is_writeable($path.'index.php')) {
	die('index.php not writeable');
}

$theme_install = new UGRSR($path);
$theme_install->file_search = false;

$theme_install->addFile('index.php');
$theme_install->addPattern('~// Url~', '//Unlimited colors theme
$theme = $config->get( $config->get( \'config_template\') . \'_skin\'  );
$store = \'default\';
if($config->get( \'config_store_id\' ) == 0) { 
	$store = \'default\';
} else {
	$store = $config->get( \'config_store_id\' );
}

require_once(DIR_SYSTEM . \'library/themeoptions.php\');
$theme_options = new ThemeOptions($config->get(\'config_template\'), $store, $theme);
$registry->set(\'theme_options\', $theme_options);

');

$result = $theme_install->run();
$writes += $result['writes'];
$changes += $result['changes'];

if(!$changes) die('TEMPLATE ALREADY INSTALLED!');
if($writes != 1) die('ONE OR MORE FILES COULD NOT BE WRITTEN');
die('TEMPLATE HAS BEEN INSTALLED ON YOUR SYSTEM!');
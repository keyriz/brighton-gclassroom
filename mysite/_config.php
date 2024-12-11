<?php

global $project;
$project = 'mysite';

global $databaseConfig;
$databaseConfig = array(
	'type'     => 'MySQLDatabase',
	'server'   => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'dbbt_gclassroom',
	'path'     => ''
);

// Set the site locale
i18n::set_locale('en_US');

// Log error
if (Director::isTest()) {
	SS_Log::add_writer(new SS_LogFileWriter('../silverstripe-warnings.log'), SS_Log::WARN);
	SS_Log::add_writer(new SS_LogFileWriter('../silverstripe-errors.log'), SS_Log::ERR);
}

if (Director::isLive()) {
	SS_Log::add_writer(new SS_LogEmailWriter('mo.rizrama@gmail.com'), SS_Log::ERR);
}

<?php

// This is the database connection configuration.
return array(
    /*
	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
    */
	// uncomment the following lines to use a MySQL database
	
	'connectionString' => 'mysql:host=localhost;dbname=cms_sigma',
	'emulatePrepare' => true,
	'username' => 'sigma',
	'password' => '12345',
	'charset' => 'utf8',
	
);
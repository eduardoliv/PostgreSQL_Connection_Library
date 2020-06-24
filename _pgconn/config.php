<?php

/**
 * PostgreSQL connection configuration
 *
 * Defines the user's DB connection settings. PostgreSQL username, host and port can be found at pgAdmin's
 * page --> Servers->PostgreSQL 12->Properties->Connection.
 * 
 * PHP version 7
 *
 * @author     Eduardo Oliveira <eduardo.oliveira@ieee.org>
 * @copyright  IPCA-EST. All rights reserved.
 * @version    SVN: 0.0.1
 */

// Set DB Host
define('DB_HOST','127.0.0.1');

// Set DB Port
define('DB_PORT','5432');

// Set DB Username
define('DB_USER','postgres');

// Set DB Password
define('DB_PASS','xxxxxxxxx'); // FIXME: Specify the DB Password

// Set DB Name 
define('DB_NAME','xxxxxxxxx'); // FIXME: Specify the DB name

// Set DB Charset
define('CHARSET','UTF8');

// Set Default Time Zone
date_default_timezone_set("Europe/Lisbon");

?>

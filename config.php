<?php

/**
  * Configuration for database connection
  *
  */

include "./include-files/autoload.php";

$host = getenv('DB_HOST');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');

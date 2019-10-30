<?php

/**
  * Configuration for database connection
  *
  */
include "../autoload.php";

$host       = env('DB_HOST');
$username   = env('DB_USERNAME');
$password   = env('DB_PASSWORD');
$dbname     = env('DB_NAME')
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );
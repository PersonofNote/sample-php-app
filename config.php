<?php

/**
  * Configuration for database connection
  *
  */

//Local development
include "autoload.php";

$host = getenv('DB_HOST');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');

/*
$env_var = getenv("CLEARDB_DATABASE_URL");
$url = parse_url($env_var);

$host = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);
echo $db;
$dsn        = "mysqli:host=$host;dbname=$db";
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );
*/

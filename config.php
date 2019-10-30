<?php

/**
  * Configuration for database connection
  *
  */

//Local development
//include "autoload.php";

$url = parse_url(getenv("CLEARDB_DATABASE_URL"))

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);
$dsn        = "mysql:host=$host;dbname=$db";
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );
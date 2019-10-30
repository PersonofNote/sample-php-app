<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');


$env_var = getenv("CLEARDB_DATABASE_URL");
$url = parse_url($env_var);

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);
$dsn        = "mysqli:host=$host;dbname=$db";
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );
/**
  * Open a connection via PDO to create a
  * new database and table with structure.
  *
  */

//require "config.php";

try {
  $connection = new PDO("mysqli:host=$host", $username, $password, $options);
  $sql = file_get_contents("data/init.sql");
  $connection->exec($sql);

  echo "Database and tables created successfully.";
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
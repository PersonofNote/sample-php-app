<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

/**
  * Open a connection via PDO to create a
  * new database and table with structure.
  *
  */

require "config.php";

try {
  $connection = new PDO("mysqli:host=$host", $username, $password, $options);
  $sql = file_get_contents("/database/init.sql");
  $connection->exec($sql);

  echo "Database and tables created successfully.";
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
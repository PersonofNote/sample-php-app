<?php

$server = env('DB_HOST');
$username = env('DB_USERNAME');
$password = env('DB_PASSWORD');
$dbname = env('DB_DATABASE');

$db = new mysqli($server, $username, $password, $dbname) or die("Could not connect to the database");


//ClearDB environment variables for heroku production
/*
$url = parse_url(getenv("CLEARDB_DATABASE_URL")); //Heroku's cleardb addon requires URL parsing.

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$dbname = substr($url["path"], 1);
*/

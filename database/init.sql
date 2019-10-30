CREATE DATABASE IF NOT EXISTS cleardb-graceful-17842;

  use cleardb-graceful-17842;

  CREATE TABLE users (
    userid INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(45) NOT NULL,
    email VARCHAR(80) NOT NULL,
    password VARCHAR(50),
  );

  CREATE TABLE tasks (
    taskid INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    task VARCHAR(255) NOT NULL,
    duration TINYINT(4) NOT NULL,
    username VARCHAR(45),
  );
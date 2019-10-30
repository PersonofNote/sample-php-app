<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

  //Load environment variables
  include "./autoload.php";

  //Initialize variables
  $errors = "";
  $task_array = [];

  //local database environment variables
  $DB_HOST = env('DB_HOST');
  $DB_USERNAME = env('DB_USERNAME');
  $DB_PASSWORD = env('DB_PASSWORD');
  $DB_NAME = env('DB_NAME');

  //ClearDB environment variables
  //ClearDB environment variables
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$dbname = substr($url["path"], 1);

  //User login and session info
  session_start(); 
  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
?>
<?php include "templates/header.php"; ?>
<!-- notification message -->
<?php if (isset($_SESSION['success'])) : ?>
<div class="error success">
  <h3>
    <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
  </h3>
</div>
<?php endif ?>

<!-- logged in user information -->
<?php  if (isset($_SESSION['username'])) :
      $thisuser = $_SESSION['username']; //TODO change to use ID instead of username to join tables
  
  /** Task submission info 
   * 
   *  TODO: DRY out (currently repeating some code from server.php)
   * 
  */
 // $db = mysqli_connect($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME) or die("Could not connect to the database");
  $db = new mysqli($server, $username, $password, $dbname);
  $listdbtables = array_column(mysqli_fetch_all($db->query('SHOW TABLES')),0); //For debugging
	if (isset($_POST['submit'])) {
		if (empty($_POST['task'])) {
      $errors = "You must fill in the task";
		}else{
      $task = $_POST['task'];
      $task_duration = $_POST['task_duration'];
      $query = "INSERT INTO tasks (task, duration, username) 
  			  VALUES('$task', '$task_duration', '$thisuser')";
      $result = mysqli_query($db, $query);
      if ($result) {
        header('location: index.php');
    } else {
        echo ("Could not insert data. ");
    }
		}
  }

  //delete
if (isset($_GET['del_task'])) {
	$id = $_GET['del_task'];

	mysqli_query($db, "DELETE FROM tasks WHERE taskid=".$id);
	header('location: index.php');
}
     ?>
<?php endif ?>
<p class="logout"> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
<div class="header">
  <h2><strong><?php echo $thisuser . "'s Tasks"; ?></strong></h2>
</div>
<div class="content">
<?php if (isset($errors)) { ?>
<p><?php echo $errors; ?></p>
<?php } ?>
  <form method="post" action="index.php" class="input_form">
    <label for="task"> What do you want to do? </label>
    <input type="text" name="task" class="task_input">
    <label for="task_duration"> For how many minutes? </label>
    <input type="number" name="task_duration" class="task_input">
    <button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>
  </form>
  <table class="tasks-table">
    <thead>
      <tr>
        <th> All Tasks</th>
      </tr>
    </thead>

    <tbody>
      <?php 
    // select all tasks if page is visited or refreshed
   // $tasks = mysqli_query($db, "SELECT * FROM tasks")
    $tasks = mysqli_query($db, "SELECT * FROM users JOIN tasks ON users.username = tasks.username WHERE users.username = '$thisuser'")
      or die("Error: ".mysqli_error($db)); ?>
      <?php //Loop over and display tasks
		$i = 1; while ($row = mysqli_fetch_array($tasks)) {
      array_push($task_array, $row);
       ?>
      <tr>
        <td class="task"> <?php echo $row['task'] . ": "; ?> </td>
        <td class="duration"> <?php echo ($row['duration']) . " minutes"; ?> </td>
        <td class="delete">
          <a href="index.php?del_task=<?php echo $row['taskid'] ?>">x</a>
        </td>
      </tr>
      <?php $i++; } ?>
    </tbody>
  </table>
  <div class="no-results">
        <?php 
    //echo mysqli_num_rows($tasks);
    if(mysqli_num_rows($tasks) < 1) {
      echo "No tasks found";
    }
    ?>
     </div>
  <div class="day-sections">

  </div>
</div>


<?php include "templates/footer.php"; ?>
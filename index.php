<?php
include "./include-files/autoload.php";
include "./include-files/db-variables.php";

error_reporting(E_ALL);
ini_set('display_errors', '1');

//Initialize variables
$errors = "";
$task_array = [];

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
 
      
  // Task submission info
$listdbtables = array_column(mysqli_fetch_all($db->query('SHOW TABLES')), 0) or die("Error: ".mysqli_error($db)); //For debugging
if (isset($_POST['submit'])) {
    if (empty($_POST['task'])) {
        $errors = "You must fill in the task";
    //TODO: Add logic to make error time out.
    } else {
        $task = $_POST['task'];
        $task_duration = $_POST['task_duration'];
        $query = "INSERT INTO tasks (task, duration, username) 
VALUES('$task', '$task_duration', '$thisuser')";
        $result = mysqli_query($db, $query);
        if ($result) {
            //pass
        } else {
            echo("Could not insert data. ");
        }
    }
}

  //delete
if (isset($_GET['del_task'])) {
    $id = $_GET['del_task'];

    mysqli_query($db, "DELETE FROM tasks WHERE taskid=".$id);
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
<?php include "./include-files/task-form.php" ?>
  <div class="tasks">
    
      <?php
    // select all tasks if page is visited or refreshed
   // $tasks = mysqli_query($db, "SELECT * FROM tasks")
    $tasks = mysqli_query($db, "SELECT * FROM users JOIN tasks ON users.username = tasks.username WHERE users.username = '$thisuser'")
      or die("Error: ".mysqli_error($db)); ?>
      <?php //Loop over and display tasks
        $i = 1; while ($row = mysqli_fetch_array($tasks)) {
            array_push($task_array, $row); ?>
      <div>
        <span class="task"> <?php echo $row['task'] . ": "; ?> </span>
        <span class="duration"> <?php echo($row['duration']) . " minutes"; ?> </span>
        <span class="delete">
          <a href="index.php?del_task=<?php echo $row['taskid'] ?>">x</a>
        </span>
      </div>
      <?php $i++;
        } ?>
  </>
  <div class="no-results">
        <?php
    if (mysqli_num_rows($tasks) < 1) {
        echo "No tasks found";
    }
    ?>
     </div>
  <div class="day-sections">

  </div>
</div>


<?php include "templates/footer.php"; ?>
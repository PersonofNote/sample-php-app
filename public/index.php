<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
//Load environment variables
  include "../autoload.php";

  /** Task submission info 
   * 
   *  TODO: DRY out (currently repeating some code from server.php)
   * 
  */
  $errors = "";

  //database environment variables
  $DB_HOST = env('DB_HOST');
  $DB_USERNAME = env('DB_USERNAME');
  $DB_PASSWORD = env('DB_PASSWORD');
  $DB_NAME = env('DB_NAME');

  $db = mysqli_connect($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

	// insert a quote if submit button is clicked
	if (isset($_POST['submit'])) {
		if (empty($_POST['task'])) {
      $errors = "You must fill in the task";
		}else{
			$task = $_POST['task'];
      $sql = "INSERT INTO tasks (task) VALUES ('$task')";
			mysqli_query($db, $sql);
      header('location: index.php');
		}
  }
  

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
<div class="header">
  <h2>Home</h2>
</div>
<div class="content">
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
  <?php  if (isset($_SESSION['username'])) : ?>
  <?php if (isset($errors)) { ?>
  <p><?php echo $errors; ?></p>
  <?php } ?>
  <?php endif ?>
  <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
  <p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
  <form method="post" action="index.php" class="input_form">
    <label for="task"> What do you want to do? </label>
    <input type="text" name="task" class="task_input">
    <label for="task_time"> For how many minutes? </label>
    <input type="number" name="task_time" class="task_input">
    <button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>
  </form>
  <table>
    <thead>
      <tr>
        <th>Tasks</th>
      </tr>
    </thead>

    <tbody>
      <?php 
		// select all tasks if page is visited or refreshed
    $tasks = mysqli_query($db, "SELECT * FROM tasks")
      or die("Error: ".mysqli_error($db));
    $array = mysqli_fetch_array($tasks); ?>

    <div class="TESTARRAY">
    <?php echo $array; ?>
    </div>
     <?php 
     $i = 0; while ($i < 5) { ?>
    <tr>
      <td class="task"> Lorem </td>
      <td class="delete">
        <a href="index.php?del_task=<?php echo $row['id'] ?>">x</a>
      </td>
    </tr>
    <?php $i++; } ?>
   <?php //Loop over and display tasks
		$i = 0; while ($row = mysqli_fetch_array($tasks)) { ?>
      <tr>
        <td class="task"> <?php echo $row['task']; ?> </td>
        <td class="delete">
          <a href="index.php?del_task=<?php echo $row['id'] ?>">x</a>
        </td>
      </tr>
      <?php $i++; } ?>
    </tbody>
  </table>
</div>
<?php include "templates/footer.php"; ?>
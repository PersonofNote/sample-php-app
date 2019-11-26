<?php
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
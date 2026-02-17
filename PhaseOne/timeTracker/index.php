<?php
//main oage of the time tracker
//takes all tasks from the db and shows them in a table also allows users to edit or delete tasks from the page
require_once 'timeTracker/connect.php';

$pageTitle = 'All Tasks';

//get all tasks from the db by date
$sql = "SELECT * FROM tasks ORDER BY due_date ASC";
$stmt = $pdo->query($sql);
$tasks = $stmt->fetchAll*();

//calcualte the numbers for the stat cards
$totalTasks = count($tasks); //total num of tasks
$totalHours = 0; 
$highCount = 0; //how many are high prio

//adds tasks hours to total and adds high prio count
foreach($tasks as $task){
    $totalHours += $task['time_spent']; 
    if($task['priority'] === 'High'){
        $highCount++;
    }
}

include 'includes/header.php';
?>



<?php
//main page of the time tracker
//takes all tasks from the db and shows them in a table also allows users to edit or delete tasks from the page
require_once 'timeTracker/connect.php';

$pageTitle = 'All Tasks';

//get all tasks from the db by date
$sql = "SELECT * FROM tasks ORDER BY due_date ASC";
$stmt = $pdo->query($sql);
$tasks = $stmt->fetchAll();

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

<div class="row justify-content-center">
    <div class="col-lg-10">

        
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">All Tasks</h4>
                <a href="add.php" class="btn btn-light btn-sm">+ Add Task</a>
            </div>
             <!-- has the stats -->
            <div class="card-body">
                <div class="row g-3 mb-4 text-center">
                    <div class="col-6 col-md-4">
                        <div class="card border-primary h-100">
                            <div class="card-body">
                                <h3 class="text-primary mb-1"><?php echo $totalTasks; ?></h3>
                                <p class="text-muted small mb-0">Total Tasks</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="card border-success h-100">
                            <div class="card-body">
                                <h3 class="text-success mb-1"><?php echo number_format($totalHours, 1); ?> h</h3>
                                <p class="text-muted small mb-0">Hours Logged</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="card border-danger h-100">
                            <div class="card-body">
                                <h3 class="text-danger mb-1"><?php echo $highCount; ?></h3>
                                <p class="text-muted small mb-0">High Priority</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- if there isnt any tasks just show empty-->
                <?php if (empty($tasks)) { ?>

                    <div class="text-center py-5">
                        <h5 class="text-muted mb-3">No tasks yet</h5>
                        <a href="add.php" class="btn btn-primary">Add Your First Task</a>
                    </div>

                <?php } else { ?>

                    <!-- table for all tasks-->
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Task Name</th>
                                    <th>Category</th>
                                    <th>Priority</th>
                                    <th>Due Date</th>
                                    <th>Hours</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $rowNum = 1;  // row counter for the # column
                                // choosing css class for the badge
                                foreach ($tasks as $task) {
                                    $badgeClass = 'badge-medium';
                                    if ($task['priority'] === 'High') $badgeClass = 'badge-high';
                                    elseif ($task['priority'] === 'Low') $badgeClass = 'badge-low';

                                    // date format
                                    $formattedDate = date('M d, Y', strtotime($task['due_date']));

                                    //if its overdue make it red
                                    $isOverdue = strtotime($task['due_date']) < strtotime(date('Y-m-d'));
                                ?>
                                <tr class="<?php if ($isOverdue) echo 'table-danger'; ?>">
                                    <td><?php echo $rowNum; ?></td>
                                    <td><?php echo htmlspecialchars($task['task_name']); ?></td>
                                    <td><?php echo htmlspecialchars($task['category']); ?></td>
                                    <td>
                                        <span class="<?php echo $badgeClass; ?>">
                                            <?php echo htmlspecialchars($task['priority']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo $formattedDate; ?></td>
                                    <td><?php echo number_format($task['time_spent'], 2); ?> h</td>
                                    <td>
                                        <!--edit link -->
                                        <a href="edit.php?id=<?php echo $task['id']; ?>" 
                                           class="btn btn-sm btn-outline-primary me-1">Edit</a>
                                        
                                        <!-- delete -->
                                        <form action="delete.php" method="POST" class="d-inline" 
                                              onsubmit="return confirmDelete();">
                                            <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php $rowNum++; } ?>
                            </tbody>
                        </table>
                    </div>

                    <p class="text-muted text-end mt-3 small">
                        Showing <?php echo $totalTasks; ?> task(s) — <?php echo number_format($totalHours, 2); ?> total hours
                    </p>

                <?php } ?>

            </div> 
        </div> 
    </div>
</div>

<?php include 'includes/footer.php'; ?>




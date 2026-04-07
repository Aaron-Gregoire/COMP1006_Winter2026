<?php
// shows form, validates data, saves new task to the db, goes back to index
require_once 'includes/auth.php';
require_once 'includes/connect.php';


$pageTitle = "Add Task";

$errors   = [];
$formData = [];

//chack if submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $formData['task_name']  = trim($_POST['task_name'] ?? '');
    $formData['category']   = trim($_POST['category'] ?? '');
    $formData['priority']   = trim($_POST['priority'] ?? '');
    $formData['due_date']   = trim($_POST['due_date'] ?? '');
    $formData['time_spent'] = trim($_POST['time_spent'] ?? '');

    //validation
    if (empty($formData['task_name'])) {
        $errors['task_name'] = 'Task name is required.';
    }
    if (empty($formData['category'])) {
        $errors['category'] = 'Category is required.';
    }
    if (empty($formData['priority']) || !in_array($formData['priority'], ['High','Medium','Low'])) {
        $errors['priority'] = 'Please select a valid priority.';
    }
    if (empty($formData['due_date'])) {
        $errors['due_date'] = 'Due date is required.';
    }
    if ($formData['time_spent'] === '' || !is_numeric($formData['time_spent']) || (float)$formData['time_spent'] < 0) {
        $errors['time_spent'] = 'Time spent must be a positive number.';
    }
//file uploading
if (!empty($_FILES['attachment']['name']) && empty($errors)) {
    $file = $_FILES['attachment'];
    $maxSize = 5 * 1024 * 1024; 
    $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if ($file['error'] === 0 && $file['size'] <= $maxSize && in_array($ext, $allowedExt)) {
        
        $newName = 'task_' . uniqid() . '.' . $ext;
        $uploadDir = 'uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $targetPath = $uploadDir . $newName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $attachmentPath = $targetPath;
        } else {
            $errors['attachment'] = "failed to save file";
        }
    } else {
        $errors['attachment'] = "only jpg, png, gif or pdf files under 5mb are allowed";
    }
}

    //save to db
    if (empty($errors)) {
        try {
            $sql = "INSERT INTO tasks (task_name, category, priority, due_date, time_spent, user_id, attachment)
                        VALUES (:task_name, :category, :priority, :due_date, :time_spent, :user_id, :attachment)";

            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':task_name',  $formData['task_name']);
            $stmt->bindParam(':category',   $formData['category']);
            $stmt->bindParam(':priority',   $formData['priority']);
            $stmt->bindParam(':due_date',   $formData['due_date']);
            $stmt->bindParam(':time_spent', $formData['time_spent']);
            $stmt->bindParam(':user_id',    $_SESSION['user_id']);
            $stmt->bindParam(':attachment', $attachmentPath);


            $stmt->execute();

            //back to main if sucess
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $errors['db'] = "Database error occurred.";
        }
    }
}

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Add New Task</h4>
            </div>
            <div class="card-body">

                <!-- show db error if it broke -->
                <?php if (!empty($errors['db'])) { ?>
                    <div class="alert alert-danger"><?php echo $errors['db']; ?></div>
                <?php } ?>

                <!-- running the js and php validation on the form-->
                <form action="add.php" method="POST" onsubmit="return validateTaskForm()" novalidate>

                    <div class="mb-3">
                        <label for="task_name" class="form-label">Task Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?php if(isset($errors['task_name'])) echo 'is-invalid'; ?>"
                               id="task_name" name="task_name" value="<?php echo htmlspecialchars($formData['task_name'] ?? ''); ?>">
                        <?php if(isset($errors['task_name'])) { ?>
                            <div class="invalid-feedback"><?php echo $errors['task_name']; ?></div>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?php if(isset($errors['category'])) echo 'is-invalid'; ?>"
                               id="category" name="category" placeholder="e.g. Work, School, Personal"
                               value="<?php echo htmlspecialchars($formData['category'] ?? ''); ?>">
                        <?php if(isset($errors['category'])) { ?>
                            <div class="invalid-feedback"><?php echo $errors['category']; ?></div>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <label for="priority" class="form-label">Priority <span class="text-danger">*</span></label>
                        <select class="form-select <?php if(isset($errors['priority'])) echo 'is-invalid'; ?>"
                                id="priority" name="priority">
                            <option value="">-- Select Priority --</option>
                            <option value="High"   <?php if(($formData['priority']??'')==='High')   echo 'selected'; ?>>High</option>
                            <option value="Medium" <?php if(($formData['priority']??'')==='Medium') echo 'selected'; ?>>Medium</option>
                            <option value="Low"    <?php if(($formData['priority']??'')==='Low')    echo 'selected'; ?>>Low</option>
                        </select>
                        <?php if(isset($errors['priority'])) { ?>
                            <div class="invalid-feedback"><?php echo $errors['priority']; ?></div>
                        <?php } ?>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="due_date" class="form-label">Due Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control <?php if(isset($errors['due_date'])) echo 'is-invalid'; ?>"
                                   id="due_date" name="due_date" value="<?php echo htmlspecialchars($formData['due_date'] ?? ''); ?>">
                            <?php if(isset($errors['due_date'])) { ?>
                                <div class="invalid-feedback"><?php echo $errors['due_date']; ?></div>
                            <?php } ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="time_spent" class="form-label">Time Spent (hours) <span class="text-danger">*</span></label>
                            <input type="number" step="0.25" min="0" class="form-control <?php if(isset($errors['time_spent'])) echo 'is-invalid'; ?>"
                                   id="time_spent" name="time_spent" placeholder="e.g. 2.5"
                                   value="<?php echo htmlspecialchars($formData['time_spent'] ?? ''); ?>">
                            <div class="form-text">1.5 = 1 hour 30 minutes</div>
                            <?php if(isset($errors['time_spent'])) { ?>
                                <div class="invalid-feedback"><?php echo $errors['time_spent']; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <!--buttons-->
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">Add Task</button>
                        <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>
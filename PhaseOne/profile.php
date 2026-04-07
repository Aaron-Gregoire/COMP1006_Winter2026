<?php
require_once 'includes/auth.php';
require_once 'includes/connect.php';

$pageTitle = "profile";

$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //change password
    if (isset($_POST['change_password'])) {
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $errors[] = "all password fields are required";
        } elseif (strlen($newPassword) < 8) {
            $errors[] = "new password must be at least 8 characters";
        } elseif ($newPassword !== $confirmPassword) {
            $errors[] = "new passwords do not match";
        } else {
            $stmt = $pdo->prepare("SELECT password FROM users WHERE id = :id");
            $stmt->bindParam(':id', $_SESSION['user_id']);
            $stmt->execute();
            $user = $stmt->fetch();

            if ($user && password_verify($currentPassword, $user['password'])) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
                $stmt->bindParam(':password', $hashedPassword);
                $stmt->bindParam(':id', $_SESSION['user_id']);
                $stmt->execute();
                $success = "password updated successfully";
            } else {
                $errors[] = "current password is incorrect";
            }
        }
    }

    //delete account
    if (isset($_POST['delete_account'])) {
        $confirmDelete = $_POST['confirm_delete'] ?? '';
        if ($confirmDelete !== 'DELETE') {
            $errors[] = "please type DELETE to confirm.";
        } else {
            try {
                //delete users tasks
                $stmt = $pdo->prepare("DELETE FROM tasks WHERE user_id = :user_id");
                $stmt->bindParam(':user_id', $_SESSION['user_id']);
                $stmt->execute();

                //delete user
                $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
                $stmt->bindParam(':id', $_SESSION['user_id']);
                $stmt->execute();

                session_destroy();
                header("location: login.php");
                exit;
            } catch (PDOException $e) {
                $errors[] = "error deleting account";
            }
        }
    }
}

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">profile</h4>
            </div>
            <div class="card-body">

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $err): ?>
                                <li><?= htmlspecialchars($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>

                <h5>account information</h5>
                <p><strong>email:</strong> <?= htmlspecialchars($userEmail) ?></p>
                <hr>

                <h5 class="mt-4">change password</h5>
                <form method="POST" onsubmit="return validateChangePassword()">
                    <input type="hidden" name="change_password" value="1">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">current password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">new password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">confirm new password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">update password</button>
                </form>

                <hr class="my-4">

                <h5 class="text-danger">delete account</h5>
                <p class="text-muted">this will permanently delete your account and all your tasks.</p>
                <form method="POST" onsubmit="return confirmDeleteAccount()">
                    <input type="hidden" name="delete_account" value="1">
                    <div class="mb-3">
                        <label for="confirm_delete" class="form-label">type <strong>DELETE</strong> to confirm</label>
                        <input type="text" class="form-control" id="confirm_delete" name="confirm_delete" placeholder="DELETE" required>
                    </div>
                    <button type="submit" class="btn btn-danger">delete my account</button>
                </form>

            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>    
    
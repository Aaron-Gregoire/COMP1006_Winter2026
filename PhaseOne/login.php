<?php
session_start();
require_once 'includes/connect.php';
$pageTitle = "login";

$error = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';
    

    //recaptcha varification 
    $secretKey = '6Le6I6wsAAAAAF_L52SpdvPZyr8cDN307UwvuWHu'; 
    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$recaptchaResponse");
    $recaptchaData = json_decode($verify);    

    if (!$recaptchaData->success) {
        $error = "please complete the recaptcha verification";
    } elseif (empty($email) || empty($password)) {
        $error = "email and password are required";
    } else {
        $sql = "SELECT id, email, password FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];

            header("Location: index.php");
            exit;
        } else {
            $error = "invalid email or password.";
        }
    }
}
include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Login</h4>
            </div>
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <!-- recaptcha -->
                    <div class="mb-3">
                        <div class="g-recaptcha" data-sitekey="6Le6I6wsAAAAAP2sJ36LnBJns_MXkAqQU-_d36rJ"></div> 
                    </div>

                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href="register.php" class="btn btn-outline-secondary ms-2">create account</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php include 'includes/footer.php'; ?>
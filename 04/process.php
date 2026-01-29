<?php
require "includes/header.php"; //requires the header.php file

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    echo"<p>This page expects a POST form submission.</p>";
    exit;
}
//sanitizing the inputs 
$fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_SPECIAL_CHARS); 
$lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);


//validation
$errors = [];

//required fields 
if($fname === null || $fname === ''){
    $errors[] = "First name is required.";
}
// email validation
if($email === null || $email ===''){
    $errors[] = "Email is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors[] = "Email address must be a valid email.";
}
//message
if($message === null || $message ===''){
    $errors[] = "Message is required";
}
//error handling
if(!empty($errors)){
    require "includes/header.php";
    echo "<h2>There were some issues:</h2>";
    echo "<ul style='color: red;'>";
    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo"</ul>";
    echo"<p><a href='index.php'>Go back to the form</a></p>";
    require "includes/footer.php";
    exit;
    }
// no errros
    $to = "bitumi@gmail.com";
    $subject = "Customer Message";

    $body = "Message received:\n\n";
    $body .= "Name: $fname $lname\n";
    $body .= "Email: $email\n";
    $body .= "Message: \n$message\n";
   //email headers for customer to allow bakery to reply to customer 
    $header = "From: no-reply@bitumi.com\r\n"; 
    $header .= "Reply-To: $email\r\n";
    $header .= "Content-Type: text/plain; charset=UTF-8\r\n";

    require "send-email.php";

    require "includes/header.php";

    echo"<h1>Thank You!</h1>";
    echo"<p>Your message was sent to the bakery.</p>";
    echo"<h2>Info Submitted:</h2>";
    echo"<p><strong>Name:</strong> " . htmlspecialchars($fname) . " " . htmlspecialchars($lname) . "</p>";
    echo"<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>";
    echo"<p><strong>Message:</strong><br> " . nl2br(htmlspecialchars($message)) . "</p>";

    require "includes/footer.php";
?>




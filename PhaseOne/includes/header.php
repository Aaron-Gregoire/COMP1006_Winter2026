<?php
//creates html head, load bootstrap, syles and makes nav bar

if(!isset($pageTitle)){
    $pageTitle = "Time Tracker";
}
?>

<!DOCKTYPE html>
<html lang = "en">
<head>
    <meta charset="UTF-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0">

    <title><?php echo htmlspecialchars($pageTitle); ?> | Time Tracker</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link href="css/styles.css" rel="stylesheet">
</head>

<body class="bg-light">   

<!-- nav bar for every page -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        

        <!-- menu botton -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- menu items -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">  
                <li class="nav-item">
                    <a class="nav-link" href="index.php">All Tasks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="add.php">+ Add Task</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4 mb-5">
    


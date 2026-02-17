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

    


<?php 
require "header.php"; 
echo "<p> Follow the instructions outlined in instructions.txt to complete this lab. Good luck & have fun!😀 </p>";
require "footer.php"; 
require "car.php";

$myCar = new Car("Toyota", "Corolla", 2020); // create an instance of the car class
echo $myCar->getCarInfo();// display the car info


/* i found the lab pretty easy because it was really just using what we learned today in class to create an object and then create an instance of that object. i didnt really find anything tricky or difficult about this lab. */
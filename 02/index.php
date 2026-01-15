<?php 
declare (strict_types=1);

//setup and start

//2. Code Commenting 

// inline comment 
/* 
multi line comment 
*/

//3. Variables, Data Types, Concatenation, Conditional Statements & Echo

$firstName = "joe"; // string
$lastName = "mama"; // string
$age = 100; // int
$isInstructor = true; // boolean 

echo "<p> Hello my name is " .$firstName. " " .$lastName. "</p>";

if ($isInstructor) {
    echo "<p> I am your teacher </p>";
}
else {
    echo "<p> Oops, teach didnt show! </p>";
}



//4. Loosely Typed Language Demo

$num1 = 1;
$num2 = 10;

function add (int $num1, int $num2) : int {
    return $num1 + $num2;
}

echo "<p>" . add($num1, $num2) . "</p>";



//5. Strict Types & Types Hints



//6. OOP with PHP 

class Person {
    public string $name;
    public int $age;
    public bool $isInstructor;

    public function __construct(string $name, int $age, bool $isInstructor)
    {
        $this->name = $name;
        $this->age = $age;
        $this->isInstructor = $isInstructor;
    }

    public function getBadge(): string
    {
        $role = $this->isInstructor ? "Instructor" : "Student";
        return "Name : {$this->name} | Age: {$this->age} | Role: $role";
    }
}

//create an instance of object

$person = new Person("joe mama", 20, true);


//use the object 

echo $person->getBadge();
<?php
class Car { // creating object class car
    public string $make; // defining variables
    public string $model;
    public int $year;

    public function __construct(string $make, string $model, int $year) {
        $this->make = $make; // assigning values to the variables
        $this->model = $model;
        $this->year = $year;
    }

    public function getCarInfo(): string //method to return car info
    {
        return "{$this->year} {$this->make} {$this->model}";
    }
}


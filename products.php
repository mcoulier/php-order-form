<?php
class Products {
    // Properties
    public $name;
    public $price;
//    public $food;
//    public $drinks;

    function __construct($name, $price){
        $this->name = $name;
        $this->price = $price;
    }
    function __destruct(){
        echo "You ordered {$this->name} and it costs €{$this->price}.";
    }
}

$clubHam = new Products("Club Ham", 3.20);
$clubCheese = new Products("Club Cheese", 3);
$clubCheeseHam = new Products("Club Cheese & Ham", 4);
$clubChicken = new Products("Club Chicken", 4);
$clubSalmon = new Products("Club Salmon", 5);
$cola = new Products("Cola", 2);
$fanta = new Products("Fanta", 2);
$sprite = new Products("Sprite", 2);
$iceTea = new Products("Ice-Tea", 3);


<?php
class products {
    // Properties
    public $name;
    public $price;
//    public $type;

    function __construct($name, $price){
        $this->name = $name;
        $this->price = $price;
//        $this->type = $type;
    }

    function get_name(){
        return $this->name;
    }

    function get_price(){
        return $this->price;
    }

//    function __destruct(){
//        echo "You ordered {$this->name} and it costs €{$this->price}.";
//    }
}

$clubHam = new products("Club Ham", 3.20);
$clubCheese = new products("Club Cheese", 3);
$clubCheeseHam = new products("Club Cheese & Ham", 4);
$clubChicken = new products("Club Chicken", 4);
$clubSalmon = new products("Club Salmon", 5);
$cola = new products("Cola", 2);
$fanta = new products("Fanta", 2);
$sprite = new products("Sprite", 2);
$iceTea = new products("Ice-Tea", 3);

$food = array();
array_push($food, $clubHam, $clubCheese, $clubCheeseHam, $clubChicken, $clubSalmon);
foreach ($food as $value){
    echo $value->get_name();
    echo $value->get_price();
}

$drinks = array();
array_push($drinks, $cola, $fanta, $sprite, $iceTea);
foreach ($drinks as $value){
    echo $value->get_name();
    echo $value->get_price();
}
<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

//we are going to use session variables so we need to enable sessions
session_start();

function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}
//Getting input data forms.
//Error handling if field is empty
$emailErr = $streetErr = $streetNumberErr = $cityErr = $zipcodeErr = "";
$email = $street = $streetNumber = $city = $zipcode = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"]) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "* E-mail is required";
    } else {
        $email = getData($_POST["email"]);
    }

    if (empty($_POST["street"]) || !preg_match("/^[a-zA-Z]+$/", $street)) {
        $streetErr = "* Street name is required";
    } else {
        $street = getData($_POST["street"]);
    }

    if (empty($_POST["streetNumber"]) || !preg_match('/^[1-9][0-9]*$/', $streetNumber)) {
        $streetNumberErr = "* Street number is required";
    } else {
        $streetNumber = getData($_POST["streetNumber"]);
    }

    if (empty($_POST["city"]) || !preg_match("/^[a-zA-Z]+$/", $city)) {
        $cityErr = "* City name is required";
    } else {
        $city = getData($_POST["city"]);
    }

    if (empty($_POST["zipcode"]) || !preg_match('/^[1-9][0-9]*$/', $zipcode)) {
        $zipcodeErr = "* Zipcode is required";
    } else {
        $zipcode = getData($_POST["zipcode"]);
    }
}
function getData ($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
//    var_dump($data);
    return $data;
}

//your products with their price.
$products = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5]
];

$products = [
    ['name' => 'Cola', 'price' => 2],
    ['name' => 'Fanta', 'price' => 2],
    ['name' => 'Sprite', 'price' => 2],
    ['name' => 'Ice-tea', 'price' => 3],
];

$totalValue = 0;

require 'form-view.php';
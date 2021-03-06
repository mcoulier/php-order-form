<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

//we are going to use session variables so we need to enable sessions
session_start();

//Get info from class file
require 'products.php';

//Setting timezone for correct hour
date_default_timezone_set("Europe/Brussels");

//Session variables
if (!isset($_SESSION['email'])) {
    $_SESSION['email'] = "";
}
if (!isset($_SESSION['street'])) {
    $_SESSION['street'] = "";
}
if (!isset($_SESSION['streetNumber'])) {
    $_SESSION['streetNumber'] = "";
}
if (!isset($_SESSION['city'])) {
    $_SESSION['city'] = "";
}
if (!isset($_SESSION['zipcode'])) {
    $_SESSION['zipcode'] = "";
}

//Cookie variables
if (!isset($_COOKIE['cookieTotal'])) {
    $_COOKIE['cookieTotal'] = 0;
} else{
    $totalValue = $_COOKIE['cookieTotal'];

}

/*function whatIsHappening()
{
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}*/

$emailErr = $streetErr = $streetNumberErr = $cityErr = $zipcodeErr = "";
$email = $street = $streetNumber = $city = $zipcode = "";
$deliveryTime = $confirmation = "";
$order = array();
$totalValue = 0;

//$xDeliveryTime = date("H:i", strtotime("+45 Minutes"));

//your products with their price.
/*$food = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5]
];

$drinks = [
    ['name' => 'Cola', 'price' => 2],
    ['name' => 'Fanta', 'price' => 2],
    ['name' => 'Sprite', 'price' => 2],
    ['name' => 'Ice-tea', 'price' => 3],
];*/

//To fix error on homepage and show "food" as default
if (!isset($_SESSION['products'])) {
    $products = $food;
} else {
    $products = $_SESSION['products'];
}

//If food in url = 1 display food, otherwise drinks, also change the session to correct array.
if (isset($_GET['food'])) {
    if ($_GET['food'] == 1) {
        $products = $food;
        $_SESSION['products'] = $food;
    } else {
        $products = $drinks;
        $_SESSION['products'] = $drinks;
    }
}

//Getting input data forms.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

//Session variables take data from post variables.
    $_SESSION['email'] = $_POST["email"];
    $_SESSION['street'] = $_POST["street"];
    $_SESSION['streetNumber'] = $_POST["streetNumber"];
    $_SESSION['city'] = $_POST["city"];
    $_SESSION['zipcode'] = $_POST["zipcode"];

//Error handling if field is empty or incorrect.
    if (empty($_POST["email"]) ){
        $email = "";
        } else {
        $email = getData($_POST['email']);
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
            $emailErr = "Invalid email";
        }
    }

    if (empty($_POST["street"]) || !preg_match("/^[a-zA-Z]+$/", $_POST["street"])) {
        $streetErr = "* Street name is required";
    } else {
        $street = getData($_POST["street"]);
    }

    if (empty($_POST["streetNumber"]) || !preg_match('/^[1-9][0-9]*$/', $_POST["streetNumber"])) {
        $streetNumberErr = "* Street number is required";
    } else {
        $streetNumber = getData($_POST["streetNumber"]);
    }

    if (empty($_POST["city"]) || !preg_match("/^[a-zA-Z]+$/", $_POST["city"])) {
        $cityErr = "* City name is required";
    } else {
        $city = getData($_POST["city"]);
    }

    if (empty($_POST["zipcode"]) || !preg_match('/^[1-9][0-9]{3}+$/', $_POST["zipcode"])) {
        $zipcodeErr = "* Zipcode is required";
    } else {
        $zipcode = getData($_POST["zipcode"]);
    }

    if ($emailErr == "" && $streetErr == "" && $streetNumberErr == "" && $cityErr == "" && $zipcodeErr == "") {

        //Loop array to get price when selected
        for ($i = 0; $i <= count($products); $i++) {
            if (isset($_POST["products"][$i])) {
                $totalValue += $products[$i]['price'];
                array_push($order, $products[$i]['name']);
                setcookie("cookieTotal", strval($totalValue), time() + (86400 * 30), "/");
            }
        }


        //If express delivery is checked, increase value by 5 and delivery time by 45min, else 2 hours & no charge
        if (isset($_POST['express_delivery'])) {
            $totalValue += 5;
            $deliveryTime = date("H:i", strtotime("+45 Minutes"));
        } else {
            $deliveryTime = date("H:i", strtotime("+2 Hours"));
        }

        $msg = "Your order of: " . implode(", ", $order) . " will arrive at: " . $deliveryTime;
//        $headers = 'From: MacBook Pro van Michiel' . "\r\n" .
//            'Reply-To: MacBook Pro van Michiel' . "\r\n" .
//            'X-Mailer: PHP/' . phpversion();

        echo $msg;
//        mail('dixeja9741@wpsavy.com', 'Your Order', $msg, $headers);

        $confirmation = "Your order has been sent and will arrive at: " . $deliveryTime . ".";
    }
}

function getData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
//    var_dump($data);
    return $data;
}

//whatIsHappening();
require 'form-view.php';

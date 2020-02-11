<?php
declare(strict_types=1);
ini_set('display_errors', "1"); // om foutmeldingen te tonen
session_start();

$totalValue = 0;
$products =[];
//$_COOKIE["total"]=$totalValue;  // om totaal bestelling in cookies op te slaan ook email en die checken om user te identificieren
//$_COOKIE["email"]; // bepaalde tijd instellen voor die cookies en die anders maken

// define variables and set to empty values

// for the adress
$email = $street = $streetnr = $city = $zipcode = $consomation = "";
// for the error messages
$emailErr = $streetErr = $streetnrErr = $cityErr = $zipcodeErr = "";
// de postwaarden uit het formulier halen

//if (!empty($_POST)) { // if submitted  for the adress
if ($_SERVER["REQUEST_METHOD"] == "POST"){

    function test_input(string $data) // trimmen, stripslashes and specialchars
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        // functie op validation page aanroepen voor validatie?
        return (string) $data;
    }
    if (empty($_POST["email"])) {
        $emailErr = "* Email is required";
    } else {
        $email=test_input($_POST["email"]);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) { // deze filter werkt niet waterdicht, beter zelf schrijven maar voorlopig bij gebrek aan tijd
            $email=test_input($_POST["email"]);
            // to save the data for a longer term then a session, and to id the user you need the email
           // $_COOKIE["email"]="$email";  // nog eens checken voor de exacte schrijfwijze
            // to save the data per session
               $_SESSION["email"]=$email;
        }else{
            $emailErr = "* Invalid email format!";
        }
    }

    if (empty($_POST["street"])) {
        $streetErr = "* Street is required";
    } else {
        $street=test_input($_POST["street"]);  // straat ophalen
        $_SESSION["street"]=$street;
    }
    if (empty($_POST["streetnumber"])) {
        $streetnrErr = "* Streetnumber is required";

    } else {
        $streetnr=test_input($_POST["streetnumber"]); // nr ophalen
        if(is_numeric($streetnr)){                      // test if number
            $streetnr=test_input($_POST["streetnumber"]); // nr ophalen
            // to save during one session
             $_SESSION["streetnr"]=$streetnr;
        }else{
            $streetnrErr = "* It has to be a number!";
        }
    }

    if (empty($_POST["city"])) {
        $cityErr = "* City is required";
    } else {
        $city=test_input($_POST["city"]); // dorp/gemeente/stad ophalen
        // to save during one session
        $_SESSION["city"]=$city;
    }

    if (empty($_POST["zipcode"])) {
        $zipcodeErr = "* Zipcode is required";
    } else {
        $zipcode=test_input($_POST["zipcode"]); // postnummer ophalen
        if(is_numeric($zipcode)){               // test if number
            $zipcode=test_input($_POST["zipcode"]); // postnummer ophalen
            // to save during one session
            $_SESSION["zipcode"]=$zipcode;
        }else{
            $zipcodeErr = "* It has to be a number!";
        }
       var_dump($_POST);
        if (!empty($_POST['products'])) { // kan die met ne for each doorlopen en zo de waarden er uit halen
            //echo '<H1>'.($response['forms'][0]['name']).'</H1>';  // dat er hier uitkrijgen en dan nog: die waarden checked laten in de html+ doorsturen naar ontvangst file
            //$order=$consomation[0]['name']=$_POST["products"];
            //echo $order;
            //$price=$_POST["name"];
        }
        // nog checken of effectief alles goed is én verzonden! dan pas die boodschap tonen
        echo '<p class="textAbove">Your order has been send! :)</p>';
    }

   // date_default_timezone_set("America/New_York");
//echo "Today is " . date("d-m-Y") . "<br>";  // this works and is for the confirmation page
//echo "The time is " . date("H:i:s");
    
 // om de bestelling te mailen  //https://www.w3schools.com/php/func_mail_mail.asp

//define("COOK", "ann.kemp@scarlet.be"); // constant for resto adress
//$subject = "My order:";
    // bij bestelling de bestelling nog bijvoegen, prijs en andere stuff needed
//$bestelling ="mail:".$email."\r\n adress:".$street.",".$streetnr." - ".$zipcode." ".$city;
//$headers = "From: ".$email . "\r\n" .
//"CC: ".$email;

//mail(COOK,$subject,$bestelling,$headers);
}
$products = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5]
];

// via de get-waarden de juiste producten selecteren food of drink en dan tonen
if (!empty($_GET)) {
$foodnr=$_GET['food'];

if($foodnr==1){
    // om spul te tonen
      // echo '<H1>'.($response['forms'][0]['name']).'</H1>';
$products = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5]
];
//setcookie("food", $products, time() + (86400 * 30), "/");
    //  echo print_r($_COOKIE["food"]);
}
 if($foodnr==0) {

     $products = [
         ['name' => 'Cola', 'price' => 2],
         ['name' => 'Fanta', 'price' => 2],
         ['name' => 'Sprite', 'price' => 2],
         ['name' => 'Ice-tea', 'price' => 3],
     ];
//setcookie("drinks", $products, time() + (86400 * 30), "/");
 }
}else{
    echo '<p class="textAbove">Please, choose something to eat or drink!</p>';
}
// code schrijven om de geselecteerde waarden op te tellen en in de session te steken
    // to change a session variable, just overwrite it
//$_SESSION["favcolor"] = "yellow";
//print_r($_SESSION);
require 'form.php';
?>
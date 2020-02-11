<?php
declare(strict_types=1);
session_start();
$totalValue = 0;
$_SESSION["total"]=$totalValue;  // om waarden in de sessies op te slaan

ini_set('display_errors', "1"); // om foutmeldingen te tonen

// define variables and set to empty values

// for the adress
$email = $street = $streetnr = $city = $zipcode = "";
// for the error messages
$emailErr = $streetErr = $streetnrErr = $cityErr = $zipcodeErr = "";
// de postwaarden uit het formulier halen

//if (!empty($_POST)) { // if submitted
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

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) { // deze filter werkt niet waterdicht, beter zelf schrijven maar voorlopig bij gebrek aan tijd
            $email=test_input($_POST["email"]);
        }else{
            $emailErr = "* Invalid email format!";
        }
    }

    if (empty($_POST["street"])) {
        $streetErr = "* Street is required";
    } else {
        $street=test_input($_POST["street"]);  // straat ophalen
    }

    if (empty($_POST["streetnumber"])) {
        $streetnrErr = "* Streetnumber is required";

    } else {
        $streetnr=test_input($_POST["streetnumber"]); // nr ophalen
        if(is_numeric($streetnr)){                      // test if number
            $streetnr=test_input($_POST["streetnumber"]); // nr ophalen
        }else{
            $streetnrErr = "* It has to be a number!";
        }
    }

    if (empty($_POST["city"])) {
        $cityErr = "* City is required";
    } else {
        $city=test_input($_POST["city"]); // dorp/gemeente/stad ophalen
    }

    if (empty($_POST["zipcode"])) {
        $zipcodeErr = "* Zipcode is required";
    } else {
        $zipcode=test_input($_POST["zipcode"]); // postnummer ophalen
        if(is_numeric($zipcode)){               // test if number
            $zipcode=test_input($_POST["zipcode"]); // postnummer ophalen
        }else{
            $zipcodeErr = "* It has to be a number!";
        }
    }

   // date_default_timezone_set("America/New_York");
//echo "Today is " . date("d-m-Y") . "<br>"; echo "The time is " . date("H:i:s");
    
 // om de bestelling te mailen  
//https://www.w3schools.com/php/func_mail_mail.asp
define("COOK", "ann.kemp@scarlet.be"); // constant for resto adress
$subject = "My order:";
    // bij bestelling de bestelling nog bijvoegen, prijs en andere stuff needed
$bestelling ="mail:".$email."\r\n adress:".$street.",".$streetnr." - ".$zipcode." ".$city;
$headers = //"From: kok@example.com" . "\r\n" .
"CC: ".$email;

mail(COOK,$subject,$bestelling,$headers);
 
}

// via de get-waarden de juiste producten selecteren food of drink
if (!empty($_GET)) {
$foodnr=$_GET['food'];

    
if($foodnr===1){    
   // nog wat code schrijven om de producten te tonen 
    // dit komt van de form-page
 /*   <?php foreach ($products AS $i => $product): ?>
                <label>
                    <input type="checkbox" value="1" name="products[<?php echo $i ?>]"/> <?php echo $product['name'] ?> -
                    &euro; <?php echo number_format($product['price'], 2) ?></label><br />
            <?php endforeach; ?>       */
    // om spul te tonen
      // echo '<H1>'.($response['forms'][0]['name']).'</H1>';
$products = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5]
];
}
 if($foodnr===0){ 
     // nog wat code schrijven om de producten te tonen 
$products = [
    ['name' => 'Cola', 'price' => 2],
    ['name' => 'Fanta', 'price' => 2],
    ['name' => 'Sprite', 'price' => 2],
    ['name' => 'Ice-tea', 'price' => 3],
];
 }
}else{
    echo "Please, choose something to eat or drink!";
}
// code schrijven om de geselecteerde waarden op te tellen en in de session te steken
    // to change a session variable, just overwrite it
//$_SESSION["favcolor"] = "yellow";
//print_r($_SESSION);
require 'form.php';
?>
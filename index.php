<?php
declare(strict_types=1);
ini_set('display_errors', "1"); // om foutmeldingen te tonen
session_start();

// initiate variables
$totalValue = 0;
$cookie_email="";
$cookie_total=0;
$products =[];

// start/setup the cookies for the total amount calculation  // dit moet ik nog uittesten
setcookie($cookie_email, $cookie_total, time() + (86400 * 30), "/"); // 86400 = 1 day * 30 is for a month

// initiate variables for the adress
$email = $street = $streetnr = $city = $zipcode = $consumation = "";
// initiate variables for the error messages
$emailErr = $streetErr = $streetnrErr = $cityErr = $zipcodeErr = "";


//if (!empty($_POST)) { // if submitted  for the adress
if ($_SERVER["REQUEST_METHOD"] == "POST"){  // --------start post data ---------------------------------------------------------------------------------------------

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
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) { // deze filter werkt niet waterdicht, beter zelf schrijven maar voorlopig bij gebrek aan tijd . . .
            $email=test_input($_POST["email"]);

            $cookie_email=$email;
            $cookie_total=$totalValue;
//$_COOKIE["total"]=$totalValue;  // om totaal bestelling in cookies op te slaan ook email en die checken om user te identificieren
//$_COOKIE["email"]; // bepaalde tijd instellen voor die cookies en die anders maken

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
        $street=test_input($_POST["street"]);  // get street
        $_SESSION["street"]=$street;
    }
    if (empty($_POST["streetnumber"])) {
        $streetnrErr = "* Streetnumber is required";

    } else {
        $streetnr=test_input($_POST["streetnumber"]); // get number
        if(is_numeric($streetnr)){                      // test if number
            $streetnr=test_input($_POST["streetnumber"]); // get number
            // to save during one session
             $_SESSION["streetnr"]=$streetnr;
        }else{
            $streetnrErr = "* It has to be a number!";
        }
    }

    if (empty($_POST["city"])) {
        $cityErr = "* City is required";
    } else {
        $city=test_input($_POST["city"]); // get city
        // to save during one session
        $_SESSION["city"]=$city;
    }

    if (empty($_POST["zipcode"])) {
        $zipcodeErr = "* Zipcode is required";
    } else {
        $zipcode = test_input($_POST["zipcode"]); // get zipcode
        if (is_numeric($zipcode)) {               // test if number
            $zipcode = test_input($_POST["zipcode"]); // get zipcode
            // to save during one session
            $_SESSION["zipcode"] = $zipcode;
        } else {
            $zipcodeErr = "* It has to be a number!";
        }
    }
         //var_dump($_POST);
        // get the products out of the array to send them
        if(!empty($_POST['products'])) {
            $contents = $_POST['products'];
            // var_dump($contents);

            foreach ($contents as $x => $x_value) {
               // echo "Product: " . $x . ", Price: " . $x_value;  // to show/test what's in it
               // echo "<br>";
                $foodDrink = $x;
                $price = $x_value;
                // nog een session van maken om deze ook naar een andere pagina door te geven waar je de bestellingen toont
               // $_SESSION["zipcode"] = $zipcode; how to set a session with two values? have to search it!
                // maybe with the array as value? so $contents in a session so you need to do a foreach again to get to the values?
            }
        }
//------------------------------------------------------ calculate the delivery time after choosing the mode: normal or express ---------------------------------------------
            // the delivery choiche
            $delivery_time=0; // initialise vars

         if(!empty($_POST['delivery'])) { // check of they have chosen a delivery way! if true:

             $delivery=$_POST['delivery'];
             //echo $delivery;  // for testing the content/data

           if (isset($delivery) && $delivery=="normal"){ // if isset and they have choosen normal delivery
                // delivery time of 2 hours
               $time=date("h");
                // the time + two for the delivery-time
               $time=$time+2;
                echo '<p class="textAbove">The delivery time is ' . date("$time:i")."</p>";
                $delivery_time=date("$time:i");
           }
            elseif (isset($delivery) && $delivery=="express"){ // if isset and they have choosen express delivery
                //a delivery time of 45 minutes
                $minutes=date("i");
                $hours=date("H");

                // + 45 min for the delivery-time
                $minutes=$minutes+45;
                // if more than 60 minutes, 95 for example -> found bug by testing, this is the solution to the bug
                if($minutes > 60){

                    $minutes=$minutes-60;
                    $hours=$hours+1;
                }
                echo '<p class="textAbove">The delivery time is ' . date("$hours:$minutes")."</p>";

                 $delivery_time=date("$hours:$minutes");

            } else{   // check of they have chosen a delivery way! if false:
                 echo "<p>No delivery selected!</p>";
             }
        }
        // nog checken of effectief alles goed is én verzonden! dan pas die boodschap tonen
        echo '<p class="textAbove">Your order has been send! :)</p>';


 //---------------------------------- to send the mail, not finished yet (have to check the installation) ---------------------------------------------------------------------------------------------------

 // om de bestelling te mailen  //https://www.w3schools.com/php/func_mail_mail.asp

//define("COOK", "ann.kemp@scarlet.be"); // constant for resto adress
//$subject = "My order:";
    // bij bestelling de bestelling nog bijvoegen, prijs en andere stuff needed
//$bestelling ="mail:".$email."\r\n adress:".$street.",".$streetnr." - ".$zipcode." ".$city;
//$headers = "From: ".$email . "\r\n" .
//"CC: ".$email;

//mail(COOK,$subject,$bestelling,$headers);

    // default showing the food-choice ----------------------------------------------------------------------------------------------------------------------------------------
}
$products = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5]
];

// ------------------------- use get to select and show food or drink values ------------------------------GET!!!------------------------------------------------------------
if (!empty($_GET)) {
$foodnr=$_GET['food'];

if($foodnr==1){

$products = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5]
];

}
 if($foodnr==0) {

     $products = [
         ['name' => 'Cola', 'price' => 2],
         ['name' => 'Fanta', 'price' => 2],
         ['name' => 'Sprite', 'price' => 2],
         ['name' => 'Ice-tea', 'price' => 3],
     ];
 }
}else{
    echo '<p class="textAbove">Please, choose something to eat or drink!</p>';
}
require 'form.php';
?>
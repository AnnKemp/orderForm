<?php
declare(strict_types=1);
session_start();
$totalValue = 0;
$_SESSION["total"]=$totalValue;  // om waarden in de sessies op te slaan

//ini_set('display_errors', "1"); om foutmeldingen te tonen
//include 'validation.php';

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
// define variables and set to empty values
$email = $street = $streetnr = $city = $zipcode = "";
// de postwaarden uit het formulier halen

//if (!empty($_POST)) { // indien het formulier gesubmit wordt
if ($_SERVER["REQUEST_METHOD"] == "POST"){
   
$email=test_input($_POST["email"]);  // straat ophalen
   
//adres
$street=test_input($_POST["street"]);  // straat ophalen
$streetnr=test_input($_POST["streetnumber"]); // nr ophalen
$city=test_input($_POST["city"]); // dorp/gemeente/stad ophalen
$zipcode=test_input($_POST["zipcode"]); // postnummer ophalen 
    
function test_input(str $data) // nog eens checken of die str juist is voor strict typing
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  // functie op validation page aanroepen voor validatie?
  return (string) $data;
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
echo $foodnr;    
    
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
    echo "geen GET ontvangen!";
}

// code schrijven om de geselecteerde waarden op te tellen en in de session te steken
    // to change a session variable, just overwrite it
//$_SESSION["favcolor"] = "yellow";
//print_r($_SESSION);


require 'form.php';
?>
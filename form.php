<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <style>
    .error{
        color:red;     
        }
    footer {
        text-align: center;
    }
    </style>
        
    <title>Order food & drinks</title>
</head>
<body>
<div class="container">
    <h1>Order food in restaurant "the Personal Ham Processors"</h1>
    <nav>
        <ul class="nav">
            <li class="nav-item">
               <!-- via get stuff van index.php halen-->
                <a class="nav-link active" href="?food=1">Order food</a>
            </li>
            <li class="nav-item">
               <!-- via get stuff van index.php halen-->
                <a class="nav-link" href="?food=0">Order drinks</a>
            </li>
        </ul>
    </nav>
    <!-- dit hieronder nog even testen -->
    <form method="post" action=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> " > 
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail:</label>
                <input type="text" id="email" name="email" class="form-control"/>
                
            </div>
            <div></div>
        </div>

        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street:</label>
                    <!-- https://www.w3schools.com/php/php_form_complete.asp -->
                    <input type="text" name="street" id="street" class="form-control" value="<?php echo $street;?>" >
                    <span class="error">* <?php echo $streetErr; ?></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="streetnumber">Street number:</label>
                    <input type="text" id="streetnumber" name="streetnumber" class="form-control">
                     <span class="error">* <?php echo $streetnrErr; ?></span>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" class="form-control">
                    <span class="error">* <?php echo $cityErr; ?></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode</label>
                    <input type="text" id="zipcode" name="zipcode" class="form-control">
                    <span class="error">* <?php echo $zipcodeErr; ?></span>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>
            <?php foreach ($products AS $i => $product): ?>
                <label>
                    <input type="checkbox" value="1" name="products[<?php echo $i ?>]"/> <?php echo $product['name'] ?> -
                    &euro; <?php echo number_format($product['price'], 2) ?></label><br />
            <?php endforeach; ?>
        </fieldset>

        <button type="submit" class="btn btn-primary">Order!</button>
    </form>
 
    <footer>You already ordered <strong>&euro; <?php echo $_SESSION["total"] ?></strong> in food and drinks.</footer>
</div>
</body>
</html>
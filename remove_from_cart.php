<?php
session_start();

if(isset($_POST["id"])){

    $id = $_POST["id"];

    if(isset($_SESSION["cart"])){

        // find the item in the cart array
        $key = array_search($id, $_SESSION["cart"]);

        // remove it if found
        if($key !== false){
            unset($_SESSION["cart"][$key]);
        }

        // reindex array to prevent gaps
        $_SESSION["cart"] = array_values($_SESSION["cart"]);
    }
}

header("Location: cart.php");
exit();
?>
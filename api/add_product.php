<?php
session_start();
include("../db/config.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $user_id = $_SESSION["user_id"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $category = $_POST["category"];

    $imageName = time() . "_" . $_FILES["image"]["name"];
    $target = "../uploads/" . $imageName;

    if(move_uploaded_file($_FILES["image"]["tmp_name"], $target)){

        $stmt = mysqli_prepare($conn,
            "INSERT INTO products(user_id,title,description,price,category,image)
             VALUES(?,?,?,?,?,?)"
        );

        mysqli_stmt_bind_param($stmt,"issdss",
            $user_id,$title,$description,$price,$category,$imageName
        );

        if(mysqli_stmt_execute($stmt)){
            header("Location: ../dashboard.php");
        }else{
            echo "Database error";
        }

    }else{
        echo "Image upload failed";
    }

}
?>

<?php
session_start();
include("../db/config.php");

$id = $_SESSION["user_id"];
$name = $_POST["name"];
$location = $_POST["location"];
$bio = $_POST["bio"];

if(!empty($_FILES["profile_image"]["name"])){

    $image = time()."_".$_FILES["profile_image"]["name"];
    move_uploaded_file($_FILES["profile_image"]["tmp_name"], "../profiles/".$image);

    mysqli_query($conn,
        "UPDATE users SET 
        name='$name',
        location='$location',
        bio='$bio',
        profile_image='$image'
        WHERE id=$id"
    );

}else{

    mysqli_query($conn,
        "UPDATE users SET 
        name='$name',
        location='$location',
        bio='$bio'
        WHERE id=$id"
    );
}

$_SESSION["user_name"] = $name;

header("Location: ../profile.php");
exit();
?>

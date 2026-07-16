<?php
include("../db/config.php");

if($_SERVER["REQUEST_METHOD"]=="POST"){

$role = $_POST["role"];
$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$password = $_POST["password"];

$hashed = password_hash($password, PASSWORD_DEFAULT);

$stmt = mysqli_prepare($conn,
"INSERT INTO users(role,name,email,phone,password,email_verified,phone_verified,status)
VALUES(?,?,?,?,?,1,1,'active')"
);

mysqli_stmt_bind_param($stmt,"sssss",
$role,$name,$email,$phone,$hashed
);

if(mysqli_stmt_execute($stmt)){
    echo "success";
}else{
    echo "Registration failed";
}

}
?>

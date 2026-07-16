<?php
session_start();
include("../db/config.php");

if($_SERVER["REQUEST_METHOD"]=="POST"){

$email = $_POST["email"];
$password = $_POST["password"];

$stmt = mysqli_prepare($conn,
"SELECT id, role, name, password 
 FROM users WHERE email=?"
);

mysqli_stmt_bind_param($stmt,"s",$email);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($result)==1){

$row = mysqli_fetch_assoc($result);

if(password_verify($password,$row["password"])){

    $_SESSION["user_id"]  = $row["id"];
    $_SESSION["user_role"] = $row["role"];
    $_SESSION["user_name"] = $row["name"];

    if($row["role"] === "admin"){
    echo "admin";
}else{
    echo "success";
}


}else{
    echo "Invalid credentials";
}

}else{
    echo "Invalid credentials";
}

}
?>

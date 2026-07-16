<?php
include("db/config.php");

$type = $_GET["type"];
$from = $_GET["from"];
$to   = $_GET["to"];

$where = "";

if($from && $to){
    $where = "WHERE created_at BETWEEN '$from' AND '$to'";
}

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="report.csv"');

$output = fopen("php://output", "w");

// USERS
if($type == "users"){
    fputcsv($output, ["ID","Name","Email","Role"]);
    $res = $conn->query("SELECT id,name,email,role FROM users");

    while($row = $res->fetch_assoc()){
        fputcsv($output, $row);
    }
}

// ORDERS
if($type == "orders"){
    fputcsv($output, ["ID","Amount","Status"]);
    $res = $conn->query("SELECT id,total_amount,status FROM orders $where");

    while($row = $res->fetch_assoc()){
        fputcsv($output, $row);
    }
}

// PAYMENTS
if($type == "payments"){
    fputcsv($output, ["ID","Amount","Status"]);
    $res = $conn->query("SELECT id,amount,status FROM payments $where");

    while($row = $res->fetch_assoc()){
        fputcsv($output, $row);
    }
}

fclose($output);
exit();
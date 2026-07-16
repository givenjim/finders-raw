<?php
session_start();
include("db/config.php");

// ✅ Admin protection
if(!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin"){
    die("Access denied");
}

// ✅ Include FPDF
require('fpdf/fpdf.php');

// Filters
$type = $_GET["type"] ?? "users";
$from = $_GET["from"] ?? "";
$to   = $_GET["to"] ?? "";

$where = "";
if($from && $to){
    $where = "WHERE created_at BETWEEN '$from' AND '$to'";
}

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

// Title
$pdf->Cell(0,10,"Ajira System Report - ".strtoupper($type),0,1);

// ================= USERS =================
if($type == "users"){

    $result = $conn->query("SELECT name,email,role FROM users");

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(60,10,"Name",1);
    $pdf->Cell(70,10,"Email",1);
    $pdf->Cell(40,10,"Role",1);
    $pdf->Ln();

    $pdf->SetFont('Arial','',11);

    while($row = $result->fetch_assoc()){
        $pdf->Cell(60,10,$row["name"],1);
        $pdf->Cell(70,10,$row["email"],1);
        $pdf->Cell(40,10,$row["role"],1);
        $pdf->Ln();
    }
}

// ================= ORDERS =================
if($type == "orders"){

    $result = $conn->query("SELECT id,total_amount,status FROM orders $where");

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(40,10,"Order ID",1);
    $pdf->Cell(60,10,"Amount",1);
    $pdf->Cell(60,10,"Status",1);
    $pdf->Ln();

    $pdf->SetFont('Arial','',11);

    while($row = $result->fetch_assoc()){
        $pdf->Cell(40,10,$row["id"],1);
        $pdf->Cell(60,10,"KES ".$row["total_amount"],1);
        $pdf->Cell(60,10,$row["status"],1);
        $pdf->Ln();
    }
}

// ================= PAYMENTS =================
if($type == "payments"){

    $result = $conn->query("SELECT id,amount,status FROM payments $where");

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(40,10,"Payment ID",1);
    $pdf->Cell(60,10,"Amount",1);
    $pdf->Cell(60,10,"Status",1);
    $pdf->Ln();

    $pdf->SetFont('Arial','',11);

    while($row = $result->fetch_assoc()){
        $pdf->Cell(40,10,$row["id"],1);
        $pdf->Cell(60,10,"KES ".$row["amount"],1);
        $pdf->Cell(60,10,$row["status"],1);
        $pdf->Ln();
    }
}

// Output PDF
$pdf->Output("D", $type."_report.pdf");
exit();
?>
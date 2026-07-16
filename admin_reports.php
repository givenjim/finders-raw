<?php
session_start();
include("db/config.php");

if(!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin"){
    header("Location: login.html");
    exit();
}

// Filters
$type = $_GET["type"] ?? "users";
$from = $_GET["from"] ?? "";
$to   = $_GET["to"] ?? "";

$where = "";

// Date filter (for orders/payments)
if($from && $to){
    $where = "WHERE created_at BETWEEN '$from' AND '$to'";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Reports</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include("partials/admin_navbar.php"); ?>

<section class="dashboard">
    <div class="report-wrapper">
        <div class="report-left">
            <h2>Reports & Analytics</h2>

<!-- FILTER FORM -->
<form method="GET" class="report-form">

<select name="type">
    <option value="users" <?php if($type=="users") echo "selected"; ?>>Users</option>
    <option value="orders" <?php if($type=="orders") echo "selected"; ?>>Orders</option>
    <option value="payments" <?php if($type=="payments") echo "selected"; ?>>Payments</option>
</select>

<input type="date" name="from" value="<?php echo $from; ?>">
<input type="date" name="to" value="<?php echo $to; ?>">

<button type="submit" class="btn-small">Filter</button>
<div class="download-wrapper">
    <a href="export_report.php?type=<?php echo $type; ?>&from=<?php echo $from; ?>&to=<?php echo $to; ?>" 
   class="btn-small">
   Download CSV
</a>
<a href="export_pdf.php?type=<?php echo $type; ?>&from=<?php echo $from; ?>&to=<?php echo $to; ?>" 
   class="btn-small">
   Download PDF
</a>
</div>


</form>
<!-- <hr><br> -->
        </div>
        <div class="report-right">
            
<?php
// ================= USERS =================
if($type == "users"){

    $result = $conn->query("SELECT id,name,email,role FROM users ORDER BY id DESC");

    while($row = $result->fetch_assoc()){
        echo "<div class='dash-card'>
        <strong>{$row["name"]}</strong><br>
        Email: {$row["email"]}<br>
        Role: {$row["role"]}
        </div>";
    }
}

// ================= ORDERS =================
if($type == "orders"){

    $result = $conn->query("
    SELECT * FROM orders $where ORDER BY id DESC
    ");

    while($row = $result->fetch_assoc()){
        echo "<div class='dash-card'>
        <strong>Order #{$row["id"]}</strong><br>
        Amount: KES {$row["total_amount"]}<br>
        Status: {$row["status"]}
        </div>";
    }
}

// ================= PAYMENTS =================
if($type == "payments"){

    $result = $conn->query("
    SELECT * FROM payments $where ORDER BY id DESC
    ");

    while($row = $result->fetch_assoc()){
        echo "<div class='dash-card'>
        <strong>Payment #{$row["id"]}</strong><br>
        Amount: KES {$row["amount"]}<br>
        Status: {$row["status"]}
        </div>";
    }
}
?>
        </div>
    </div>






</section>

</body>
</html>
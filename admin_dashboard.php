<?php
session_start();
include("db/config.php");

if(!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin"){
    header("Location: login.html");
    exit();
}

$id   = $_SESSION["user_id"];
$role = $_SESSION["user_role"];

// =======================
// FETCH VERIFICATION STATUS
// =======================
$userQ = $conn->query("SELECT email_verified, phone_verified FROM users WHERE id='$id'");
$user  = $userQ->fetch_assoc();


// =======================
// PLATFORM STATISTICS
// =======================

$total_users = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()["total"];

$total_workers = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='worker'")->fetch_assoc()["total"];

$total_employers = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='employer'")->fetch_assoc()["total"];

$total_services = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc()["total"];

$total_gigs = $conn->query("SELECT COUNT(*) as total FROM gigs")->fetch_assoc()["total"];

$total_orders = $conn->query("SELECT COUNT(*) as total FROM orders")->fetch_assoc()["total"];

$total_applications = $conn->query("SELECT COUNT(*) as total FROM applications")->fetch_assoc()["total"];

$total_revenue = $conn->query("SELECT SUM(total_amount) as revenue FROM orders WHERE status='paid'")->fetch_assoc()["revenue"];

if(!$total_revenue){
    $total_revenue = 0;
}

// =======================
// CHART DATA
// =======================

// Orders by status
$orderStats = $conn->query("
SELECT status, COUNT(*) as total 
FROM orders 
GROUP BY status
");

$order_labels = [];
$order_data = [];

while($row = $orderStats->fetch_assoc()){
    $order_labels[] = $row["status"];
    $order_data[] = $row["total"];
}

// Users by role
$userStats = $conn->query("
SELECT role, COUNT(*) as total 
FROM users 
GROUP BY role
");

$user_labels = [];
$user_data = [];

while($row = $userStats->fetch_assoc()){
    $user_labels[] = $row["role"];
    $user_data[] = $row["total"];
}

// =======================
// REVENUE TREND (LAST 7 DAYS DEFAULT)
// =======================

$range = $_GET["range"] ?? "7";
$from  = $_GET["from"] ?? "";
$to    = $_GET["to"] ?? "";

$whereDate = "";

if($from && $to){
    $whereDate = "AND DATE(created_at) BETWEEN '$from' AND '$to'";
} else {
    $whereDate = "AND created_at >= DATE_SUB(NOW(), INTERVAL $range DAY)";
}

$revenueStats = $conn->query("
SELECT DATE(created_at) as day, SUM(total_amount) as total
FROM orders
WHERE status='paid' $whereDate
GROUP BY DATE(created_at)
ORDER BY day ASC
");

$rev_labels = [];
$rev_data = [];

while($row = $revenueStats->fetch_assoc()){
    $rev_labels[] = $row["day"];
    $rev_data[] = $row["total"];
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Admin Dashboard | Finders</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<link rel="stylesheet" href="css/style.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

<?php include("partials/admin_navbar.php"); ?>

<section class="dashboard">

<h2>Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?></h2>

<div class="verify-box">
<p>Email: <?php echo $user["email_verified"] ? "Verified <i class='fa-solid fa-circle-check' style='color: green ; font-size: 18px;'></i>" : "Not Verified <i class='fa-solid fa-circle-xmark' style='color: #8B0000 ; font-size: 18px;'></i>"; ?></p>
<p>Phone: <?php echo $user["phone_verified"] ? "Verified <i class='fa-solid fa-circle-check' style='color: green ; font-size: 18px;'></i>" : "Not Verified <i class='fa-solid fa-circle-xmark' style='color: #8B0000 ; font-size: 18px;'></i>"; ?></p>
</div>

<br><br>

<h2>Admin Control Panel</h2>

<p>Manage users, services, and gigs from here.</p>

<!-- 👥 🛠 📄 💳 📊-->
<div class="admin-grid">

<a class="admin-card" href="admin_users.php"><i class="fa-solid fa-users"></i> &nbsp; Manage Users</a>

<a class="admin-card" href="admin_services.php"> <i class="fa-solid fa-screwdriver-wrench"></i> &nbsp; Manage Services</a>

<a class="admin-card" href="admin_gigs.php"><i class="fa-solid fa-file"></i> &nbsp; Manage Gigs</a>

<a class="admin-card" href="admin_payments.php"><i class="fa-solid fa-sack-dollar"></i>&nbsp; Manage Payments</a>

<a class="admin-card" href="admin_reports.php"><i class="fa-solid fa-download"></i> &nbsp; Reports</a>

</div>

<br><br>

<h2>Platform Statistics</h2>

<div class="stats-grid">

<!-- <a class="" href="admin_users.php"></a> -->
<div class="stat-card" onclick="window.location.href='admin_users.php'" style="cursor:pointer;">
<h3>Total Users</h3>
<p><?php echo $total_users; ?></p>
</div>

<div class="stat-card">
<h3>Workers</h3>
<p><?php echo $total_workers; ?></p>
</div>

<div class="stat-card">
<h3>Employers</h3>
<p><?php echo $total_employers; ?></p>
</div>

<div class="stat-card" onclick="window.location.href='admin_services.php'" style="cursor:pointer;">
<h3>Services</h3>
<p><?php echo $total_services; ?></p>
</div>

<div class="stat-card" onclick="window.location.href='admin_gigs.php'" style="cursor:pointer;">
<h3>Gigs</h3>
<p><?php echo $total_gigs; ?></p>
</div>

<div class="stat-card">
<h3>Orders</h3>
<p><?php echo $total_orders; ?></p>
</div>

<div class="stat-card">
<h3>Applications</h3>
<p><?php echo $total_applications; ?></p>
</div>

<div class="stat-card revenue">
<h3>Total Revenue</h3>
<p>$<?php echo $total_revenue; ?></p>
</div>

</div>

<h2>Analytics</h2>
<br>




<form method="GET" class="chart-filter">

<select name="range">
    <option value="7">Last 7 Days</option>
    <option value="30">Last 30 Days</option>
</select>

<input type="date" name="from">
<input type="date" name="to">

<button class="btn-small">Apply</button>

</form>

<div class="charts-grid">

    <div class="chart-card">
        <h3>Orders Overview</h3>
        <canvas id="ordersChart"></canvas>
    </div>

    <div class="chart-card">
        <h3>Users Distribution</h3>
        <canvas id="usersChart"></canvas>
    </div>

    <div class="chart-card">
    <h3>Revenue Trend</h3>
    <canvas id="revenueChart"></canvas>
</div>

</div>

</section>



<script>

// Orders Chart
const ordersChart = new Chart(document.getElementById('ordersChart'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($order_labels); ?>,
        datasets: [{
            label: 'Orders',
            data: <?php echo json_encode($order_data); ?>,
            borderWidth: 1
        }]
    }
});

// Users Chart
const usersChart = new Chart(document.getElementById('usersChart'), {
    type: 'pie',
    data: {
        labels: <?php echo json_encode($user_labels); ?>,
        datasets: [{
            label: 'Users',
            data: <?php echo json_encode($user_data); ?>
        }]
    }
});

// Revenue Chart
const revenueChart = new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($rev_labels); ?>,
        datasets: [{
            label: 'Revenue (KES)',
            data: <?php echo json_encode($rev_data); ?>,
            tension: 0.3
        }]
    }
});

</script>

<script>
// Auto refresh every 30 seconds
setTimeout(() => {
    window.location.reload();
}, 30000);
</script>

</body>
</html>
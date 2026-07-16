<!DOCTYPE html>
<html>
<head>
<title>Verify Email</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<section class="form-section">

<h2>Verify Email</h2>

<form method="POST" action="api/verify.php">

<input type="email" name="email" placeholder="Your Email" required>

<input type="text" name="code" placeholder="Verification Code" required>

<button type="submit">Verify</button>

</form>

</section>

</body>
</html>

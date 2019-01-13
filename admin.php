<?php
session_start();
require_once("db_connection.php");
include("header.php");
include("nav.php");

if (!$_SESSION["logged"] || $_SESSION["type"] !== "admin")
{
	header("location: index.php");
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Admin</title>
	</head>
	<body>
		<div class="wrapper">
			<form class="" action="<?php echo htmlspecialchars('admin_products.php');?>" method="post">
				<button type="submit" class="btn btn-primary">Go to: Products</button>
			</form>
			<br>
			<form class="" action="<?php echo htmlspecialchars('admin_users.php');?>" method="post">
				<button type="submit" class="btn btn-primary" formaction="admin_users.php">Go to: Users</button>
			</form>
			<br>
			<form class="" action="<?php echo htmlspecialchars('admin_orders.php');?>" method="post">
				<button type="submit" class="btn btn-primary">Go to: Orders</button>
		</div>
	</body>
</html>

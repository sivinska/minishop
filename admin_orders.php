<?php
session_start();
require_once("db_connection.php");
include("header.php");
include("nav.php");

if (!$_SESSION["logged"] || $_SESSION["type"] !== "admin")
{
	header("location: index.php");
}
elseif ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$message = "";

	if (empty(test_input($_POST["id_del"])))
		$message = "Please enter an id_basket.";
	else
	{
		$sql = "DELETE FROM order_items WHERE id_basket=?";
		if($stmt = mysqli_prepare($connection, $sql))
		{
			mysqli_stmt_bind_param($stmt, "i", $param_id);
			$param_id = test_input($_POST["id_del"]);
			if (mysqli_stmt_execute($stmt))
				$message = "Delete id=".test_input($_POST["id_del"]). "successfully.";
			else
				$message = "Delete id=".test_input($_POST["id_del"]). "failed.";
		}
		header("location: admin_orders.php");
	}

}



?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Admin orders</title>
	</head>
	<body>
		<h1>List of orders</h1>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			<table class="table">
				<tr>
					<th>Order to delete</th></tr>
					<tr>
					<td><input type="text" name="id_del" placeholder="id_basket" value=""></td>
				</tr>
			</table>	
			<br>
			<button type="submit" class="btn btn-primary">Delete basket</button>
			<span><?php echo $message; ?></span>
			
		</form>
		<br /><br /><br /><br /><br /><br />
		<table class="table">
			<tr>
				<th>ID</th>
				<th>Username</th>
				<th>Id_basket</th>
				<th>Code</th>
				<th>Quantity</th>
				<th>Price</th>
			</tr>
<?php

$stmt = "SELECT id, username, id_basket, code, quantity, price FROM order_items" ;

if ($list = mysqli_query($connection, $stmt))
{
	if (mysqli_num_rows($list) > 0)
	{
    // output data of each row
    	while($row = mysqli_fetch_assoc($list))
		{?>
				<tr>
					<td><?php echo $row["id"]; ?></td>
					<td><?php echo $row["username"]; ?></td>
					<td><?php echo $row["id_basket"]; ?></td>
					<td><?php echo $row["code"]; ?></td>
					<td><?php echo $row["quantity"]; ?></td>
					<td><?php echo $row["price"]; ?></td>
				</tr>
		<?php
		}
	}
}

mysqli_close($connection);

?>
		</table>



	</body>
</html>

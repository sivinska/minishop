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
		<form class="wrapper" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			<label>Order to delete</label>
			<input type="text" name="id_del" placeholder="id_basket" value="">
			<br>
			<button type="submit" class="btn btn-primary">Delete basket</button>
			<span><?php echo $message; ?></span>

		</form>
		<table>
			<tr>
				<td>id</td>
				<td>username</td>
				<td>id_basket</td>
				<td>code</td>
				<td>quantity</td>
				<td>price</td>
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

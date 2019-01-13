<?php
session_start();
require_once("db_connection.php");
include("header.php");
include("nav.php");

if (!$_SESSION["logged"] || $_SESSION["type"] !== "admin")
{
	header("location: index.php");
}
else
{
	$message = "";
	if (test_input($_POST["delete"]) == "delete")
	{
		if (empty(test_input($_POST["id_del"])))
			$message = "Please enter an id.";
		else
		{
			$sql = "DELETE FROM users WHERE id=?";
			if($stmt = mysqli_prepare($connection, $sql))
			{
				mysqli_stmt_bind_param($stmt, "i", $param_id);
				$param_id = test_input($_POST["id_del"]);
				if (mysqli_stmt_execute($stmt))
					$message = "Delete id=".test_input($_POST["id_del"]). "successfully.";
				else
					$message = "Delete id=".test_input($_POST["id_del"]). "failed.";
			}
		}
	}
	elseif (test_input($_POST["modify"]) === "modify")
	{
		if (empty($id = test_input($_POST["id_mod"])))
			$message = "Please enter an id.";
		else
		{
			if (!empty(test_input($_POST["username_mod"])))
				mysqli_query($connection, "UPDATE `users` SET `username` = '".$_POST["username_mod"]."' WHERE `users`.`id` = ".$id);
			if (!empty(test_input($_POST["type_mod"])))
				mysqli_query($connection, "UPDATE `users` SET `type` = '".$_POST["type_mod"]."' WHERE `users`.`id` = ".$id);
		}
	}
	elseif (test_input($_POST["adduser"]) === "adduser")
	{
		header("location: create_user.php");
	}
}



?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Admin products</title>
	</head>
	<body>
		<h1>List of products</h1>
		<form class="wrapper" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			<table>
				<tr>
					<td>Modify</td>
					<td><input type="text" name="id_mod" placeholder="id" value=""></td>
					<td><input type="text" name="username_mod" placeholder="username" value=""></td>
					<td><input type="text" name="type_mod" placeholder="type" value=""></td>
					<td><input type="submit" name="modify" value="modify"></td>
				</tr>
				<tr>
					<td>Delete</td>
					<td><input type="text" name="id_del" placeholder="id" value=""></td>
					<td></td>
					<td></td>
					<td><input type="submit" name="delete" value="delete"></td>
				</tr>
			</table>
			<br>
			<label>Add user</label>
			<input type="submit" name="adduser" value="adduser">
			<?php echo $message; ?>
		</form>
		<table>
			<tr>
				<td>id</td>
				<td>username</td>
				<td>type</td>
			</tr>
<?php

$stmt = "SELECT id, username, type FROM users" ;

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
					<td><?php echo $row["type"]; ?></td>
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

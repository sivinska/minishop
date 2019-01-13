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
			$sql = "DELETE FROM products WHERE id=?";
			if($stmt = mysqli_prepare($connection, $sql))
			{
				mysqli_stmt_bind_param($stmt, "i", $param_id);
				$param_id = test_input($_POST["id_del"]);
				if (mysqli_stmt_execute($stmt))
					$message = "Delete id=".test_input($_POST["id"]). "successfully.";
				else
					$message = "Delete id=".test_input($_POST["id"]). "failed.";
			}
			header("location: admin_products.php");
		}
	}
	elseif (test_input($_POST["modify"]) === "modify")
	{
		if (empty($id = test_input($_POST["id_mod"])))
			$message = "Please enter an id.";
		else
		{
			if (!empty($id = test_input($_POST["title_mod"])))
				mysqli_query($connection, "UPDATE `products` SET `title` = '".$_POST["title_mod"]."' WHERE `products`.`id` = ".$id);
			if (!empty($id = test_input($_POST["price_mod"])))
				mysqli_query($connection, "UPDATE `products` SET `price` = '".$_POST["price_mod"]."' WHERE `products`.`id` = ".$id);
			if (!empty($id = test_input($_POST["image_mod"])))
				mysqli_query($connection, "UPDATE `products` SET `image` = '".$_POST["image_mod"]."' WHERE `products`.`id` = ".$id);
			if (!empty($id = test_input($_POST["category_mod"])))
				mysqli_query($connection, "UPDATE `products` SET `category` = '".$_POST["category_mod"]."' WHERE `products`.`id` = ".$id);
			if (!empty($id = test_input($_POST["code_mod"])))
				mysqli_query($connection, "UPDATE `products` SET `code` = '".$_POST["code_mod"]."' WHERE `products`.`id` = ".$id);
		}
	}
	elseif (test_input($_POST["add"]) === "add")
	{
		if (empty(test_input($_POST["title_add"])) || empty(test_input($_POST["price_add"]))
			|| empty(test_input($_POST["image_add"])) || empty(test_input($_POST["category_add"]))
			|| empty(test_input($_POST["code_add"])))
		{
			$message = "Please enter an id.";
		}
		else
		{

			mysqli_query($connection, "INSERT INTO `products` (`id`, `title`, `price`, `image`, `category`, `code`) VALUES (NULL, '".$_POST["title_add"]."', '".$_POST["price_add"]."', '".$_POST["image_add"]."', '".$_POST["category_add"]."', '".$_POST["code_add"]."')");
		}
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
					<td><input type="text" name="title_mod" placeholder="title" value=""></td>
					<td><input type="text" name="price_mod" placeholder="price" value=""></td>
					<td><input type="url" name="image_mod" placeholder="image" value=""></td>
					<td><input type="text" name="category_mod" placeholder="category" value=""></td>
					<td><input type="text" name="code_mod" placeholder="code_" value=""></td>
					<td><input type="submit" name="modify" value="modify"></td>
				</tr>
				<tr>
					<td>Delete</td>
					<td><input type="text" name="id_del" placeholder="id" value=""></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><input type="submit" name="delete" value="delete"></td>
				</tr>
				<tr>
					<td>Add</td>
					<td></td>
					<td><input type="text" name="title_add" placeholder="title" value=""></td>
					<td><input type="text" name="price_add" placeholder="price" value=""></td>
					<td><input type="url" name="image_add" placeholder="image" value=""></td>
					<td><input type="text" name="category_add" placeholder="category" value=""></td>
					<td><input type="text" name="code_add" placeholder="code" value=""></td>
					<td><input type="submit" name="add" value="add"></td>
				</tr>
			</table>
			<?php echo $message; ?>
		</form>
		<table>
			<tr>
				<td>id</td>
				<td>title</td>
				<td>price</td>
				<td>image</td>
				<td>category</td>
				<td>code</td>
			</tr>
<?php

$stmt = "SELECT id, title, price, image, category, code FROM products" ;

if ($list = mysqli_query($connection, $stmt))
{
	if (mysqli_num_rows($list) > 0)
	{
    // output data of each row
    	while($row = mysqli_fetch_assoc($list))
		{?>
				<tr>
					<td><?php echo $row["id"]; ?></td>
					<td><?php echo $row["title"]; ?></td>
					<td><?php echo $row["price"]; ?></td>
					<td><?php echo $row["image"]; ?></td>
					<td><?php echo $row["category"]; ?></td>
					<td><?php echo $row["code"]; ?></td>
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

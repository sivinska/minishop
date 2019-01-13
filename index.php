<?php

session_start();
require_once("db_connection.php");
include("header.php");
include("nav.php");
$status="";
if (isset($_POST['code']) && $_POST['code']!=""){
	$code = $_POST['code'];
	$result = mysqli_query($connection,"SELECT * FROM `products` WHERE `code`='$code'");
	$row = mysqli_fetch_assoc($result);
	$name = $row['title'];
	$code = $row['code'];
	$price = $row['price'];
	$image = $row['image'];

	$cartArray = array(
		$code=>array(
		'title'=>$name,
		'code'=>$code,
		'price'=>$price,
		'quantity'=>1,
		'image'=>$image)
	);

	if(empty($_SESSION["shopping_cart"])) {
		$_SESSION["shopping_cart"] = $cartArray;
		$status = "<div>Product is added to your cart!</div>";
	}else{
		$array_keys = array_keys($_SESSION["shopping_cart"]);
		if(in_array($code,$array_keys)) {
			$status = "<div style='color:red;'>
			Product is already added to your cart!</div>";
		} else {
		$_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"],$cartArray);
		$status = "<div>Product is added to your cart!</div>";
		}
	}
}
?>
<div class="cointainer">
<br />
<?php
if(!empty($_SESSION["shopping_cart"])) {
$cart_count = count(array_keys($_SESSION["shopping_cart"]));
?>
<div class="message_box" style="margin:10px 0px;">
<?php echo $status; ?>
<div>
<a href="cart.php"> There are <?php echo $cart_count; ?> items in your cart.</a>
</div>
<br />
<?php
}

if (isset($_GET['category'])){
	$category = mysqli_real_escape_string($connection, $_GET['category']);
	if ($category == 1)
		$sql = "SELECT * FROM products WHERE category = 1";
	if ($category == 2)
		$sql = "SELECT * FROM products WHERE category = 2";
	if ($category == 3)
		$sql = "SELECT * FROM products WHERE category = 3";
}
else
	$sql = "SELECT * FROM products";
$result = mysqli_query($connection, $sql);
?>

	<div class="row">
<?php while($row = mysqli_fetch_assoc($result)){
		echo "<div class='col-sm-6 col-md-3'>

			  <form method='post' action=''>
			  <input type='hidden' name='code' value=".$row['code']." />
			  <div class='thumbnail'><img src='".$row['image']."' />
			  <div class='caption'>
					<h3>".$row["title"]."</h3>
					<h3>".$row["price"]." &#8364</h3>
			  <button type='submit' class='btn btn-primary'>Add to cart</button>
			  </div>
			  </form>
				 </div>
				 </div>";
        }
mysqli_close($connection);
?>
	</div>
<div style="clear:both;"></div>

<div class="message_box" style="margin:10px 0px;">
<?php echo $status; ?>

</body>
</html>

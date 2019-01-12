
<div class="topnav">
  <div class="container">
        <a href="index.php">Home</a>

    <div class ="topnav-right">
		<?php
		  	if ($_SESSION["logged"] == true)
			{
				echo '<a href="#">'.$_SESSION["username"].'</a>';
				echo '<a href="logout.php">Logout</a>';
			}
			else
			{
		        echo '<a href="create_user.php">Sign up</a>';
		        echo '<a href="login.php">Login</a>';
			}

		?>
        <a href="cart.php">Cart</a>


</div>

</div>
</div>

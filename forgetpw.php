<?php
session_start();
require_once("db_connection.php");
include("header.php");
include("nav.php");

$username = $secret = $newpw = $confirm_newpw = "";
$username_err = $secret_err = $newpw_err = $confirm_newpw_err = "";

if (!$_SESSION[logged] && $_SERVER["REQUEST_METHOD"] == "POST")
{
    if(empty(test_input($_POST["username"])))
		$username_err = "Please enter your username.";
	else
		$username = test_input($_POST["username"]);

	if(empty(test_input($_POST["secret"])))
		$secret_err = "Please enter your secret answer.";
	else
		$secret = test_input($_POST["secret"]);

	if(empty(test_input($_POST["newpw"])))
		$newpw_err = "Please enter a password.";
	elseif(strlen(test_input($_POST["newpw"])) < 6)
		$newpw_err = "Password must have atleast 6 characters.";
	else
		$newpw = test_input($_POST["newpw"]);

	if(empty(test_input($_POST["confirm_newpw"])))
		$confirm_newpw_err = "Please confirm password.";
	else
	{
		$confirm_newpw = test_input($_POST["confirm_newpw"]);
        if(empty($newpw_err) && ($newpw != $confirm_newpw))
            $confirm_newpw_err = "Password did not match.";
    }

	if (empty($username_err) && empty($secret_err) && empty($newpw_err) && empty($confirm_newpw_err))
	{
		$sql = "SELECT id, username, password, secret FROM users WHERE username = ?";
		if($stmt = mysqli_prepare($connection, $sql))
		{
			mysqli_stmt_bind_param($stmt, "s", $param_username);
			$param_username = $username;
			if(mysqli_stmt_execute($stmt))
			{
				mysqli_stmt_store_result($stmt);
				if(mysqli_stmt_num_rows($stmt) == 1)
				{
					mysqli_stmt_bind_result($stmt, $id, $username, $hashed_pw, $hashed_secret);
					if (mysqli_stmt_fetch($stmt))
					{
						if (password_verify($secret, $hashed_secret))
						{
							$sql = "UPDATE users SET password = ? WHERE id = ?";
							if ($stmt = mysqli_prepare($connection, $sql))
							{
								mysqli_stmt_bind_param($stmt, "si", $param_newpw, $param_id);
								$param_newpw = password_hash($newpw, PASSWORD_DEFAULT);
								$param_id = $id;
								if(mysqli_stmt_execute($stmt))
					                header("location: index.php");
					            else
					                echo "Something went wrong. Please try again later.";
							}
						}
						else
							$secret_err = "Wrong answer.";
					}
				}
				else
					echo "User not found...";
			}
		}
		else
		{
			echo "Something went wrong. Please try again later.";
		}
		// Close statement
		mysqli_stmt_close($stmt);
	}

	// Close connection
	mysqli_close($connection);

}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Password forget</title>
	</head>
	<body>
		<form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<div class="wrapper">
                <h1>Reset your password</h1>
                <p>Please fill in this form to reset your password.</p>
                <hr>
				<label>Username</label>
				<input type="text" name="username" value="">
				<span style='color:red;'><?php echo $username_err; ?></span>
			
				<label>Secret questions: What's your favourite colour?</label>
				<input type="password" name="secret" value="">
				<span style='color:red;'><?php echo $secret_err; ?></span>
			
				<label>New password</label>
				<input type="password" name="newpw" value="">
				<span style='color:red;'><?php echo $newpw_err; ?></span>
			
				<label>Confirm new password</label>
				<input type="password" name="confirm_newpw" value="">
				<span style='color:red;'><?php echo $confirm_newpw_err; ?></span>

				<br />
				<button type="submit" class="btn btn-primary">Reset</button>
		
			</div>
		</form>
	</body>
</html>

<?php include('footer.php'); ?>

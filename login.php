<?php

session_start();
require_once("db_connection.php");
include("header.php");
include("nav.php");

$username = $password = "";
$error = "";
$error_msg = "Incorrect username or password.";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	//Username check
    if(empty(test_input($_POST["username"])))
	{
        $error = $error_msg;
    }
	else
	{
        $username = test_input($_POST["username"]);
    }

    // Password check
    if(empty(test_input($_POST["password"])))
	{
		$error = $error_msg;
    }
	else
	{
		$password = test_input($_POST["password"]);
	}

    // Check input errors before inserting in database
    if(empty($error))
	{

        // Prepare an SELECT statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($connection, $sql))
		{
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;
            if(mysqli_stmt_execute($stmt))
			{
                mysqli_stmt_store_result($stmt);
				if(mysqli_stmt_num_rows($stmt) == 1)
				{
					mysqli_stmt_bind_result($stmt, $id, $username, $hashed_pw);
					if (mysqli_stmt_fetch($stmt))
					{
						if (password_verify($password, $hashed_pw))
						{
							session_start();
							$_SESSION["id"] = $id;
							$_SESSION["username"] = $username;
							$_SESSION["logged"] = true;
							header("location: index.php");
						}
						else
							$error = $error_msg;
					}
            	}
				else
					$error = $error_msg;
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
		<title>Sign in</title>
	</head>
	<body>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			<div class="wrapper">
				<p><?php echo $error; ?></p>
				<h1>Log in</h1>
                <p>Please fill in this form to login.</p>
                <hr>
				<label>Username</label>
				<input type="text" name="username" value="">

				<label>Password</label>
				<input type="password" name="password" value="">

				<br />
				<button type="submit" class="btn btn-primary">Log in</button>
				<br />
				<p>Forgot your password? <a href="forgetpw.php">Click here to modify</a>.</p>
			</div>

		</form>
	</body>
</html>

<?php include('footer.php'); ?>

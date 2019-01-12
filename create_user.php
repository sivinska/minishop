<?php
session_start();
require_once("db_connection.php");
include("header.php");
include("nav.php");

// Define variables and initialize with empty values
$username = $password = $confirm_password = $secret = "";
$username_err = $password_err = $confirm_password_err =$secret_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(test_input($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($connection, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = test_input($_POST["username"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = test_input($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Validate password
    if(empty(test_input($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(test_input($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = test_input($_POST["password"]);
    }

    // Validate confirm password
    if(empty(test_input($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = test_input($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

	if(empty(test_input($_POST["secret"]))){
		$secret_err = "Please enter a secret answer.";
	} else{
		$secret = test_input($_POST["secret"]);
	}

	// Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, secret) VALUES (?, ?, ?)";

        if($stmt = mysqli_prepare($connection, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_secret);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
			$param_secret = password_hash($secret, PASSWORD_DEFAULT);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: index.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
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
		<form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			<div class="">
				<label>Username</label>
				<input type="text" name="username" value="">
				<span><?php echo $username_err; ?></span>
			</div>
			<div class="">
				<label>Password</label>
				<input type="password" name="password" value="">
				<span><?php echo $password_err; ?></span>
			</div>
			<div class="">
				<label>Confirm password</label>
				<input type="password" name="confirm_password" value="">
				<span><?php echo $confirm_password_err; ?></span>
			</div>
			<div class="">
				<label>Secret questions: What's your favourite colour?</label>
				<input type="password" name="secret" value="">
				<span><?php echo $secret_err; ?></span>
			</div>
			<div>
				<input type="submit" name="Create" value="create">
			</div>
		</form>
	</body>
</html>

<?php include('footer.php'); ?>

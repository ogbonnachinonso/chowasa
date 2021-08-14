<?php
// Include config file
require_once "../db/connect.php";
$title = "Login";
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM vendors WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: vendor.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
 <?php
require_once "../partials/login-head.php";

?>
<main class="login-pag" id="logi" >
    <div class="container mt-5 pt-5">
    <div class="row">
    <div class="col-md-5">
    <div class="">
        <h1 class="display-5 heavy mt-5">Welcome to Chowasa</h1>
        <p class="lead">Sign Into Your Account</p>
      </div>
      <br><br>
        </div>
        <div class="col-md-7 card pb-5 mb-5">
        <h2 class=" text-center pt-3" style="color:blueviolet;">Login</h2>
        <p class=" text-center" style="color:blueviolet;">Please fill in your credentials to login.</p>
        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label class="" style="color:blueviolet;">Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" placeholder="Please enter Username">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label class="" style="color:blueviolet;">Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Please enter password">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
                <a href="#" style="color:blueviolet;">Forgot your password?</a>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary text-white m-auto" value="Login">
            </div>
            <p class="text-center" style="color:blueviolet;">Don't have an account? <a href="signup.php" class="text-warning">Sign up as Vendor</a>.</p>
            <!-- <p class="text-success text-center"> <a href="register.php" class="text-warning">Signup as User</a>.</p> -->
        </form>
        </div>
    </div>
    </div>
    </main>
    <?php
require_once "../partials/foot.php";

?>
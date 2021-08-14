<?php
$title = " Signup page";
require_once "../partials/login-head.php";

// Define variables and initialize with empty values
$fullname = $username = $password = $phone = $email =   $confirm_password = "";
$fullname_err = $username_err = $password_err = $phone_err =$email_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

  // Validate fullname
    if(empty(trim($_POST["fullname"]))){
        $fullname_err = "Please enter your fullname.";
    } elseif(!preg_match('/^[a-zA-Z ]+$/', trim($_POST["fullname"]))){
        $fullname_err = "Fullname can only contain letters .";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM vendor WHERE fullname = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_fullname);
            
            $param_fullname = trim($_POST["fullname"]);
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $fullname_err = "This name is already taken.";
                } else{
                    $fullname = trim($_POST["fullname"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM vendor WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Validate email
    if(empty(trim($_POST["email"]))){
      $email_err = "Please enter email.";
  } elseif(var_dump(!filter_var($email, FILTER_VALIDATE_EMAIL))){
      $email_err = "Invalid Email.";
  } else{
      // Prepare a select statement
      $sql = "SELECT id FROM vendor WHERE email = ?";
      
      if($stmt = mysqli_prepare($link, $sql)){
          // Bind variables to the prepared statement as parameters
          mysqli_stmt_bind_param($stmt, "s", $param_email);
          
          // Set parameters
          $param_email = trim($_POST["email"]);
          
          // Attempt to execute the prepared statement
          if(mysqli_stmt_execute($stmt)){
              /* store result */
              mysqli_stmt_store_result($stmt);
              
              if(mysqli_stmt_num_rows($stmt) == 1){
                  $email_err = "This email is already taken.";
              } else{
                  $email = trim($_POST["email"]);
              }
          } else{
              echo "Oops! Something went wrong. Please try again later.";
          }

          // Close statement
          mysqli_stmt_close($stmt);
      }
  }
    // Validate username
    if(empty(trim($_POST["phone"]))){
      $phone_err = "Please enter a phone.";
  } elseif(!preg_match('/^[0-9]+$/', trim($_POST["phone"]))){
      $phone_err = "phone can only contain numbers.";
  } else{
      // Prepare a select statement
      $sql = "SELECT id FROM vendor WHERE phone = ?";
      
      if($stmt = mysqli_prepare($link, $sql)){
          // Bind variables to the prepared statement as parameters
          mysqli_stmt_bind_param($stmt, "s", $param_phone);
          
          // Set parameters
          $param_phone = trim($_POST["phone"]);
          
          // Attempt to execute the prepared statement
          if(mysqli_stmt_execute($stmt)){
              /* store result */
              mysqli_stmt_store_result($stmt);
              
              if(mysqli_stmt_num_rows($stmt) == 1){
                  $phone_err = "This phone number is already taken.";
              } else{
                  $phone = trim($_POST["phone"]);
              }
          } else{
              echo "Oops! Something went wrong. Please try again later.";
          }

          // Close statement
          mysqli_stmt_close($stmt);
      }
  }
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($fullname_err) && empty($username_err) && empty($email_err) && empty($phone_err)&& empty($password_err) && empty($confirm_password_err)){
        
      $param_password = password_hash($password, PASSWORD_DEFAULT);
        // Prepare an insert statement
        $sql = "INSERT INTO vendor (fullname, username, email, phone, password) VALUES ('$fullname','$username','$email','$phone','$param_password')";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_fullname, $param_username, $param_email,$param_phone,  $param_password);
            
            // Set parameters
            $param_fullname = $fullname;
            $param_username = $username;
            $param_email = $email;
            $param_phone = $phone;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close linkection
    mysqli_close($link);
}
?>
 

 <main class="login-pag" id="logi" >
    <div class="container mt-5 pt-5">
    <div class="row">
    <div class="col-md-5">
    <div class="">
        <h1 class="display-5 heavy">Welcome to Chowasa</h1>
        <p class="lead">Signup For Your Account</p>
      </div>
      <br><br>
   
        </div>
        <div class="col-md-7 card pb-5 mb-5">
      
        <h2 class=" text-center mt-3 pt-3"style="color:blueviolet;">Sign Up</h2>
        <p class="text-center" style="color:blueviolet;">Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
             
            <div class="form-group">
                <label class="" style="color:blueviolet;">Fullname</label>
                <input type="text" name="fullname" class="form-control <?php echo (!empty($fullname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fullname; ?>" placeholder="Enter your fullname">
                <span class="invalid-feedback"><?php echo $fullname_err; ?></span>
            </div>    
            <div class="form-group">
                <label class=""style="color:blueviolet;">Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" placeholder="What should we call you">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div> 
            <div class="form-group">
                <label class="" style="color:blueviolet;">Email</label>
                <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>"placeholder="Please make it a valid email">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div> 
            <div class="form-group">
                <label class="" style="color:blueviolet;">Phone Number</label>
                <input type="text" name="phone" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phone; ?>" placeholder="Provide one that is reachable">
                <span class="invalid-feedback"><?php echo $phone_err; ?></span>
            </div>
            <div class="row form-group">
            <div class="col-md-6">
                <label class="" style="color:blueviolet;">Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>" placeholder="Beware of hackers!">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="col-md-6 ">
                <label class="" style="color:blueviolet;">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>" placeholder="This should match password">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            </div>
            
           
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
            <p class=" text-center" style="color:blueviolet;">Already have an account? <a href="login.php" class="text-warning">Login here</a>.</p>
        </form>
    </div>  
    </div>
    </div>  
    </main>
 <?php
require_once "../partials/foot.php";
?>
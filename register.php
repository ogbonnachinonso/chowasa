<?php
session_start();
$name = $phone = $email = $pwd ="";
$errors = array('name' => "", 'phone' => "", 'email' => "", 'pwd' => "", 'msg' => "");


// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"]=="POST") {
   
    //validate full name
    if (empty($_POST["Fname"])) {
        $errors["name"] = "Full name required!";
    } else {
        $name = test_ip(strtoupper($_POST["Fname"]));

        if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            $errors["name"] = "only letter and white space are allowed! ";
        }
    }
    
    //validate phone number
    if (empty($_POST["phone"])) {
        $errors["phone"] = "phone required!";
    } else {
        $phone = test_ip($_POST["phone"]);
        if (!preg_match("/^((\d){11})$/", $phone)) {
            $errors["phone"] = "invalid phone number!";
        }
    }
    //validate email
    if (empty($_POST["email"])) {
        $errors["email"] = "email is required!";
    } else {
        $email = test_ip($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "invalid email format!";
        }
    }
    
    //validate password
    if (empty($_POST["pwd"])) {
        $errors["pwd"] = "enter password!";
    } else {
        $pwd = test_ip($_POST["pwd"]);
        if (strlen($pwd) < 8) {
            $errors["pwd"] = "Your password Must Contain At Least 8 Characters!";
        } elseif (!preg_match("#[0-9]+#", $pwd)) {
            $errors["pwd"] = "Your password Must Contain At Least 1 Number!";
        } elseif (!preg_match("#[A-Z]+#", $pwd)) {
            $errors["pwd"] = "Your password Must Contain At Least 1 Capital Letter!";
        } elseif (!preg_match("#[a-z]+#", $pwd)) {
            $errors["pwd"] = "Your password Must Contain At Least 1 Lowercase Letter!";
        }
    }
    
    
    if (!array_filter($errors)) {
        //connect to local database
        $conn = new mysqli("localhost", "Bode", "bode4376", "chowasa");
        
        $name=$conn->real_escape_string($name);
        $phone = $conn->real_escape_string($phone);
        $email = $conn->real_escape_string($email);
        $pwd =$conn->real_escape_string(password_hash($pwd, PASSWORD_DEFAULT));
        //check if user already exist
        $sql= "SELECT* FROM users WHERE email= '$email'";
        $result = $conn->query($sql);
        if($result->num_rows>0){
            //already exist
            $errors["msg"] = "already registered with phone number";
            
        }else{
            //insert into database
            $sql= "INSERT INTO users(name, phone, email, password)
            VALUES('$name', '$phone', '$email','$pwd')";
            if($conn->query($sql)!==TRUE){
                $errors["msg"]= $conn->error;
            }
            header("location:test.php");
        }
        $result->free_result();
        $conn->close();

    } 
}
//this function trims, strip slashes and and convert data to special html characters
function test_ip($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <h1>Welcome to Chowasa</h1>
        <h3>Sign up for account</h3>
        <p>Already have an account?<a href="login.php">sign in here</a></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = 'post'>
            <div>
                <label for="Fname">Full Name</label><br>
                <input type="text" name="Fname" placeholder="What should we call you" value="<?php echo $name;?>" required >
                <span>*<?php echo $errors["name"]; ?></span>
            </div>

            <div>
                <label for="email">Email Address</label><br>
                <input type="text" name="email" placeholder="please make it a valid mail" value="<?php echo $email;?>" required >
                <span>*<?php echo $errors['email']; ?></span>
            </div>

            <div>
                <label for="phone">Phone No.</label><br>
                <input type="text" name="phone" placeholder="provide one that is reachable" value="<?php echo $phone;?>" required >
                <span>*<?php echo $errors['phone']; ?></span>
            </div>

            <div>
                <label for="pwd">Password</label><br>
                <input type="password" name="pwd" placeholder="What should we call you" value="<?php echo $pwd;?>" required >
                <span>*<?php echo $errors['pwd']; ?></span>
            </div><br>
            <div>
                <button>sign up for your account</button>
            </div>
            <div>
                <span>*<?php echo $errors['pwd']; ?></span>
            </div>
        </form>
    </body>
</html>
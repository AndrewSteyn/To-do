<?php

session_start();
 

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    
    exit;
}
 

require_once "connectoop.php";
 

$username = $password = "";
$username_err = $password_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
 
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
 
    if(empty($username_err) && empty($password_err)){
 
        $sql = "SELECT id, username, password, confirm FROM users WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
         
            $stmt->bind_param("s", $param_username);
            
            $param_username = $username;
            
            if($stmt->execute()){
                $stmt->store_result();
                
                if($stmt->num_rows == 1){                    
                    
                    $stmt->bind_result($id, $username, $hashed_password, $confirm);
                    if($stmt->fetch()){
                    
                        if(password_verify($password, $hashed_password) && $confirm == 1){
                            session_start();
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            header("location: index.php");
                        } else{
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    $username_err = "This user doesn't exist.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        
        //$stmt->close();
    }
}
    // Close connection
    $mysqli->close();
    ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="css/styles.css">

    <title>Please Login</title>

</head>

<body>
    <div class="sidebar">
        <div class="=card">
            <h1>Login Here</h1>
            <div class="container">
                <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
                    <div class="formitem">
                        <Label for="username">Userame:</Label><Input name="username" type="text" require>
                    </div>
                        <br>
                    <div class="formitem">
                        <label for="email">Password:</label><input name="password" type="password" require>
                    </div>
                    <br>
                    <input type="submit" value="login">
                </form>
            </div>
            <br>
            <h5>OR</h5>
            <a href="signup.php">Sign Up</a>
        </div>
    </div>
</body>
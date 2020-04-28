<?php
session_start();

include_once 'connectoop.php';

$username = $email = $password = "";
$username_err = $email_err = $password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    //var_dump($_POST);
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    }else{
        $sql = "SELECT id FROM users WHERE username = ?";

        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("s", $param_username);
            $param_username = trim($_POST["username"]);
                if($stmt->execute()){
                    $stmt->store_result();
                    if($stmt->num_rows == 1){
                        $username_err = "This username is already taken.";
                    }else{
                        $username = trim($_POST["username"]);
                        $_SESSION["username"] = $username;
                    }
                    }else{
                        echo "Oops! Something went wrong. Please try again later.";     
                    }
             }
        $stmt->close();
    }

    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a vaild email.";

    }else{
        $sql = "SELECT id FROM users WHERE email = ?";
        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("s", $param_email);
            $param_email = trim($_POST["email"]);

            if($stmt->execute()){
                $stmt->store_result();

                if($stmt->num_rows == 1){
                    $email_err = "This email is already in use.";

                }else{
                    $email = trim($_POST["email"]);
                    $_SESSION["email"] = $email;
                }
            }else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        $stmt->close();

    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password."; 
    }elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    }else{
        $password = trim($_POST["password"]);
    }
    echo $username;
    echo $email;
    echo $password;

    if(empty($username_err) && empty($email_err) && empty($password_err)){
        $sql = "INSERT INTO users (username, email, pwd) VALUES (?, ?, ?)";

        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("sss", $param_username, $param_email ,$param_password);

            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if($stmt->execute()){
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        $stmt->close();
    }
    $mysqli->close();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="css/styles.css">

    <title>Please Sign up</title>

</head>

<body>
    <div class="sidebar">
        <div class="=card">
            <h1 class="card-title">Sign Up Here</h1>
            <div class="container">
                <form method="post" class="form" action="signup.php"> 
                    <div class="input">
                        <Label for="username">Username:</Label><Input name="username" type="text" require>
                    </div>
                        <br>
                    <div class="input">
                        <label for="email">Email:</label><input name="email" type="email" require>
                    </div>
                    <div class="input">
                        <label for="password">Password:</label><input name="password" type="password" require>
                    </div>
                    <br>
                    <button type="submit" method="post">Sign up</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
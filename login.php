<?php
session_start();

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
                <form class="form"> 
                    <div class="formitem">
                        <Label for="name">Name:</Label><Input name="name" type="text" require>
                    </div>
                        <br>
                    <div class="formitem">
                        <label for="email">Password:</label><input name="password" type="password" require>
                    </div>
                    <br>
                    <button type="submit" method="POST">Sign In</button>
                </form>
            </div>
            <br>
            <h5>OR</h5>
            <a href="signup.php">Sign Up</a>
        </div>
    </div>
</body>
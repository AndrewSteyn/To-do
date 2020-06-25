<?php
//Set PHPMailer namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include config file
require_once "connect.php";
require_once  "vendor/autoload.php";
session_start();
 
// Define variables and initialize with empty values
$email = $_SESSION["email"];
$username = $_SESSION["username"];
$confirmNum = $_SESSION["confirmNum"];
$username_info = "";
$sql = "SELECT confirmNum FROM users WHERE email = ?";

if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $stmt->bind_result($boundConfirmNum);
                    // Prepare an insert statement
                    
                    
                    if($stmt->fetch()){
                        if($boundConfirmNum == $confirmNum){
                        $sql = "UPDATE users SET confirm='0' where email=?";
                        if($stmt = $mysqli->prepare($sql)){
                            // Bind variables to the prepared statement as parameters
                            $stmt->bind_param("s", $param_email);

                            // Set parameters
                            $param_email = $email;

                            // Attempt to execute the prepared statement
                            if($stmt->execute()){
                                // Redirect to login page
                                $username_info = "Thanks for registering, ". $username . ". Please check your email for further instructions.";
                            } else{
                                echo "Something went wrong. Please try again later.";
                            }
                        }
                        }
                    }
                    $mail = new PHPMailer(true);
                    sendEmail($mail, $username, $email, $confirmNum);
                }else{
                    $email_err = "The email address provided could not be found on our database.";
                }
            }else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
$stmt->close();
$mysqli->close();
 


    //PHPMailer send email to user
    function sendEmail($param, $param3, $param4, $param5){
            try {
                //Server settings
                $param->SMTPDebug = 0;                    // Enable verbose debug output
                $param->isSMTP();                         // Set mailer to use SMTP
                $param->Host       = 'smtp.mailtrap.io';  // Specify main and backup SMTP servers
                $param->SMTPAuth   = true;                // Enable SMTP authentication
                $param->Username   = '3c52a86d140a7b';    // SMTP username
                $param->Password   = '1422144da449c9';    // SMTP password
                $param->SMTPSecure = 'TLS';               // Enable TLS encryption, `ssl` also accepted
                $param->Port       = 2525;                // TCP port to connect to

                //Recipients
                $param->setFrom('andrew@rabbitmacht.co.za', 'andrew');
                $param->addAddress($param4, 'a good guy');     // Add a recipient
                $param->addReplyTo('andrew@rabbitmacht.co.za', 'Information');

                // Content
                $param->isHTML(true);                                  // Set email format to HTML
                $param->Subject = 'User Profiles App Confirmation';
                $param->Body    = 
        "Hi ".$param3. " <br> 
        Welcome to the User Profiles App <br>
        Please confirm your email address by visiting the link below <br>
        <a href=\"http://test/To%20Do/inc/confirmEmail.php?email=".$param4."&confirmNum=".password_hash($param5, PASSWORD_DEFAULT)."\">here</a> ";
                $param->AltBody = 'This is the body in plain text for non-HTML mail clients';
                $param->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$param->ErrorInfo}";
            }
    }//endsendEmail

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thanks for signing up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Thanks for Signing Up</h2>
        <p><?php echo $username_info ?></p>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>    
</body>
</html>
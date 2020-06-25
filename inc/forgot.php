<?php
//Set PHPMailer namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include config file
require_once "connect.php";
require_once  "vendor/autoload.php";
//session_start();

if(isset($_POST["email"])){
    $email = $_POST["email"];
    echo $email;
    $sql = "SELECT confirm FROM users WHERE email = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $param_email);
    $param_email = $email;
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows == 1){
        $stmt->bind_result($boundConfirm);
        $stmt->fetch();
        echo $boundConfirm. "<br>";
        if($boundConfirm == 1){
            $mail = new PHPMailer(true);
            sendEmail($mail, $email, $boundConfirm);
            $stmt->close();
            $mysqli->close();
        }
    }else{
        echo "row is empty";
    }
}

 
    //PHPMailer send email to user
    function sendEmail($param, $param4, $param5){
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
                $param->setFrom('andrew@rabbitmacht.co.za', 'lyndon');
                $param->addAddress($param4, 'a good guy');     // Add a recipient
                $param->addReplyTo('andrew@rabbitmacht.co.za', 'Information');

                // Content
                $param->isHTML(true);                                  // Set email format to HTML
                $param->Subject = 'User Profiles App Password Reset';
                $param->Body    = 
        "Hi <br> 
        A request for a password reset has been sent to this email address <br>
        Please follow the link below to reset your passowrd <br>
        <a href=\"http://test/To%20Do/inc/resetByEmail.php?email=".$param4."&confirm=".password_hash($param5, PASSWORD_DEFAULT)."\">here</a> ";
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
        <?php echo isset($_POST["email"]) ? "Please check your email for further instructions" : ""?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Please enter your email address : </label>
                <input type="email" name="email" class="form-control" value="">
            </div>    
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>    
</body>
</html>
<?php
        session_start();
            //establish  
            include_once 'connectoop.php';

            include_once 'activityclass.php';
?>

<!DOCTYPE html>
<html lang="en">
    <Head>
        <meta charset="utf-8">
        <meta name="vieport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Crimson+Text&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/styles.css">

        <title>What's there 2DO</title>

    </Head>

    <body>
        <div class="center">
        <h1>Your List of Activities!</h1>
            <div class="logout">
                <a href="logout.php">LOGOUT</a>
            </div>
        <?php
        $id = 1;
        $sql = "SELECT * FROM activities where id = $id ORDER BY activity";
    
        $results = mysqli_query($mysqli, $sql);

        $row = mysqli_fetch_assoc($results);

        if (mysqli_num_rows($results)>=0){
            $activity = new activity($row["activity"],$row["note"],$row["act_id"],$row["due_date"]); 
            $activity->displayTask();
            while($row = mysqli_fetch_assoc($results)) {
                $activity = new activity($row["activity"],$row["note"],$row["act_id"],$row["due_date"]);
                $activity->displayTask();
                }
            }else{
                echo "Lets Add Some Activities";
            }
        

            if (isset($_POST['done'])){
                $doneid = $_POST['done'];
                echo $doneid;
                $sql = "DELETE FROM activities
                WHERE id = '1' AND act_id = '$doneid'";
                 if ($mysqli->query($sql)) {
                    unset($sql);
            }else {
                echo "Error: " . $sql . "<br>" . $mysqli->error;
            }
        }	
        ?>
        </div>
                <div id="add">
                    <form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
                        <label class="input" for="act">Add Task: </label><input name="act" type="text" required>
                        <br>
                        <label class="input" for="date">Date of Task:</label><input name="date" type="date" required>
                        <br>
                        <label class="input" for="note">Note: </label><input name="note" type="text" required>
                        <br>
                        <button class="input" type="submit">Add Activity </button>
                    </form>
                </div> 
                <?php

                    function sanitizeString($var)
                        {
                            include 'connectoop.php';
	                        $var = strip_tags($var);
	                        $var = htmlspecialchars($var);
	                        $var = stripslashes($var);
	                        $mysqli->real_escape_string($var);
	                        return $var;
                        }
                if (isset($_POST['act'])) {
                    $cleanact = sanitizeString($_POST['act']);
                    $cleannote = sanitizeString($_POST['note']);
                    $cleandate = sanitizeString($_POST['date']);
                    $sql = "INSERT INTO activities (activity, note, id, due_date)
                    VALUES ('$cleanact','$cleannote','1', '$cleandate')";
                    //Execute query and validate success
                     if ($mysqli->query($sql)) {
                        //echo "New record created successfully";
                        unset($sql);
                    } else {
                         echo "Error: " . $sql . "<br>" . $mysqli->error;
                     }	
                }
                ?>

        <div class="footer" >
            <p id="fixedbutton" onclick="myFunction()">Add Activity</p>
        </div> 
        
        <script>
        function myFunction() {
        document.getElementById("add").style.display = "block";
                            }
        </script>
    </body>
</html>
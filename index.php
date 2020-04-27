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
        <link rel="stylesheet" href="css/styles.css">

        <title>What's there 2DO</title>

    </Head>

    <body>
        <div class="center">
        <h1>Users List of Activities!</h1>
        <?php
        $id = 1;
        $sql = "SELECT * FROM activities where id = $id";
    
        $results = mysqli_query($mysqli, $sql);

        $row = mysqli_fetch_assoc($results);

        if (mysqli_num_rows($results)>=0){
            $activity = new activity($row["activity"],$row["note"],$row["act_id"]);
            $activity->displayTask();
            while($row = mysqli_fetch_assoc($results)) {
                $activity = new activity($row["activity"],$row["note"],$row["act_id"]);
                $activity->displayTask();
                }
            }else{
                echo "Lets Add Some Activities";
            }
        
        ?>
        </div>
                <div id="add">
                    <form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
                        <label class="input" for="act">Add Task: </label><input name="act" type="text" required>
                        <br>
                        <!-- <label class="input" for="date">Date of Task:</label><input name="date" type="date"> -->
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
                    $sql = "INSERT INTO activities (activity, note, id)
                    VALUES ('$cleanact','$cleannote','1')";
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
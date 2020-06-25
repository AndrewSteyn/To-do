<?php
        session_start();
            //establish  
            include_once 'inc/connect.php';
            include_once 'activityclass.php';

            if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
                header("location: inc/login.php");
                exit;}
?>

<!DOCTYPE html>
<html lang="en">
    <Head>
        <meta charset="utf-8">
        <meta name="vieport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Lato:wght@700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/styles.css">

        <title>What's there 2DO</title>

    </Head>

    <body>
        <div class="center">
        <h1 id="headingg">Your List of Activities!</h1>
            <a class="btn btn-light" href="inc/logout.php" class="w3-button w3-black">LOGOUT</a>
        <br><br>        

            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#exampleModal">
              ADD ACTIVITY
            </button>

            <br>
            <br>              
            <button class="btn btn-light" onclick="sortList()" name="sort" >SORT ALPHABETICALLY</button>

        <div id="activities">
        <?php

        $currentid = $_SESSION["id"];

        function sanitizeString($var)
        {
          include 'inc/connect.php';
          $var = strip_tags($var);
          $var = htmlspecialchars($var);
          $var = stripslashes($var);
          $mysqli->real_escape_string($var);
          return $var;
        }
if (isset($_POST['add'])) {
    $cleanact = sanitizeString($_POST['act']);
    $cleannote = sanitizeString($_POST['note']);
    $cleandate = sanitizeString($_POST['date']);
    $sql = "INSERT INTO activities (activity, note, id, due_date)
    VALUES ('$cleanact','$cleannote','$currentid', '$cleandate')";
    //Execute query and validate success
     if ($mysqli->query($sql)) {
        //echo "New record created successfully";
        unset($sql);
    } else {
         echo "Error: " . $sql . "<br>" . $mysqli->error;
     }	
}

if (isset($_POST['done'])){
  $doneid = $_POST['done'];
  $sql = "DELETE FROM activities
  WHERE id = $currentid AND act_id = '$doneid'";
   if ($mysqli->query($sql)) {
      unset($sql);
}else {
  echo "Error: " . $sql . "<br>" . $mysqli->error;
}
}

if (isset($_POST['edit'])) {

  $cleanEditact = sanitizeString($_POST['edit_act']);
  $cleanEditnote = sanitizeString($_POST['edit_note']);
  $cleanEditdate = sanitizeString($_POST['edit_date']);
  $editId = $_POST['edit'];

  $sql = "UPDATE activities 
          SET activity = '$cleanEditact', note = '$cleanEditnote', due_date = '$cleanEditdate'
          WHERE act_id = '$editId' ";

  //Execute query and validate success
   if ($mysqli->query($sql)) {
      //echo "New record created successfully";
      unset($sql);
  } else {
       echo "Error: " . $sql . "<br>" . $mysqli->error;
   }	
}

        $sql = "SELECT * FROM activities where id = $currentid ORDER BY act_id DESC";
    
        $results = mysqli_query($mysqli, $sql);
              echo '<ul id="id01" >';
        if (mysqli_num_rows($results) > 0) {
            while($row = mysqli_fetch_assoc($results)) {
                $activity = new activity($row["activity"],$row["note"],$row["act_id"],$row["due_date"]);
                $activity->displayTask();
                }
            }else{
                echo "<br> <h3>Lets Add Some Activities</h3>";
            }


        ?>
        </div>


                

                <!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">NEW ACTIVITY</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


      
        <form id="frmBox" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <label class="input" for="act">Add Task: </label><input id="act" name="act" type="text" required>
                        <br>
                        <label class="input" for="date">Date of Task:</label><input id="date" name="date" type="date" required>
                        <br>
                        <label class="input" for="note">Note: </label><input id="note" name="note" type="text" required>
                        <br>
                        <button id="addbut" class="input btn btn-light" type="post" value="Submit" name="add">Add Activity </button>
        </form>

  </div>
</div>
        
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="scripts\todo.js"></script>
    </body>
</html>
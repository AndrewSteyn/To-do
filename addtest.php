<?php
include_once 'connectoop.php';

$sql = "INSERT INTO activities (activity, note, id)
                    VALUES ('addtest','addtest','1')";


($mysqli->query($sql));
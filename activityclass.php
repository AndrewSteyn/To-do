<?php

class activity{
    public $act, $note,$act_id;

    function __construct ($act,$note,$act_id) {
        $this->activity =$act;
        $this->note = $note;
        $this->act_id = $act_id;
    }

    
    function displayTask(){

        echo "<br>
        <div class=\"card\" style=\"width: 18rem;\">
            <div class=\"card-body\">
                <h5 class=\"card-title\">". $this->activity . "</h5>
                <h6 class=\"card-subtitle mb-2 text-muted\">dates</h6>
                <p class=\"card-text\">" . $this->note . "</p>
                <p> This task id" . $this->act_id . "
                <br>
                <form action=\"index.php\" method=\"post\">
                <button type=\"submit\" name=\"edit\" value=\"". $this->act_id ."\" class=\"button\">EDIT</button>
                <button type=\"submit\" name=\"done\" value=". $this->act_id ." class=\"button\">DONE</button>
                </form>
            </div>
        </div>"; 
    }
}






?>
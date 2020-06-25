<?php

class activity{
    public $act, $note,$act_id,$due_date;

    function __construct ($act,$note,$act_id,$due_date) {
        $this->activity =$act;
        $this->note = $note;
        $this->act_id = $act_id;
        $this->due_date = $due_date;
    }

    
    function displayTask(){

        echo "<li><div class=\"invisible\">".$this->activity."</div>
        <br>
        <div class=\"card\" style=\"width: 18rem;\">
            <div class=\"card-body\">
                <h5 class=\"card-title\">". $this->activity . "</h5>
                <p class=\"card-text\">" . $this->note . "</p>
                <p> Due date is " . $this->due_date . "
                <br>
                <form action=\"index.php\" method=\"post\">
                <button class=\"btn btn-light\" type=\"submit\" name=\"done\" value=". $this->act_id ." class=\"button\">DONE</button>
                <br>
                <br>
                </form>
            
                    <button type=\"button\" class=\"btn btn-light\" data-toggle=\"modal\" data-target=\"#exampleModalCenter".$this->act_id."\">
                     Edit Activity
                    </button>


                    <div class=\"modal fade\" id=\"exampleModalCenter".$this->act_id."\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalCenterTitle\" aria-hidden=\"true\">
                        <div class=\"modal-dialog modal-dialog-centered\" role=\"document\">
                        <div class=\"modal-content\">
                        <div class=\"modal-header\">
                        <h5 class=\"modal-title\" id=\"exampleModalLongTitle\">Edit Activity</h5>
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                            <span aria-hidden=\"true\">&times;</span>
                            </button>
                            </div>
                            <div class=\"modal-body\">
                             <form action=\"". htmlspecialchars($_SERVER["PHP_SELF"]) ." \" method=\"post\">
                                <label for=\"edit_act\">Activity</label><input type=\"text\" name=\"edit_act\" required>
                                <br>
                                <label for=\"edit_note\">Note</label><input type=\"text\" name=\"edit_note\" required>
                                <br>
                                <label class=\"input\" for=\"edit_date\">Date of Task:</label><input name=\"edit_date\" type=\"date\" required>
                                </br>
                                <button class=\"btn btn-light\" type=\"submit\" name=\"edit\" value=\"". $this->act_id ."\" class=\"button\">EDIT</button> 
                             </form> 
                            </div>
                            <div class=\"modal-footer\">
                            <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                            </div>
                            </div>
                            </div>
                            </div>
                <div class=\"edit\" id=\"edit".$this->act_id."\" style=\"display: none\">
  
                </div>

                
                
            </div>
        </div>

        </li>"; 
    }
}






?>
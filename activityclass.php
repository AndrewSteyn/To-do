<?php

class activity{
    public $act, $note,$act_id;

    function __construct ($act,$note,$act_id,$due_date) {
        $this->activity =$act;
        $this->note = $note;
        $this->act_id = $act_id;
        $this->due_date = $due_date;
    }

    
    function displayTask(){

        echo "<br>
        <div class=\"card\" style=\"width: 18rem;\">
            <div class=\"card-body\">
                <h5 class=\"card-title\">". $this->activity . "</h5>
                <h6 class=\"card-subtitle mb-2 text-muted\">dates</h6>
                <p class=\"card-text\">" . $this->note . "</p>
                <p> Due date is " . $this->due_date . "
                <br>
                <form action=\"index.php\" method=\"post\">
                <button type=\"submit\" name=\"done\" value=". $this->act_id ." class=\"button\">DONE</button>
                <button class=\"edit\"onclick=\"editFunction()\">EDIT</button>
                </form>
                <div class=\"edit\" id=\"edit".$this->act_id."\" style=\"display: none\">
                    <form action=\index.php\" method=\"post\">
                        <label for=\"edit_act\">Activity</label><input type=\"text\" name=\"edit_act\">
                        <label for=\"edit_note\">Note</label><input type=\"text\" name=\"edit_note\">
                        <button type=\"submit\" name=\"edit\" value=\"". $this->act_id ."\" class=\"button\">EDIT</button> 
                    </form>   
                </div>

                
                
            </div>
        </div>
        <script>
        function editFunction() {
        document.getElementById(\"edit".$this->act_id."\").style.display = \"block\";
                            }
        </script>
        "; 
    }
}






?>
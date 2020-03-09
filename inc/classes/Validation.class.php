<?php
//Developer: Dexter Sharma

class Validation{

    static public $errors = array();

    static function validate_data() {
    
         self::$errors = null;
    
        //Check the request was post
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //if empty textbox
            if (empty($_POST['shortName']))    {
            self::$errors[] = "Please enter a valid short name.";
            }
            else if (empty($_POST['fullName']) )  {
                self::$errors[] = "Please enter a valid full name.";
            }
            //if its not numeric or empty
            else if (empty($_POST['percentile']) || !is_numeric($_POST['percentile']) )  {
                self::$errors[] = "Please enter a valid percentile.";
            }
            else if (empty($_POST['creditHours']) || !is_numeric($_POST['creditHours']))  {
                self::$errors[] = "Please enter a valid credit hours.";
            }
        }


        if($_SERVER["REQUEST_METHOD"] == "GET"){
            if (empty($_GET['shortNameEDIT']))    {
                self::$errors[] = "Please enter a valid short name.";
            }
            else if (empty($_GET['fullNameEDIT']) )  {
                self::$errors[] = "Please enter a valid full name.";
            }
            else if (empty($_GET['percentileEDIT']) || !is_numeric($_GET['percentileEDIT']) )  {
                self::$errors[] = "Please enter a valid percentile.";
            }
            else if (empty($_GET['creditHoursEDIT']) || !is_numeric($_GET['creditHoursEDIT']))  {
                self::$errors[] = "Please enter a valid credit hours.";
            }
        }
    
    }
}

?>
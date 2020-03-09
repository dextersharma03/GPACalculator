<?php
//Developer: Dexter Sharma

class Page  {

    //Title
    public static $_title = "GPA Calculator Dexter Sharma";

    static function setPageTitle(string $title)    {
        self::$_title = $title;
    }

    //This function displays the html header
   static function header() { ?>
    <!doctype html>
    <html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <title><?php echo self::$_title; ?></title>
    </head>
    <body>
        <h1><?php echo self::$_title; ?></h1>

    <?php
    }

  //This function displays the html footer
  static function footer() { ?>
    <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
    </html>
    <?php 
    }

    static function listCourses(Array $courses)    {
        //if there are no courses 
        if(empty($courses)){
            echo " <table>
            <thead>
                <tr><th colspan='10' style = 'padding-top: 20px; padding-bottom: 20px; font-size: 16px'>Sorry there are
                no courses to list, please create one below.</th></tr>
            </thead>  ";
        }else{
        ?>
        
        <table class="table">
        <thead>
            <tr>
            <th>Short Name</th>
            <th>Long Name</th>
            <th>Percentage</th>
            <th>Credit Hours</th>
            <th>Letter Grade</th>
            <th>GPA Points</th>
            <th>Edit</th>
            <th>Delete</th>
            </tr>
        </thead>


        <?php 
        //create the row table
       foreach ($courses as $player)  {
        
        if($player->getPercentile() < 65){
            echo '<tr bgcolor="red">
            <td>'.$player->getShortName().'</td>
            <td>'.$player->getFullName().'</td>
            <td>'.$player->getPercentile().'</td>
            <td>'.$player->getCreditHours().'</td>
            <td>'.$player->getLetterGrade().'</td>
            <td>'.$player->getCalGPA().'</td>
            <td><form method = "GET"><input type="hidden" name="editRowButton" value="'.$player->getCourse().'">'.'<INPUT TYPE="Submit" style="background-color:Khaki" name="editBtn" value="Edit">'.'</form></td>
            <td><form method = "GET"><input type="hidden" name="deleteButton" value="'.$player->getShortName().'">'.'<INPUT TYPE="Submit" style="background-color:Khaki" name="deleteBtn" value="Delete">'.'</td>
                </tr></form>';
        }
        else if($player->getPercentile() >= 65 && $player->getPercentile() < 73){
            echo '<tr bgcolor="yellow">
            <td><input type="hidden" name="td_1" value="'.$player->getShortName().'">'.$player->getShortName().'</td>
            <td>'.$player->getFullName().'</td>
            <td>'.$player->getPercentile().'</td>
            <td>'.$player->getCreditHours().'</td>
            <td>'.$player->getLetterGrade().'</td>
            <td>'.$player->getCalGPA().'</td>
            <td><form method = "GET"><input type="hidden" name="editRowButton" value="'.$player->getCourse().'">'.'<INPUT TYPE="Submit" style="background-color:Khaki" name="editBtn" value="Edit">'.'</form></td>
            <td><form method = "GET"><input type="hidden" name="deleteButton" value="'.$player->getShortName().'">'.'<INPUT TYPE="Submit" style="background-color:Khaki" name="deleteBtn" value="Delete">'.'</td>
                </tr></form>';
        }
        else {
            echo '<tr bgcolor="green">
            <td><input type="hidden" name="td_1" value="'.$player->getShortName().'">'.$player->getShortName().'</td>
            <td>'.$player->getFullName().'</td>
            <td>'.$player->getPercentile().'</td>
            <td>'.$player->getCreditHours().'</td>
            <td>'.$player->getLetterGrade().'</td>
            <td>'.$player->getCalGPA().'</td>
            <td><form method = "GET"><input type="hidden" name="editRowButton" value="'.$player->getCourse().'">'.'<INPUT TYPE="Submit" style="background-color:Khaki" name="editBtn" value="Edit">'.'</form></td>
            <td><form method = "GET"><input type="hidden" name="deleteButton" value="'.$player->getShortName().'">'.'<INPUT TYPE="Submit" style="background-color:Khaki" name="deleteBtn" value="Delete">'.'</td>
                </tr></form>';
        }
        
       }
     } ?>

        </table>
       
      <?php
           
    }

    static function createCourse() { ?>
        <FORM METHOD="POST">
            <TABLE>
                <TR>
                    <TD style="font-size:20px">
                    <b> Create Course </b>
                    </TD>
                </TR>
                <TR>
                    <TD>
                    Short Name <!-- Text input here --> <input style="margin-left:5px" type="text" name="shortName" id="ShortName" size=10 />
                    </TD>
                </TR>
                <TR>
                    <TD>
                    Full Name <!-- Text input here --> <input style="margin-left:18px" type="text" name="fullName" id="FullName" size=15 />
                    </TD>
                </TR>
                <TR>
                    <TD>
                    Percentile <!-- Text input here --> <input style="margin-left:20px" type="text" name="percentile" id="Percentile" size=10 />
                    </TD>
                </TR>
                <TR>
                    <TD>
                    Credit Hours <!-- Text input here --> <input type="text" name="creditHours" id="CreditHours" size=10 />
                    </TD>
                </TR>
            </TABLE>
            <INPUT style="margin-left:5px" TYPE="Submit" name="addBtn" value="Add">
        </FORM>

    <?php }

static function editCourse(Course $course) { ?>
       <FORM METHOD="GET">
            <TABLE>
                <TR>
                    <TD style="font-size:20px">
                    <b> Edit Course </b>
                    </TD>
                </TR>
                <TR>
                    <TD>
                    Short Name <!-- Text input here --> <?php echo "<input type='text' style='margin-left:5px' name='shortNameEDIT' id='ShortName' size=10 
                    value= '".$course->getShortName()."' />" ?>
                    </TD>
                </TR>
                <TR>
                    <TD>
                    Full Name <!-- Text input here --> <?php echo "<input type='text' style='margin-left:18px' name='fullNameEDIT' id='FullName' size=15 
                    value= '".$course->getFullName()."' />" ?>
                    </TD>
                </TR>
                <TR>
                    <TD>
                    Percentile <!-- Text input here --> <?php echo "<input type='text' style='margin-left:20px' name='percentileEDIT' id='Percentile' size=10 
                    value= '".$course->getPercentile()."' />" ?>
                    </TD>
                </TR>
                <TR>
                    <TD>
                    Credit Hours <!-- Text input here --> <?php echo "<input type='text' name='creditHoursEDIT' id='CreditHours' size=10 
                    value= '".$course->getCreditHours()."' />" ?>
                    </TD>
                </TR>
            </TABLE>
            <INPUT style="margin-left:5px" TYPE="Submit" name="editBtn" value="Edit">
        </FORM>
    <?php }

static function showGPA(Array $courses)  {
    //if no courses
        if(empty($courses)){
            echo " <table>
            <thead>
                <tr><th colspan='10' style = 'padding-top: 20px; padding-bottom: 20px; font-size: 16px'>Please enter some 
                courses to have your GPA calculated.</th></tr>
            </thead>  ";
        } 
        else{
            //calculate the gpa
            $credits = 0; $hours= 0;
            foreach ($courses as $player)  {
                $credits += $player->getCreditHours() * $player->getCalGPA();
                $hours += $player->getCreditHours();
            }
            $gpa = $credits / $hours;


            echo " <table>
            <thead>
                <tr><th colspan='10' style = 'padding-top: 20px; padding-bottom: 20px; font-size: 25px'>The GPA for the
                courses listed is: ".number_format((float)$gpa, 2, '.', '')."</th></tr>
            </thead>  ";
        }

        
      }

static function showErrors($errors){?>
	<DIV style="">
	

	<UL>
	<?php	foreach($errors as $error)	{
		echo "<LI>$error</LI>";
		} ?>
	</UL>
	</DIV>
<?php

}

}

?>
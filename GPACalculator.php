<?php

//Developer: Dexter Sharma

//Reqiure config file
require_once("inc/config.inc.php");

// //Require interfaces
require_once("inc/classes/ICourse.class.php");
require_once("inc/classes/ICourseService.class.php");
require_once("inc/classes/IFileService.class.php");

// //Require classes
require_once("inc/classes/Page.class.php");
require_once("inc/classes/Validation.class.php");
require_once("inc/classes/FileService.class.php");
require_once("inc/classes/Course.class.php");
require_once("inc/classes/CourseService.class.php");

Page::header();

//If there was a post to create then create
if ($_SERVER["REQUEST_METHOD"] == "POST")	{

        //Validate the data
        Validation::validate_data();
        if(empty(Validation::$errors)){

                //Assemble the new course
                $nwCourse = new Course();

                //Add the new course
                if(CourseService::insertCourse($nwCourse)){
                        CourseService::writeTranscript();

                //write to the disk
                $contents =  CourseService::$CSVString;
                FileService::write($contents);
                }    
        }
        else
        {       //if errors were found, display them
                Page::showErrors(Validation::$errors);
        }
}

//If there was a get to delete then delete
if($_SERVER["REQUEST_METHOD"] == "GET"){

        //if the delete button was clicked
        if(isset($_GET["deleteButton"])){
        $val = $_GET["deleteButton"];
        CourseService::deleteCourse($val);
        }

        //if updating or clicking on edit btn (as the submit button) in the form
        if(isset($_GET["shortNameEDIT"])){
            //check for validation
            Validation::validate_data();
            if(empty(Validation::$errors)){
                $nwCourse = new Course();

                //get the strings/numbers
                $shortName = $_GET["shortNameEDIT"];
                $fullName = $_GET["fullNameEDIT"];
                $percentile = $_GET["percentileEDIT"];
                $creditHours = $_GET["creditHoursEDIT"];

                //pass it to the course object
                $nwCourse->setShortName($shortName);
                $nwCourse->setFullName($fullName);
                $nwCourse->setPercentile($percentile);
                $nwCourse->setCreditHours($creditHours);

                //pass the course object to update them in file
                CourseService::updateCourse($nwCourse);
            }else
              {
                Page::showErrors(Validation::$errors);
                }
        }
   
        //If someone wanted to edit a course then show the edit form otherwise show the create form
        //when edit is clicked in the table row
        if(isset($_GET["editRowButton"])){
                $nwCourse = new Course();

                //get all the values from the table row
                $val = $_GET["editRowButton"];
                $arr =  explode("|", $val);

                //set it in course object
                $nwCourse->setShortName($arr[0]);
                $nwCourse->setFullName($arr[1]);
                $nwCourse->setPercentile($arr[2]);
                $nwCourse->setCreditHours($arr[3]);

                //sort the courses
                CourseService::sortCourses();
                $array = CourseService::getCourses();

                //list them
                Page::listCourses($array);
                //Show GPA
                Page::showGPA($array);

                //pass the course object for edit, which will display the edit course form
                Page::editCourse($nwCourse);

                Page::footer();

                exit;
        }

}
//sort the courses
CourseService::sortCourses();
$array = CourseService::getCourses();

//List Courses
Page::listCourses($array);
//Show GPA
Page::showGPA($array);
Page::createCourse();

//Show the footer
Page::footer();
?>
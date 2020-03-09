<?php
//Developer: Dexter Sharma

class CourseService implements ICourseService {

    //Store the courses in an array
    static public $courses = array();
    static public $CSVString = array();


    //This function creates a single course
    static function insertCourse(Course $newCourse) : bool{

        static $count = 0;
        $newCourse->setShortName($_POST['shortName']);
        $newCourse->setFullName($_POST['fullName']);
        $newCourse->setPercentile($_POST['percentile']);
        $newCourse->setCreditHours($_POST['creditHours']);
        $newCourse->getLetterGrade();
        $newCourse->getCalGPA();

        self::$courses[$count] = $newCourse;
        $count++;
        return true;
    }


    //This function reads a single course given the title.
    static function getCourse(string $shortName) : Course{

        $givenCourse = new Course();

        try{
            if($shortName == $givenCourse->getShortName()){
                $givenCourse->getCourse();
            }
    
        } catch (Exception $ex) {
        //Exception Mesage the user
            echo $ex->getMessage();
        //Wirte to the error log
        //Exception to the log file.
        error_log($ex->getMessage(),0);
        }
    }

    //This function returns a list of courses, course objects in an array.
    static function getCourses(): array{
     $array = array();
     if(file_exists(DATA_FILE)){
        try {
            //Open a file handle
            $fileHandle = fopen(DATA_FILE, 'r');
            if (!$fileHandle)   {
                throw new Exception("We were not able to open the specified file.");
            }
            //Read in the contents of the file
            $fileContents = fread($fileHandle,filesize(DATA_FILE));
    
            //Check if the contents are empty, if they are then throw an exception
            if (empty($fileContents) || is_null($fileContents)) {
                throw new Exception("We were not able to read any data in the specified file.");
            }
    
            //Catch the exception
        } catch (Exception $ex) {
                //Wirte to the error log
                error_log($ex->getMessage(),0);
        }
    
        //Close the file handle
        fclose($fileHandle);
        
       $lines = explode("\n",$fileContents);

       //Iterate through the new lines
       for ($x = 1; $x < count($lines)-1; $x++)   {
               try {
               //Cut up the lines by comma
               $columns = explode(",", $lines[$x]);

               //check if there is double quotes in the begining or end, if so then remove
               while(substr($columns[0],0,1) == '"') {
                $columns[0] = substr($columns[0],1);
                }
                while(substr($columns[1],0,1) == '"'){
                    $columns[1] = substr($columns[1],1);
                }
                while(substr($columns[0],-1) == '"'){
                    $columns[0] = substr($columns[0],0,-1);
                }
                while(substr($columns[1],-1) == '"'){
                    $columns[1] = substr($columns[1],0,-1);
                }
               
                   //Make sure the course has the appropriate number
                   if (count($columns) == 6)   {
   
                   //Build an course
                   $newCourse = new Course();
                   //Populate the attributes
                   $newCourse->setShortName($columns[0]);
                   $newCourse->setFullName($columns[1]);
                   $newCourse->setPercentile($columns[2]);
                   $newCourse->setCreditHours($columns[3]);
   
                   //Push the course to the collection
                   $array[] = $newCourse;

               } else {
                   //Throw an exception with the appropriate message
                   throw new Exception("Problem parsing file at line ".($x + 1)."");
               }
   
   
               } catch (Exception $ex) {
                   //Barf the exception out to the user
                   echo $ex->getMessage();
                   //log it
                   error_log($ex->getMessage(), 0);
               }
           }   
         //Return the courses        
        return $array;
        }else return $array;      
    }

    //Sort the courses
    static function sortCourses(){
        $array = array();
        if(file_exists(DATA_FILE)){
            try {
                //Open a file handle
                $fileHandle = fopen(DATA_FILE, 'r');
                if (!$fileHandle)   {
                    throw new Exception("We were not able to open the specified file.");
                }
                //Read in the contents of the file
                $fileContents = fread($fileHandle,filesize(DATA_FILE));
        
                //Check if the contents are empty, if they are then throw an exception
                if (empty($fileContents) || is_null($fileContents)) {
                    throw new Exception("We were not able to read any data in the specified file.");
                }
        
                //Catch the exception
            } catch (Exception $ex) {
                    //Wirte to the error log
                    error_log($ex->getMessage(),0);
            }
        
            //Close the file handle
            fclose($fileHandle);
            
           $lines = explode("\n",$fileContents);
    
           //Iterate through the new lines
           for ($x = 1; $x < count($lines)-1; $x++)   {
                   try {
                   //Cut up the lines by comma
                   $columns = explode(",", $lines[$x]);
                   //check if there is double quotes in the begining or end, if so then remove

                while(substr($columns[0],0,1) == '"') {
                    $columns[0] = substr($columns[0],1);
                }
                while(substr($columns[1],0,1) == '"'){
                    $columns[1] = substr($columns[1],1);
                }
                while(substr($columns[0],-1) == '"'){
                    $columns[0] = substr($columns[0],0,-1);
                }
                while(substr($columns[1],-1) == '"'){
                    $columns[1] = substr($columns[1],0,-1);
                }
                       //Make sure the course has the appropriate number
                       if (count($columns) == 6)   {
       
                            //Build an course
                            $newCourse = new Course();
                            //Populate the attributes
                            $newCourse->setShortName($columns[0]);
                            $newCourse->setFullName($columns[1]);
                            $newCourse->setPercentile($columns[2]);
                            $newCourse->setCreditHours($columns[3]);
                                
                            //Push the course to the collection
                            $array[] = $newCourse;       
       
                        } else {
                            //Throw an exception with the appropriate message
                            throw new Exception("Problem parsing file at line ".($x + 1)."");
                        }
            
                   } catch (Exception $ex) {
                       //Barf the exception out to the user
                       echo $ex->getMessage();
                       //log it
                       error_log($ex->getMessage(), 0);
                   }
               }
               
               function sortbyPercentile($a, $b) {
                    if($a->getPercentile() == $b->getPercentile()){ return 0 ; }
                    return ($a->getPercentile() < $b->getPercentile()) ? 1 : -1;
                }
    
               self::$CSVString =  $array;

               //sort by percentile
               usort($array, 'sortbyPercentile');

               $fileHandle = fopen(DATA_FILE,"w");
                
               $header = array("coursecode","fullname","percentile","credithours");
    
               fputcsv($fileHandle, $header);
                //Itereate through the array nd create the CSV file
            
                    foreach ($array as $line) {
                        fputcsv($fileHandle, (array)$line, ',');
                    }
    
    
                //Check if the contents are empty, if they are then throw an exception
                if (!$fileHandle)   {
                    throw new Exception("We were not able to open the specified file.");
                }
               return true;
            }
    }

    //This function deletes coursesthe givren course
    static function deleteCourse(string $shortName) : bool{

        $array = array();
        if(file_exists(DATA_FILE)){
            try {
                //Open a file handle
                $fileHandle = fopen(DATA_FILE, 'r');
                if (!$fileHandle)   {
                    throw new Exception("We were not able to open the specified file.");
                }
                //Read in the contents of the file
                $fileContents = fread($fileHandle,filesize(DATA_FILE));
        
                //Check if the contents are empty, if they are then throw an exception
                if (empty($fileContents) || is_null($fileContents)) {
                    throw new Exception("We were not able to read any data in the specified file.");
                }
        
                //Catch the exception
            } catch (Exception $ex) {
                    //Wirte to the error log
                    error_log($ex->getMessage(),0);
            }
        
            //Close the file handle
            fclose($fileHandle);
            
           $lines = explode("\n",$fileContents);
    
           //Iterate through the new lines
           for ($x = 1; $x < count($lines)-1; $x++)   {
                   try {
                   //Cut up the lines by comma
                   $columns = explode(",", $lines[$x]);
                   
                   while(substr($columns[0],0,1) == '"') {
                    $columns[0] = substr($columns[0],1);
                    }
                    while(substr($columns[1],0,1) == '"'){
                        $columns[1] = substr($columns[1],1);
                    }
                    while(substr($columns[0],-1) == '"'){
                        $columns[0] = substr($columns[0],0,-1);
                    }
                    while(substr($columns[1],-1) == '"'){
                        $columns[1] = substr($columns[1],0,-1);
                    }
                       //Make sure the course has the appropriate number
                       if (count($columns) == 6)   {
       
                        //if shortname is equals then do nothing
                        if($shortName == $columns[0]){
                        
                        }
                        else{
                            //Build an course
                            $newCourse = new Course();
                            //Populate the attributes
                            $newCourse->setShortName($columns[0]);
                            $newCourse->setFullName($columns[1]);
                            $newCourse->setPercentile($columns[2]);
                            $newCourse->setCreditHours($columns[3]);
                                
                            //Push the course to the collection
                            $array[] = $newCourse;

                        }

                   } else {
                       //Throw an exception with the appropriate message
                       throw new Exception("Problem parsing file at line ".($x + 1)."");
                   }
       
                   } catch (Exception $ex) {
                       //Barf the exception out to the user
                       echo $ex->getMessage();
                       //log it
                       error_log($ex->getMessage(), 0);
                   }
               }
               
               self::$CSVString =  $array;

               $fileHandle = fopen(DATA_FILE,"w");
                
               $header = array("coursecode","fullname","percentile","credithours");
    
               fputcsv($fileHandle, $header);
                //Itereate through the array nd create the CSV file
            
                    foreach ($array as $line) {
                        fputcsv($fileHandle, (array)$line, ',');
                    }
    
                //Check if the contents are empty, if they are then throw an exception
                if (!$fileHandle)   {
                    throw new Exception("We were not able to open the specified file.");
                }
               return true;
            } else return false;
    }

    //This function updates and course in the file.
    static function updateCourse(Course $updatedCourse) : bool{

        $array = array();
        if(file_exists(DATA_FILE)){
            try {
                //Open a file handle
                $fileHandle = fopen(DATA_FILE, 'r');
                if (!$fileHandle)   {
                    throw new Exception("We were not able to open the specified file.");
                }
                //Read in the contents of the file
                $fileContents = fread($fileHandle,filesize(DATA_FILE));
        
                //Check if the contents are empty, if they are then throw an exception
                if (empty($fileContents) || is_null($fileContents)) {
                    throw new Exception("We were not able to read any data in the specified file.");
                }
        
                //Catch the exception
            } catch (Exception $ex) {
                    //Wirte to the error log
                    error_log($ex->getMessage(),0);
            }
        
            //Close the file handle
            fclose($fileHandle);
            
           $lines = explode("\n",$fileContents);
    
           //Iterate through the new lines
           for ($x = 1; $x < count($lines)-1; $x++)   {
                   try {
                   //Cut up the lines by comma
                   $columns = explode(",", $lines[$x]);
                   while(substr($columns[0],0,1) == '"') {
                    $columns[0] = substr($columns[0],1);
                    }
                    while(substr($columns[1],0,1) == '"'){
                        $columns[1] = substr($columns[1],1);
                    }
                    while(substr($columns[0],-1) == '"'){
                        $columns[0] = substr($columns[0],0,-1);
                    }
                    while(substr($columns[1],-1) == '"'){
                        $columns[1] = substr($columns[1],0,-1);
                    }
                       //Make sure the course has the appropriate number
                       if (count($columns) == 6)   {
       
                       //Build an course
                       $newCourse = new Course();
                       //Populate the attributes
                       
                        //if the updated course is equals to selected course, then change
                       if($updatedCourse->getShortName() == $columns[0]){
                        $newCourse->setShortName($updatedCourse->getShortName());
                        $newCourse->setFullName($updatedCourse->getFullName());
                        $newCourse->setPercentile($updatedCourse->getPercentile());
                        $newCourse->setCreditHours($updatedCourse->getCreditHours());
                       }
                       else{
                        $newCourse->setShortName($columns[0]);
                        $newCourse->setFullName($columns[1]);
                        $newCourse->setPercentile($columns[2]);
                        $newCourse->setCreditHours($columns[3]);
                       }
                       
                       //Push the course  to the collection
                       $array[] = $newCourse;
       
                   } else {
                       //Throw an exception with the appropriate message
                       throw new Exception("Problem parsing file at line ".($x + 1)."");
                   }
    
                   } catch (Exception $ex) {
                       //Barf the exception out to the user
                       echo $ex->getMessage();
                       //log it
                       error_log($ex->getMessage(), 0);
                   }
               }
            
               $fileHandle = fopen(DATA_FILE,"w");
                
               $header = array("coursecode","fullname","percentile","credithours");
    
               fputcsv($fileHandle, $header);
                //Itereate through the array nd create the CSV file
            
                    foreach ($array as $line) {
                        fputcsv($fileHandle, (array)$line, ',');
                    }
    
                //Check if the contents are empty, if they are then throw an exception
                if (!$fileHandle)   {
                    throw new Exception("We were not able to open the specified file.");
                }
               return true;
            } else return false;
    }

    //This function writes the contents of self::$course to disk
    static function writeTranscript() : bool{

        try {

         foreach (self::$courses as $line) {
           self::$CSVString[] = $line;
        }

        }catch (Exception $ex) {
            //Barf the exception out to the user
            echo $ex->getMessage();
            //log it
            error_log($ex->getMessage(), 0);
        }

        return true;
    }

    //This function will parse out the CSV contents
    static function parse($contents){
        //Explode by the new line character.
        $lines = explode("\n",$contents);
        //Iterate through the new lines
        for ($x = 1; $x < count($lines); $x++)   {
                try {
                //Cut up the lines by comma
                $columns = explode(",", $lines[$x]);
                
                while(substr($columns[0],0,1) == '"') {
                    $columns[0] = substr($columns[0],1);
                }
                while(substr($columns[1],0,1) == '"'){
                    $columns[1] = substr($columns[1],1);
                }
                while(substr($columns[0],-1) == '"'){
                    $columns[0] = substr($columns[0],0,-1);
                }
                while(substr($columns[1],-1) == '"'){
                    $columns[1] = substr($columns[1],0,-1);
                }
                    //Make sure the course has the appropriate number
                    if (count($columns) == 4)   {

                    //Build an course
                    $newCourse = new Course();
                    //Populate the attributes
                    $newCourse->setShortName($columns[0]);
                    $newCourse->setFullName($columns[1]);
                    $newCourse->setPercentile($columns[2]);
                    $newCourse->setCreditHours($columns[3]);

                    //Push the course to the collection
                    self::$courses[] = $newCourse;


                } else {
                    //Throw an exception with the appropriate message
                    throw new Exception("Problem parsing file at line ".($x + 1)."");
                }


                } catch (Exception $ex) {
                    //Barf the exception out to the user
                    echo $ex->getMessage();
                    //log it
                    error_log($ex->getMessage(), 0);
                }
            }
        }

}
?>
                
<?php

//Developer: Dexter Sharma

class FileService implements IFileService {

    //This function reads the file
        static function read(): string {

            try{
            $fileHandle = fopen(DATA_FILE, 'r');
            $fileContents = fread($fileHandle,filesize($fileName));
            fclose($fileHandle);
    
            //Clear the file cache
            clearstatcache();
            }
            catch(Exception $ex) {
            error_log($ex->getMessage(), 0);
            echo $ex->getMessage();
            }
            return $fileContents;
           
    }

    //This function will write the file contents
    static function write($contents) {

        try {
            //Open the file handle with the write mode
            if(!file_exists(DATA_FILE)){
                $fileHandle = fopen(DATA_FILE,"w");

                $header = array("coursecode","fullname","percentile","credithours");
    
                fputcsv($fileHandle, $header);
                //Itereate through the array nd create the CSV file
            
                    foreach ($contents as $line) {
                        fputcsv($fileHandle, (array)$line, ',');
                    }
    
    
                //Check if the contents are empty, if they are then throw an exception
                if (!$fileHandle)   {
                    throw new Exception("We were not able to open the specified file.");
                }
            }
            else{
                $fileHandle = fopen(DATA_FILE,"a");
                
                //Itereate through the array nd create the CSV file
            
                    foreach ($contents as $line) {
                        fputcsv($fileHandle, (array)$line, ',');
                    }
    
    
                //Check if the contents are empty, if they are then throw an exception
                if (!$fileHandle)   {
                    throw new Exception("We were not able to open the specified file.");
                }
            }
            //Catch the exception
            }catch (Exception $ex) {
                echo $ex->getMessage();
        
                    //Wirte to the error log
                    error_log($ex->getMessage(), 0);
            }
        
            
            
        fclose($fileHandle);

    }

}
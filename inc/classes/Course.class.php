<?php
//Developer: Dexter Sharma

class Course implements ICourse{
  
    private $_shortName = "";
    private $_fullName = "";
    private $_percentile = 0;
    private $_creditHours = 0;
    private $_letterGrade;
    private $_gpaPoints;
    
    public function getCourse() : string {
        $courseDetail = $this->_shortName."|".$this->_fullName."|".$this->_percentile."|".$this->_creditHours;
        return $courseDetail;
    }
    
    //Getters
    public function getFullName() : string {
        return $this->_fullName;
    }

    public function getShortName() : string {
        return $this->_shortName;
    }

    public function getPercentile() : float {
        $this->getLetterGrade();
        return $this->_percentile;
    }

    //Call getLetterGrade becuase we need it later.
    public function getLetterGrade() : string{
       if($this->_percentile <= 49){
        return $this->_letterGrade = "F";
       }
       else if($this->_percentile >= 50 && $this->_percentile <= 54){
        return $this->_letterGrade = "P";
       }
       else if($this->_percentile >= 55 && $this->_percentile <= 59){
        return $this->_letterGrade = "C-";
       }
       else if($this->_percentile >= 60 && $this->_percentile <= 64){
        return $this->_letterGrade = "C";
       }
       else if($this->_percentile >= 65 && $this->_percentile <= 69){
        return $this->_letterGrade = "C+";
       }
       else if($this->_percentile >= 70 && $this->_percentile <= 74){
        return $this->_letterGrade = "B-";
       }
       else if($this->_percentile >= 75 && $this->_percentile <= 79){
        return $this->_letterGrade = "B";
       }
       else if($this->_percentile >= 80 && $this->_percentile <= 84){
        return $this->_letterGrade = "B+";
       }
       else if($this->_percentile >= 85 && $this->_percentile <= 89){
        return $this->_letterGrade = "A-";
       }
       else if($this->_percentile >= 90 && $this->_percentile <= 94){
        return $this->_letterGrade = "A";
       }
       else if($this->_percentile >= 95){
        return $this->_letterGrade = "A+";
       }
    }

    //Calculate the GPA points based on the letter grade
    public function getCalGPA() : float{
        if($this->_letterGrade == "F"){
            return $this->_gpaPoints = 0.00;
        }
        else if($this->_letterGrade == "P"){
            return $this->_gpaPoints = 1.00;
        }
        else if($this->_letterGrade == "C-"){
            return $this->_gpaPoints = 1.67;
        }
        else if($this->_letterGrade == "C"){
            return $this->_gpaPoints = 2.00;
        }
        else if($this->_letterGrade == "C+"){
            return $this->_gpaPoints = 2.33;
        }
        else if($this->_letterGrade == "B-"){
            return $this->_gpaPoints = 2.67;
        }
        else if($this->_letterGrade == "B"){
            return $this->_gpaPoints = 3.00;
        }
        else if($this->_letterGrade == "B+"){
            return $this->_gpaPoints = 3.33;
        }
        else if($this->_letterGrade == "A-"){
            return $this->_gpaPoints = 3.67;
        }
        else if($this->_letterGrade == "A"){
            return $this->_gpaPoints = 4.00;
        }
        else if($this->_letterGrade == "A+"){
            return $this->_gpaPoints = 4.33;
        }
    }

    public function getCreditHours() : int{
        return $this->_creditHours;
    }

    //Setters
    public function setFullName(string $fullName){
        $this->_fullName = $fullName;
    }

    public function setPercentile(string $percentile){
        $this->_percentile = floatval($percentile);
    }

    public function setShortName(string $shortName){
        $this->_shortName = $shortName;
    }    
    
    public function setCreditHours(int $creditHours){
        $this->_creditHours = $creditHours;
    }
}

?>
<?php
//Developer: Dexter Sharma

interface ICourseService {

    static function sortCourses();

    static function insertCourse(Course $newCourse) : bool;
    
    static function getCourse(string $shortName) : Course;

    static function getCourses(): array;

    static function deleteCourse(string $shortName) : bool;

    static function updateCourse(Course $updatedCourse) : bool;

    static function writeTranscript() : bool;

    static function parse($contents);

}
    
?>
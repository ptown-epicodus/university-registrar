<?php
class Course
{
    private $id;
    private $name;
    private $course_number;

    function __construct($name, $course_number, $id = null)
    {
        $this->name = $name;
        $this->course_number = $course_number;
        $this->id = $id;
    }

    function getId()
    {
        return $this->id;
    }

    function getName()
    {
        return $this->name;
    }

    function setName($new_name)
    {
        $this->name = $new_name;
    }

    function getCourseNumber()
    {
        return $this->course_number;
    }

    function setCourseNumber($new_course_number)
    {
        $this->course_number = $new_course_number;
    }
}
?>

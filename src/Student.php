<?php
class Student
{
    private $id;
    private $name;
    private $enrollment_date;

    function __construct($name, $enrollment_date, $id = null)
    {
        $this->name = $name;
        $this->enrollment_date = $enrollment_date;
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

    function getEnrollmentDate()
    {
        return $this->enrollment_date;
    }

    function setEnrollmentDate($new_enrollment_date)
    {
        $this->enrollment_date = $new_enrollment_date;
    }
}
?>

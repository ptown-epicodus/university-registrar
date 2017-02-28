<?php
class Student
{
    private $id;
    private $name;
    private $enrollment_date;

    function __construct($name, $enrollment_date, $id = null)
    {
        $this->name = (string) $name;
        $enrollment_date->setTime(0, 0, 0);
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
        $this->name = (string) $new_name;
    }

    function getEnrollmentDate()
    {
        return $this->enrollment_date;
    }

    function setEnrollmentDate($new_enrollment_date)
    {
        $new_enrollment_date->setTime(0, 0, 0);
        $this->enrollment_date = $new_enrollment_date;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO students (name, enrollment_date) VALUES ('{$this->getName()}', STR_TO_DATE('{$this->getEnrollmentDate()->format('Y-m-d')}', '%Y-%m-%d'));");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function getAll()
    {
        $students = [];
        $queried_students = $GLOBALS['DB']->query("SELECT * FROM students;");
        foreach ($queried_students as $student) {
            $id = $student['id'];
            $name = $student['name'];
            $enrollment_date = new DateTime($student['enrollment_date']);
            $new_student = new Student($name, $enrollment_date, $id);
            array_push($students, $new_student);
        }
        return $students;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM students;");
    }

    static function find($search_id)
    {
        $found_student = null;
        $students = Student::getAll();
        foreach($students as $student) {
            $id = $student->getId();
            if ($id == $search_id) {
                $found_student = $student;
            }
        }
        return $found_student;
    }
}
?>

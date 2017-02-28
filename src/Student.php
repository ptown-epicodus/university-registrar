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

    function update($new_name)
    {
        $GLOBALS['DB']->exec("UPDATE students SET name = '{$new_name}' WHERE id = {$this->getId()};");
        $this->setName($new_name);
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM students WHERE id = {$this->getId()};");
        $GLOBALS['DB']->exec("DELETE FROM enrollments WHERE student_id = {$this->getId()};");
    }

    function addCourse($new_course)
    {
        $GLOBALS['DB']->exec("INSERT INTO enrollments (course_id, student_id) VALUES ({$new_course->getId()}, {$this->getId()});");
    }

    function getCourses()
    {
        $returned_courses = $GLOBALS['DB']->query("SELECT courses.* FROM students JOIN enrollments ON (enrollments.student_id = students.id) JOIN courses ON (courses.id = enrollments.course_id) WHERE students.id = {$this->getId()};");
        $courses = array();
        foreach($returned_courses as $course) {
            $id = $course['id'];
            $name = $course['name'];
            $course_number = $course['course_number'];
            $new_course = new Course($name, $course_number, $id);
            array_push($courses, $new_course);
        }
        return $courses;
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
        $query = $GLOBALS['DB']->query("SELECT * FROM students WHERE id = {$search_id};");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $id = $result['id'];
            $name = $result['name'];
            $enrollment_date = new DateTime($result['enrollment_date']);
            $found_student = new Student($name, $enrollment_date, $id);
        }
        return $found_student;
    }
}
?>

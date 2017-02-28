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

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO courses (name, course_number) VALUES ('{$this->getName()}', '{$this->getCourseNumber()}');");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    function update($new_name)
    {
        $GLOBALS['DB']->exec("UPDATE courses SET name = '$new_name' WHERE id = {$this->getId()};");
        $this->setName($new_name);
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM courses WHERE id = {$this->getId()};");
    }

    function addStudent($student)
    {
        $GLOBALS['DB']->exec("INSERT INTO enrollments (course_id, student_id) VALUES ({$this->getId()}, {$student->getId()});");
    }

    function getStudents()
    {
        $returned_students = $GLOBALS['DB']->query("SELECT students.* FROM courses JOIN enrollments ON (enrollments.course_id = courses.id) JOIN students ON (students.id = enrollments.student_id) WHERE courses.id = {$this->getId()};");
        $students = array();
        foreach($returned_students as $student) {
            $name = $student['name'];
            $id = $student['id'];
            $enrollment_date = new DateTime($student['enrollment_date']);
            $new_student = new Student($name, $enrollment_date, $id);
            array_push($students, $new_student);
        }
        return $students;
    }

    static function getAll()
    {
        $courses = [];
        $queried_courses = $GLOBALS['DB']->query("SELECT * FROM courses;");
        foreach ($queried_courses as $course) {
            $id = $course['id'];
            $name = $course['name'];
            $course_number = $course['course_number'];
            $new_course = new Course($name, $course_number, $id);
            array_push($courses, $new_course);
        }
        return $courses;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM courses;");
    }

    static function find($search_id)
    {
        $found_course = null;
        $query = $GLOBALS['DB']->query("SELECT * FROM courses WHERE id = {$search_id};");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $id = $result['id'];
            $name = $result['name'];
            $course_number = $result['course_number'];
            $found_course = new Course($name, $course_number, $id);
        }
        return $found_course;
    }
}
?>

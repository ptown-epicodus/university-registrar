<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once 'src/Course.php';

class CourseTest extends PHPUnit_Framework_TestCase
{
    function test_getId()
    {
        //Arrange
        $id = 1;
        $name = 'Calculus';
        $course_number = 'MATH201';
        $test_Course = new Course($name, $course_number, $id);

        //Act
        $result = $test_Course->getId();

        //Assert
        $this->assertEquals(1, $result);
    }

    function test_getName()
    {
        //Arrange
        $name = 'Calculus';
        $course_number = 'MATH201';
        $test_Course = new Course($name, $course_number);

        //Act
        $result = $test_Course->getName();

        $this->assertEquals('Calculus', $result);
    }

    function test_setName()
    {
        //Arrange
        $name = 'Calculus';
        $new_name = 'Geometry';
        $course_number = 'MATH201';
        $test_Course = new Course($name, $course_number);

        //Act
        $test_Course->setName($new_name);
        $result = $test_Course->getName();

        $this->assertEquals('Geometry', $result);
    }

    function test_getCourseNumber()
    {
        //Arrange
        $name = 'Calculus';
        $course_number = 'MATH201';
        $test_Course = new Course($name, $course_number);

        //Act
        $result = $test_Course->getCourseNumber();

        $this->assertEquals('MATH201', $result);
    }

    function test_setCourseNumber()
    {
        //Arrange
        $name = 'Calculus';
        $course_number = 'MATH201';
        $new_course_number = 'MATH202';
        $test_Course = new Course($name, $course_number);

        //Act
        $test_Course->setCourseNumber($new_course_number);
        $result = $test_Course->getCourseNumber();

        $this->assertEquals('MATH202', $result);
    }
}
?>

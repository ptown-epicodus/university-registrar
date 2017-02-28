<?php
require_once 'src/Student.php';

class StudentTest extends PHPUnit_Framework_TestCase
{
    function test_getId()
    {
        //Arrange
        $name = 'John Doe';
        $id = 1;
        $enrollment_date = new DateTime();
        $test_Student = new Student($name, $enrollment_date, $id);

        //Act
        $result = $test_Student->getId();

        //Assert
        $this->assertEquals(1, $result);
    }

    function test_getName()
    {
        //Arrange
        $name = 'John Doe';
        $enrollment_date = new DateTime();
        $test_Student = new Student($name, $enrollment_date);

        //Act
        $result = $test_Student->getName();

        $this->assertEquals('John Doe', $result);
    }

    function test_setName()
    {
        //Arrange
        $name = 'John Doe';
        $new_name = 'Jane Doe';
        $enrollment_date = new DateTime();
        $test_Student = new Student($name, $enrollment_date);

        //Act
        $test_Student->setName($new_name);
        $result = $test_Student->getName();

        //Assert
        $this->assertEquals('Jane Doe', $result);
    }

    function test_getEnrollmentDate()
    {
        //Arrange
        $name = 'John Doe';
        $enrollment_date = new DateTime('1970-01-01');
        $test_Student = new Student($name, $enrollment_date);

        //Act
        $result = $test_Student->getEnrollmentDate();

        //Assert
        $this->assertEquals(new DateTime('1970-01-01'), $result);
    }

    function test_setEnrollmentDate()
    {
        //Arrange
        $name = 'John Doe';
        $enrollment_date = new DateTime('1970-01-01');
        $new_enrollment_date = new DateTime('2000-01-01');
        $test_Student = new Student($name, $enrollment_date);

        //Act
        $test_Student->setEnrollmentDate($new_enrollment_date);
        $result = $test_Student->getEnrollmentDate();

        $this->assertEquals(new DateTime('2000-01-01'), $result);
    }
}
?>

<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once 'src/Student.php';

$server = 'mysql:host=localhost:8889;dbname=university_registrar_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class StudentTest extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Student::deleteAll();
    }

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

    function test_save()
    {
        //Arrange
        $name = 'John Doe';
        $enrollment_date = new DateTime();
        $test_Student = new Student($name, $enrollment_date);

        //Act
        $test_Student->save();
        $result = Student::getAll();

        //Assert
        $this->assertEquals([$test_Student], $result);
    }

    function test_getAll()
    {
        //Arrange
        $name1 = 'John Doe';
        $name2 = 'Jane Doe';
        $enrollment_date1 = new DateTime();
        $enrollment_date2 = new DateTime();
        $test_Student1 = new Student($name1, $enrollment_date1);
        $test_Student1->save();
        $test_Student2 = new Student($name2, $enrollment_date2);
        $test_Student2->save();

        //Act
        $result = Student::getAll();

        //Assert
        $this->assertEquals([$test_Student1, $test_Student2], $result);
    }

    function test_deleteAll()
    {
        //Arrange
        $name1 = 'John Doe';
        $name2 = 'Jane Doe';
        $enrollment_date1 = new DateTime();
        $enrollment_date2 = new DateTime();
        $test_Student1 = new Student($name1, $enrollment_date1);
        $test_Student1->save();
        $test_Student2 = new Student($name2, $enrollment_date2);
        $test_Student2->save();

        //Act
        Student::deleteAll();
        $result = Student::getAll();

        //Assert
        $this->assertEquals([], $result);
    }

    function test_find()
    {
        //Arrange
        $name1 = 'John Doe';
        $name2 = 'Jane Doe';
        $enrollment_date1 = new DateTime();
        $enrollment_date2 = new DateTime();
        $test_Student1 = new Student($name1, $enrollment_date1);
        $test_Student1->save();
        $test_Student2 = new Student($name2, $enrollment_date2);
        $test_Student2->save();

        //Act
        $result = Student::find($test_Student1->getId());

        //Assert
        $this->assertEquals($test_Student1, $result);
    }
}
?>

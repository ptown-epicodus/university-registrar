<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once 'src/Course.php';
require_once 'src/Student.php';

$server = 'mysql:host=localhost:8889;dbname=university_registrar_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class CourseTest extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Course::deleteAll();
        Student::deleteAll();
    }

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

    function test_save()
    {
        //Arrange
        $name = 'Calculus';
        $course_number = 'MATH201';
        $test_Course = new Course($name, $course_number);

        //Act
        $test_Course->save();
        $result = Course::getAll();

        $this->assertEquals([$test_Course], $result);
    }

    function test_getAll()
    {
        //Arrange
        $name1 = 'Calculus';
        $course_number1 = 'MATH201';
        $test_Course1 = new Course($name1, $course_number1);
        $test_Course1->save();

        $name2 = 'Infinite Series';
        $course_number2 = 'MATH202';
        $test_Course2 = new Course($name2, $course_number2);
        $test_Course2->save();

        //Act
        $result = Course::getAll();

        $this->assertEquals([$test_Course1, $test_Course2], $result);
    }

    function test_deleteAll()
    {
        //Arrange
        $name1 = 'Calculus';
        $course_number1 = 'MATH201';
        $test_Course1 = new Course($name1, $course_number1);
        $test_Course1->save();

        $name2 = 'Infinite Series';
        $course_number2 = 'MATH202';
        $test_Course2 = new Course($name2, $course_number2);
        $test_Course2->save();

        //Act
        Course::deleteAll();
        $result = Course::getAll();

        $this->assertEquals([], $result);
    }

    function test_find()
    {
        //Arrange
        $name1 = 'Calculus';
        $course_number1 = 'MATH201';
        $test_Course1 = new Course($name1, $course_number1);
        $test_Course1->save();

        $name2 = 'Infinite Series';
        $course_number2 = 'MATH202';
        $test_Course2 = new Course($name2, $course_number2);
        $test_Course2->save();

        //Act
        $result = Course::find($test_Course1->getId());

        //Assert
        $this->assertEquals($test_Course1, $result);
    }

    function test_update()
    {
        $name1 = 'Calculus';
        $new_name = 'Infinite Series';
        $course_number1 = 'MATH201';
        $test_Course1 = new Course($name1, $course_number1);
        $test_Course1->save();

        //Act
        $test_Course1->update($new_name);
        $result = $test_Course1->getName();

        //Assert
        $this->assertEquals('Infinite Series', $result);
    }

    function test_delete()
    {
        //Arrange
        $name1 = 'Calculus';
        $course_number1 = 'MATH201';
        $test_Course1 = new Course($name1, $course_number1);
        $test_Course1->save();

        $name2 = 'Infinite Series';
        $course_number2 = 'MATH202';
        $test_Course2 = new Course($name2, $course_number2);
        $test_Course2->save();

        //Act
        $test_Course1->delete();
        $result = Course::getAll();

        //Assert
        $this->assertEquals([$test_Course2], $result);
    }

    function test_addStudent()
    {
        //Arrange
        $name = 'Calculus';
        $course_number = 'MATH201';
        $test_Course = new Course($name, $course_number);
        $test_Course->save();

        $name = 'John Doe';
        $enrollment_date = new DateTime('1970-01-01');
        $test_Student = new Student($name, $enrollment_date);
        $test_Student->save();

        //Act
        $test_Course->addStudent($test_Student);
        $result = $test_Course->getStudents();

        //Assert
        $this->assertEquals([$test_Student], $result);
    }

    function test_getStudents()
    {
        //Arrange
        $name = 'Calculus';
        $course_number = 'MATH201';
        $test_Course = new Course($name, $course_number);
        $test_Course->save();

        $name1 = 'John Doe';
        $enrollment_date1 = new DateTime('1970-01-01');
        $test_Student1 = new Student($name1, $enrollment_date1);
        $test_Student1->save();

        $name2 = 'Jane Doe';
        $enrollment_date2 = new DateTime('1970-01-01');
        $test_Student2 = new Student($name2, $enrollment_date2);
        $test_Student2->save();

        //Act
        $test_Course->addStudent($test_Student1);
        $test_Course->addStudent($test_Student2);
        $result = $test_Course->getStudents();

        //Assert
        $this->assertEquals([$test_Student1, $test_Student2], $result);
    }
}
?>

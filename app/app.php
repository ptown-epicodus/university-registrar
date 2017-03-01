<?php
date_default_timezone_set('America/Los_Angeles');
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../src/Course.php';
require_once __DIR__.'/../src/Student.php';

$app = new Silex\Application();

$server = 'mysql:host=localhost:8889;dbname=university_registrar';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

$app->get('/', function() use ($app) {
    return $app['twig']->render('index.html.twig');
});

$app->get('/students', function() use ($app) {
    $students = Student::getAll();
    return $app['twig']->render('students.html.twig', [
        'students' => $students
    ]);
});

$app->get('/students/{id}', function($id) use ($app) {
    $student = Student::find($id);
    $enrolled_courses = $student->getCourses();
    $unenrolled_courses = array_udiff(Course::getAll(), $enrolled_courses, function($a, $b) {
        return $a->getId() - $b->getId();
    });
    return $app['twig']->render('student.html.twig', [
        'student' => $student,
        'enrolled' => $enrolled_courses,
        'unenrolled' => $unenrolled_courses
    ]);
});

$app->post('/add_courses', function() use ($app) {
    $student = Student::find(intval($_POST['student_id']));
    $course = Course::find(intval($_POST['course_id']));
    $student->addCourse($course);
    return $app->redirect("/students/{$_POST['student_id']}");
});

$app->get('/courses', function() use ($app) {
    $courses = Course::getAll();
    return $app['twig']->render('courses.html.twig', [
        'courses' => $courses
    ]);
});


return $app;
?>

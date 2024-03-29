<?php

// Enable Error Reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require autoload.php
require_once ('vendor/autoload.php');

// Create instance of Base class
$f3 = Base::instance();

// Define BASE Route
$f3->route('GET /', function() {
   $view = new Template();
   echo $view->render('app/views/home.html');
});

// Define AllCourses route
$f3->route('GET /courses', function($f3)
{
    $courses = GraphITController::getAllCourses("localhost:8080/courses/read/all");
    $f3->set('courses', $courses);
    $view = new Template();
    echo $view->render('app/views/courses.html');
});

// Define addCourse Route
$f3->route('POST /dev-testing/add', function($f3) {

});
// Define dev-testing route
$f3->route('POST /submit', function($f3) {

    $raw = $_POST["title"];
    $f3->set('title', $raw);
    GraphITController::addCourse('localhost:8080/courses/create/', $raw);

    $view = new Template();
    echo $view->render('app/views/dev-testing/form-submitted.html');
});

// Define Dev Control Panel route
$f3->route('GET /dev', function($f3) {

    $view = new Template();
    echo $view->render('app/views/dev-testing/dev.html');
});

// Define Submit Preferences route
$f3->route('GET /preferences', function() {
    $view = new Template();
    echo $view->render('app/views/preferences.html');
});

// Define Student Route
$f3->route('GET /student', function() {
    $view = new Template();
    echo $view->render('app/views/student.html');
});

// Define Advisor Route
$f3->route('GET /advisor', function() {
    $view = new Template();
    echo $view->render('app/views/advisor.html');
});

// Define Schedule Route
$f3->route('POST /schedule', function($f3, $numCourses) {
    try {

        $numCoursesRaw = $_POST['numCourses'];

        $numCourses = intval($numCoursesRaw);

        //check if summer button is pushed
        /*
        if(isset($_POST['summerQuarterCheck'])){
            $attendingSummer = true;
        } else {
            $attendingSummer = false;
        }
        */
        $attendingSummer = $_POST['summerQuarterCheck'] ?? "off";

        $schedule = GraphITController::getSchedule('localhost:8080/schedule/create/'.$numCourses);

        // Check if $schedule is an array
        if (!is_array($schedule)) {
            throw new \Exception('Invalid schedule format. Expected JSON-encoded string.');
        }

        // Before setting the schedule variable
        error_log('Schedule Data: ' . print_r($schedule, true));

        $f3->set('schedule', $schedule);

        // After setting the schedule variable
        error_log('Schedule Variable Set');

        $view = new Template();
        echo $view->render('app/views/schedule.html');
    } catch (\Exception $e) {
        // Handle the exception (log, display an error page, etc.)
        // For now, just echoing the error message
        echo 'Error: ' . $e->getMessage();
    }
});




// Run Fat Free Framework
$f3->run();
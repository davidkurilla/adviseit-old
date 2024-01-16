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
$f3->route('GET /courses/all', function($f3)
{
    $courses = GraphITController::getAllCourses("localhost:8080/courses/read/all");
    $f3->set('courses', $courses);
    $view = new Template();
    echo $view->render('app/views/courses.html');
});

// Define addCourse Route
$f3->route('POST /dev-testing/add', function($f3) {

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

// Run Fat Free Framework
$f3->run();
<?php

// Enable Error Reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require autoload.php
require_once ('vendor/autoload.php');

// Create instance of Base class
$f3 = Base::instance();

// FUNCTION: getSortedClasses
function getSortedClasses(): string
{
    $url= 'localhost:8080/courses/sorted';

    //  Initiate curl
    $ch = curl_init();
    // Will return the response, if false it print the response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Set the url
    curl_setopt($ch, CURLOPT_URL,$url);
    // Execute
    $result = curl_exec($ch);
    // Closing
    curl_close($ch);

    // Will dump a beauty json :3
    // var_dump(json_decode($result, true));

    return $result;

}

// FUNCTION: addClass
function addClass(string $class): void
{

    $url= 'localhost:8080/courses/add/' . $class;

    //  Initiate curl
    $ch = curl_init();
    // Will return the response, if false it print the response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Set the url
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "title=".$class);

    // Execute
    $result = curl_exec($ch);
    // Closing
    curl_close($ch);

}

$f3->route('GET /', function() {
   $view = new Template();
   echo $view->render('app/views/home.html');
});

// Define AllCourses route
$f3->route('GET /courses', function($f3)
{
    $raw = getSortedClasses();
    $decoded = json_decode($raw, true);
    //$data = print_r($decoded, true);
    $f3->set('courses', $decoded);
    $view = new Template();
    echo $view->render('app/views/courses.html');
});

// Define dev-testing route
$f3->route('POST /dev-testing/add', function($f3) {

    $raw = $_POST["title"];
    $f3->set('title', $raw);
    addClass($raw);

    $view = new Template();
    echo $view->render('app/views/dev-testing/form-submitted.html');
});

// Define dev-testing route
$f3->route('POST /dev-testing/update', function($f3) {

    $raw = $_POST["title"];
    $f3->set('title', $raw);
    updateClass($raw);

    $view = new Template();
    echo $view->render('app/views/dev-testing/form-submitted.html');
});

// Define dev-testing route
$f3->route('POST /dev-testing/delete', function($f3) {

    $raw = $_POST["title"];
    $f3->set('title', $raw);
    deleteClass($raw);

    $view = new Template();
    echo $view->render('app/views/dev-testing/form-submitted.html');
});

// Define dev route
$f3->route('GET /dev', function($f3) {

    $view = new Template();
    echo $view->render('app/views/dev-testing/dev.html');
});

// Define preferences route
$f3->route('GET /preferences', function() {
    $view = new Template();
    echo $view->render('app/views/preferences.html');
});

// Define add route
$f3->route('GET /add', function() {
    $view = new Template();
    echo $view->render('app/views/add.html');
});

// Define add route
$f3->route('GET /student', function() {
    $view = new Template();
    echo $view->render('app/views/student.html');
});

// Define add route
$f3->route('GET /advisor', function() {
    $view = new Template();
    echo $view->render('app/views/advisor.html');
});

// Run Fat Free Framework
$f3->run();
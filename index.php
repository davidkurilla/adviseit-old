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


// Run Fat Free Framework
$f3->run();
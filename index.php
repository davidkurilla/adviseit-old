<?php

// Enable Error Reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require autoload.php
require_once ('vendor/autoload.php');

// Create instance of Base class
$f3 = Base::instance();

// Define default route
$f3->route('GET /', function()
{
    $view = new Template();
    echo $view->render('app/views/home.html');
});

// Run Fat Free Framework
$f3->run();
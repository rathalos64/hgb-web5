<?php

// TODO: header to views/error/500.php
// Or by calling View

// TODO: pass exception / error information

set_error_handler(
    function ($errno, $errstr, $errfile = null, $errline = null, $errcontext = [])
    {
        chdir("/var/www/html");
        ShoppingList\View::view("error.500", [
            "message" => "[$errno] $errstr in $errfile on line $errline",
        ]);
        // header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error", true, 500);
        // $dateTime = new DateTime();
        // file_put_contents(__DIR__ . "/logs/error.log", "[{$dateTime->format("c")}] [$errno] $errstr in $errfile on line $errline\n", FILE_APPEND | LOCK_EX);
    }
);

// TODO: should get specific exception with status code
// which should redirect to the proper error page
set_exception_handler(
    function ($exception)
    {
        // echo $exception->getMessage();
        chdir("/var/www/html");
        ShoppingList\View::view("error.500", [
            "message" => $exception->getMessage(),
        ]);
        //header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error", true, 500);
        //$dateTime = new DateTime();
        //echo $_SERVER["SERVER_PROTOCOL"];
        //file_put_contents(__DIR__ . "/logs/error.log", "[{$dateTime->format("c")}] " . $exception->getMessage() . "\n", FILE_APPEND | LOCK_EX);
    }
);
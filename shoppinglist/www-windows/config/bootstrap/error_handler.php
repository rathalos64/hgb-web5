<?php

set_error_handler(
    function ($errno, $errstr, $errfile = null, $errline = null, $errcontext = [])
    {
        chdir("C:/xampp/htdocs");
        App\View::view("error.error", [
            "message" => "[$errno] $errstr in $errfile on line $errline",
        ]);
    }
);

set_exception_handler(
    function ($exception)
    {
        chdir("C:/xampp/htdocs");
        App\View::view("error.error", [
            "message" => $exception->getMessage(),
        ]);
    }
);
<?php

App\Route::get("/", "IndexController@welcome");

// auth routes
App\Route::post("/auth/register", "AuthController@register");
App\Route::post("/auth/login", "AuthController@login");
App\Route::post("/auth/logout", "AuthController@logout");

// route with middleware
$auth_middleware = "App\AuthenticationManager::check";

App\Route::get("/home/dashboard", "HomeController@dashboard", $auth_middleware);
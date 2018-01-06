<?php

// -- index --
App\Route::get("/", "IndexController@welcome");

// -- login --
App\Route::post("/auth/register", "AuthController@register");
App\Route::post("/auth/login", "AuthController@login");
App\Route::post("/auth/logout", "AuthController@logout");

// -- auth middleware --
$auth_middleware = "App\AuthenticationManager::check";

App\Route::get("/home/dashboard", "HomeController@dashboard", $auth_middleware);
App\Route::get("/home/audit", "HomeController@audit", $auth_middleware);

// -- list --
App\Route::get("/home/list", "ListController@get", $auth_middleware);

App\Route::get("/home/list/add", "ListController@getAdd", $auth_middleware);
App\Route::post("/home/list/add", "ListController@postAdd", $auth_middleware);
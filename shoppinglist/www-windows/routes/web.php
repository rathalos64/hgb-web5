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

App\Route::get("/home/list/edit", "ListController@edit", $auth_middleware);
App\Route::post("/home/list/edit", "ListController@postEdit", $auth_middleware);

App\Route::get("/home/list/add", "ListController@getAdd", $auth_middleware);
App\Route::post("/home/list/add", "ListController@postAdd", $auth_middleware);

App\Route::get("/home/list/delete", "ListController@delete", $auth_middleware);

// -- article --
App\Route::get("/home/article/add", "ArticleController@getAdd", $auth_middleware);
App\Route::post("/home/article/add", "ArticleController@postAdd", $auth_middleware);

App\Route::get("/home/article/delete", "ArticleController@delete", $auth_middleware);
App\Route::get("/home/article/finish", "ArticleController@finish", $auth_middleware);
App\Route::get("/home/article/unfinish", "ArticleController@unfinish", $auth_middleware);

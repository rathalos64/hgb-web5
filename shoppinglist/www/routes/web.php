<?php

\ShoppingList\Route::get("/", "HomeController@welcome");

// auth routes
\ShoppingList\Route::post("/auth/register", "AuthController@register");
\ShoppingList\Route::post("/auth/login", "AuthController@login");
\ShoppingList\Route::post("/auth/logout", "AuthController@logout");
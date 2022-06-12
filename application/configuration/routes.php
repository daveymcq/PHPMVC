<?php

class Routes extends Router
{
    public static function root()
    {
        return Router::Get("/", "/users");
    }

    public static function allUsers()
    {
        return Router::Get("/account/list", "/users/index");
    }

    public static function showUser()
    {
        return Router::Get("/account/show/:id", "/users/:id/show");
    }

    public static function signUp()
    {
        return Router::Get("/account/signup", "/users/newUser");
    }

    public static function createUser()
    {
        return Router::Post("/account/create", "/users/create");
    }

    public static function editUser()
    {
        return Router::Get("/account/edit/:id", "/users/:id/edit");
    }

    public static function updateUser()
    {
        return Router::Post("/account/update/:id", "/users/:id/update");
    }

    public static function deleteUser()
    {
        return Router::Post("/account/delete/:id", "/users/:id/delete");
    }
}

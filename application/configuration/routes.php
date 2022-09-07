<?php

class Routes extends Router
{
    public static function root()
    {
        return Routes::Get("/", "/homes/index");
    }

    public static function allUsers()
    {
        return Routes::Get("/account/list", "/users/index");
    }

    public static function showUser()
    {
        return Routes::Get("/account/show/:id", "/users/:id/show");
    }

    public static function signUp()
    {
        return Routes::Get("/account/signup", "/users/newUser");
    }

    public static function createUser()
    {
        return Routes::Post("/account/create", "/users/create");
    }

    public static function editUser()
    {
        return Routes::Get("/account/edit/:id", "/users/:id/edit");
    }

    public static function updateUser()
    {
        return Routes::Post("/account/update/:id", "/users/:id/update");
    }

    public static function deleteUser()
    {
        return Routes::Get("/account/delete/:id", "/users/:id/delete");
    }

    public static function allPosts()
    {
        return Routes::Get("/posts/list", "/posts/index");
    }

    public static function showPost()
    {
        return Routes::Get("/posts/show/:id", "/posts/:id/show");
    }

    public static function newPost()
    {
        return Routes::Get("/posts", "/posts/newPost");
    }

    public static function createPost()
    {
        return Routes::Post("/posts/create", "/posts/create");
    }

    public static function editPost()
    {
        return Routes::Get("/posts/edit/:id", "/posts/:id/edit");
    }

    public static function updatePost()
    {
        return Routes::Post("/posts/update/:id", "/posts/:id/update");
    }

    public static function deletePost()
    {
        return Routes::Get("/posts/delete/:id", "/posts/:id/delete");
    }
}

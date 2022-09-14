<?php

class Routes extends Router
{
    public static function Rootlink_to()
    {
        return Routes::root("/homes/index");
    }

    public static function allUsers()
    {
        return Routes::match("/accounts/all", "/users/index");
    }

    public static function showUser()
    {
        return Routes::match("/account/show/:id", "/users/:id/show");
    }

    public static function signUp()
    {
        return Routes::match("/account/new", "/users/newUser");
    }

    public static function createUser()
    {
        return Routes::match("/account/create", "/users/create", 'POST');
    }

    public static function editUser()
    {
        return Routes::match("/account/edit/:id", "/users/:id/edit");
    }

    public static function updateUser()
    {
        return Routes::match("/account/update/:id", "/users/:id/update", 'POST');
    }

    public static function deleteUser()
    {
        return Routes::match("/account/delete/:id", "/users/:id/delete");
    }

    public static function allPosts()
    {
        return Routes::match("/account/posts/all", "/posts/index");
    }

    public static function showPost()
    {
        return Routes::match("/account/posts/show/:id", "/posts/:id/show");
    }

    public static function newPost()
    {
        return Routes::match("/account/posts/new", "/posts/newPost");
    }

    public static function createPost()
    {
        return Routes::match("/account/posts/create", "/posts/create", 'POST');
    }

    public static function editPost()
    {
        return Routes::match("/account/posts/edit/:id", "/posts/:id/edit");
    }

    public static function updatePost()
    {
        return Routes::match("/account/posts/update/:id", "/posts/:id/update", 'POST');
    }

    public static function deletePost()
    {
        return Routes::match("/account/posts/delete/:id", "/posts/:id/delete");
    }
}

?>

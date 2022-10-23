<?php

class Routes extends Router
{
    public static function home()
    {
        return Routes::root("/homes/index");
    }

    public static function allUsers()
    {
        return Routes::match("/accounts", "/users/index");
    }

    public static function showUser()
    {
        return Routes::match("/account/:id", "/users/:id/show");
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
        return Routes::match("/account/:id/edit", "/users/:id/edit");
    }

    public static function updateUser()
    {
        return Routes::match("/account/:id/update", "/users/:id/update", 'POST');
    }

    public static function deleteUser()
    {
        return Routes::match("/account/:id/delete", "/users/:id/delete");
    }

    public static function allPosts()
    {
        return Routes::match("/account/:id/posts", "/posts/:id/index");
    }

    public static function showPost()
    {
        return Routes::match("/account/:id/post/:post_id", "/posts/:post_id/show/:id");
    }

    public static function newPost()
    {
        return Routes::match("/account/:id/posts/new", "/posts/:id/newPost");
    }

    public static function createPost()
    {
        return Routes::match("/account/:id/post/create", "/posts/:id/create", 'POST');
    }

    public static function editPost()
    {
        return Routes::match("/account/:id/post/:post_id/edit", "/posts/:post_id/edit/:id");
    }

    public static function updatePost()
    {
        return Routes::match("/account/post/:id/update", "/posts/:id/update", 'POST');
    }

    public static function deletePost()
    {
        return Routes::match("/account/:id/post/:post_id/delete", "/posts/:post_id/delete/:id");
    }
}

?>

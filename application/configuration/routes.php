<?php

class Routes extends Router
{
    public function root()
    {
        return Router::Get("/accounts", "/users");
    }

    public function showUser()
    {
        return Router::Get("/account/show/:id", "/users/:id");
    }

    public function signup()
    {
        return Router::Get("/account/signup", "/users/newUser");
    }

    public function createUser()
    {
        return Router::Post("/account/create", "/users/create");
    }

    public function editUser()
    {
        return Router::Get("/account/edit/:id", "/users/:id/edit");
    }

    public function updateUser()
    {
        return Router::Post("/account/update/:id", "/users/:id/update");
    }

    public function deleteUser()
    {
        return Router::Post("/account/delete/:id", "/users/:id/delete");
    }
}

<?php

class Users extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function new()
    {
        return new User;
    }

    public function show($id)
    {
        return User::find($id);
    }

    public function create()
    {
        $user = new User($_POST['user']);

        if($user->save())
        {
            redirect_to("user/{$user->id}");
        }

        else
        {
            redirect_to("user/new");
        }
    }

    public function edit($id)
    {
        return User::find($id);
    }

    public function update($id)
    {
        $user = User::find($id);

        if($user && $user->update($_POST['user']))
        {
            redirect_to("user/{$user->id}");
        }

        else
        {
            redirect_to("user/edit/{$user->id}");
        }
    }

    public function delete($id)
    {
        if((User::find($id))->delete())
        {
            redirect_to("user");
        }
    }
}

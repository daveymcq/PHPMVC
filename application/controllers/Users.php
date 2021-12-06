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

        if($user)
        {
            $user->first_name = $_POST['user']['first_name'];
            $user->last_name = $_POST['user']['last_name'];
            $user->email = $_POST['user']['email'];

            if($user->save())
            {
                redirect_to("user/{$user->id}");
            }
        }

        redirect_to("user/edit/{$user->id}");
    }

    public function delete($id)
    {
        if((User::find($id))->delete())
        {
            redirect_to("user");
        }
    }
}

<?php

class Users extends Controller
{
    public function index()
    {
      return User::all();
    }

    public function show($id)
    {
      return User::find($id);
    }

    public function newUser()
    {
      return new User();
    }

    public function create()
    {
      if($_SERVER['REQUEST_METHOD'] == 'POST') 
      {
        $user = new User($_POST['user']);

        if($user->save())
        {
          redirect_to("users");
        }
      }

      redirect_to("users/newUser");
    }

    public function edit($id)
    {
      return User::find($id);
    }

    public function update($id)
    {
      if($_SERVER['REQUEST_METHOD'] == 'POST') 
      {
        $user = User::find($id);

        if($user && $user->update($_POST['user']))
        {
          redirect_to("users/{$user->id}");
        }
      }

      redirect_to("users/{$user->id}/edit");
    }

    public function delete($id)
    {
      User::find($id)->delete();
      redirect_to("users");
    }
}
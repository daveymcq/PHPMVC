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

    public function edit($id)
    {
        return User::find($id);
    }

    public function delete($id)
    {
        $user = User::find($id);

        if($user)
        {
            if(isset($user->post))
            {
                $user->post->delete();
            }

            if(isset($user->posts))
            {
                for($i = 0; $i < count($user->posts); $i++)
                {
                    $user->posts[$i]->delete();
                } 
            }

            $user->delete();
            redirect_to("accounts");
        }
    }

    public function create()
    {
        $user = new User($_POST['user']);

        if($user->save())
        {
            redirect_to("accounts");
        }
        
        redirect_to("account/new");
    }

    public function update($id)
    {
        $user = User::find($id);

        if($user && $user->update($_POST['user']))
        {
            if(isset($user->post))
            {
                $user->post->body = 'testing from Users controller';
                $user->title = 'testing...';

                if($user->post->save())
                {
                    redirect_to("account/{$user->id}");
                }
            }

            if(isset($user->posts))
            {
                for($i = 0; $i < count($user->posts); $i++)
                {
                    $counter = $i + 1;
                    $user->posts[$i]->body = "testing from Users controller # {$counter}";
                    $user->posts[$i]->title = "testing... # {$counter}";

                    if(!($user->posts[$i])->save())
                    {
                        redirect_to("account/{$user->id}/edit");
                    }
                } 
            }
            
            redirect_to("account/{$user->id}");
        }
        
        redirect_to("account/{$user->id}/edit");
    }
}

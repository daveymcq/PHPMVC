<?php

class Posts extends Controller
{
    public function index($id)
    {
        return User::find($id);
    }

    public function show($id, $request)
    {
       $user = User::find($request[3]);
       return $user;
    }

    public function newPost($id, $request)
    {
       $user = User::find($request[3] ?? $request[1]);
       return $user;  
    }

    public function edit($id)
    {
        return Post::find($id);
    }

    public function delete($id, $request)
    {
        Post::find($id)->delete();
        redirect_to("account/{$request[3]}/posts");
    }

    public function create($id)
    {
        $user = User::find($id);

        if($user)
        {
            $user->post = new Post($_POST['post']);
            $user->post->user_id = $user->id; 

            if($user->post->save())
            {
                $user->post_id = $user->post->id;

                if($user->save())
                {
                    redirect_to("account/{$user->id}/post/{$user->post->id}");
                }
            }
            
            redirect_to("account/{$user->id}/posts/new");
        }

        redirect_to("accounts");
    }

    public function update($id)
    {
        $post = Post::find($id);

        if($post && $post->update($_POST['post']))
        {
            redirect_to("account/{$post->user->id}/post/{$post->id}");
        }
        
        redirect_to("account/{$post->user->id}/post/{$post->id}");
    }
}

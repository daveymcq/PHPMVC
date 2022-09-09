<?php

class Posts extends Controller
{
    public function index()
    {
        return Post::all();
    }

    public function show($id)
    {
        return Post::find($id);
    }

    public function newUser()
    {
        return new Post();
    }

    public function edit($id)
    {
        return Post::find($id);
    }

    public function delete($id)
    {
        Post::find($id)->delete();
        redirect_to("account/posts");
    }

    public function create()
    {
        $post = new Post($_POST['post']);

        if($post->save())
        {
            redirect_to("account/posts/list");
        }
        
        redirect_to("account/posts/new");
    }

    public function update($id)
    {
        $post = Post::find($id);

        if($post && $post->update($_POST['post']))
        {
            redirect_to("account/posts/show/{$post->id}");
        }
        
        redirect_to("account/posts/edit/{$post->id}");
    }
}

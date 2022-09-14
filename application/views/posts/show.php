<h2>Show Post</h2>
<ul>
<?php

  $post = (new Request('posts'))->requestObject;

  if($post)
  {
    echo "<strong>Phone:&nbsp;</strong>{$post->title}<br>";
    echo "<strong>Email:&nbsp;</strong>{$post->body}<br>";

    echo "<br><a href='" . route("account/posts/edit/{$post->id}") . "'>Edit</a>";
    echo "<a href='" . route("account/posts/delete/{$post->id}") . "'>Delete</a><br><br>";
    echo "<pre>";
    print_r($post);
    echo "</pre>";
  }

  else
  {
      echo '<p>No Posts</p>';
  }
  
?>
</ul>
<br><a href="javascript:history.back();"> >> Back >> </a>

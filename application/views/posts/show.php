<h2>Show Post</h2>
<ul>
<?php

  $user = new HttpRequestObject();
  
  if($user->valid())
  {
    if(isset($user->post))
    {
      $post = $user->post;
      echo "<strong>Phone:&nbsp;</strong>{$post->title}<br>";
      echo "<strong>Email:&nbsp;</strong>{$post->body}<br>";
      echo "<br><a href='" . link_to("account/{$user->id}/post/{$post->id}/edit") . "'>Edit</a>";
      echo "<a href='" . link_to("account/{$user->id}/post/{$post->id}/delete") . "'>Delete</a><br><br>";
      echo "<pre>";
      echo "</pre>";
    }
  }

  if(isset($user->posts))
  {
    foreach($user->posts as $post)
    {
      echo "<strong>Phone:&nbsp;</strong>{$post->title}<br>";
      echo "<strong>Email:&nbsp;</strong>{$post->body}<br>";
      echo "<br><a href='" . link_to("account/{$user->id}/post/{$post->id}/edit") . "'>Edit</a>";
      echo "<a href='" . link_to("account/{$user->id}/post/{$post->id}/delete") . "'>Delete</a><br><br>";
      echo "<pre>";
      echo "</pre>";
    }
  }

  else
  {
      echo '<p>No Posts</p>';
  }
  
?>
</ul>
<br><a href="javascript:history.back();"> >> Back >> </a>

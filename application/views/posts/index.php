<h2>Post List</h2>
<?php
  $object = new HttpRequestObject();

  if($object->valid())
  {
    $user = $object;

    if(isset($user->post))
    {
      $post = $user->post;
      echo "<strong><a href='" . link_to("account/{$user->id}/post/{$post->id}") . "'>{$post->title}</a></strong><br>";
    }

    if(isset($user->posts))
    {
      $posts = $user->posts;

      foreach($posts as $post)
      {
         echo "<strong><a href='" . link_to("account/{$user->id}/post/{$post->id}") . "'>{$post->title}</a></strong><br>";
      }
    }
  }

  else
  {
    echo '<p>No posts</p>';
  }

?>

<br><a href='<?php echo link_to("account/{$object->id}/posts/new"); ?>'>New Post</a>



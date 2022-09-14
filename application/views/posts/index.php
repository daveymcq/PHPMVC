<h2>Post List</h2>
<?php
  $posts = (new Request('posts'))->requestObject;

  if(!empty($posts))
  {
    foreach($posts as $post)
    {
        echo "<strong><a href='" . link_to("account/posts/show/{$post->id}") . "'>{$post->title}</a></strong><br>";
    }
  }

  else
  {
    echo '<p>No posts</p>';
  }

?>

<br><a href="<?php echo link_to('account/posts/new'); ?>">New Post</a>



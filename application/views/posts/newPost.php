<?php 

  $post = (new Request('posts'))->requestObject;

  if($post)
  {
      error_messages_for($post);
  }
  
?>

<h2>Create New Post</h2>
<form action="<?php echo route('account/posts/create'); ?>" method="post">
  <label for="title">Post Body</label>
  <p><input type="text" id="title" style="width:30%;" name="post[title]" placeholder="Message" maxlength="30"></p>
  <label for="body">Post Body</label>
  <p><input type="text" id="body" style="width:30%;" name="post[body]" placeholder="Message" maxlength="30"></p>    
  <p><input type="submit" name="update" value="Create Post"></p>
</form>

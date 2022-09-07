<h2>Edit Post</h2>

<?php 

  $post = (new Request('posts'))->requestObject;

  if($post):
    error_messages_for($post);
?>

<form action="<?php echo route("/posts/update/{$post->id}"); ?>" method="post">
  <label for="title">Post Body</label>
  <p><input type="text" id="title" style="width:30%;" name="post[title]" placeholder="Message" maxlength="30" value="<?php echo $post->title; ?>"></p>
  <label for="body">Post Body</label>
  <p><input type="text" id="body" style="width:30%;" name="post[body]" placeholder="Message" maxlength="30" value="<?php echo $post->body; ?>"></p>    
  <p><input type="submit" name="update" value="Update Post"></p>
</form>

<?php else: ?>
    <p>Invalid User</p>
<?php endif; ?>

<a href="javascript:history.back();"> >> Back >> </a>

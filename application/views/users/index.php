<h2>Account List</h2>
<?php

  $object = new HttpRequestObject();

  if($object->valid())
  {
    foreach($object->users as $user)
    {
        echo "<strong><a href=\"" . link_to("account/{$user->id}") .  "\">{$user->first_name} {$user->last_name}</a></strong><br>";
    }
  }

  else
  {
    echo '<p>No Users</p>';
  }
?>

<br><a href="<?php echo link_to("account/new") ?>">New User</a>



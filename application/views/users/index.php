<?php

if(!empty($PARAMS['users']))
{
  foreach($PARAMS['users'] as $user)
  {
      echo "<p><a href='/" . APPLICATION_ROOT . "/account/show/{$user->id}'>{$user->first_name} {$user->last_name}</a></p>";
  }
}

else
{
  echo '<p>No Users</p>';
}

?>

<br><a href="/<?php echo APPLICATION_ROOT; ?>/account/signup">New User</a>



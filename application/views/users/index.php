<?php

if(!empty($PARAMS['users']))
{
  foreach($PARAMS['users'] as $user)
  {
      echo "<p><a href='../account/show/{$user->id}'>{$user->first_name} {$user->last_name}</a></p>";
  }
}

else
{
  echo '<p>No Users</p>';
}

?>

<br><a href="account/signup">New User</a>



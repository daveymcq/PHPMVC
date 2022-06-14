<ul>
<?php

if($PARAMS['users'])
{
  $user = $PARAMS['users'];

  echo "<li><strong>Phone:&nbsp;</strong>{$user->phone_number}</li>";
  echo "<li><strong>Email:&nbsp;</strong>{$user->email}</li>";
  echo "<li><strong>First Name:&nbsp;</strong>{$user->first_name}</li>";
  echo "<li><strong>Last Name:&nbsp;</strong>{$user->last_name}</li>";

  echo "<br><a href='/" . APPLICATION_ROOT . "/account/edit/{$user->id}'>Edit</a>";
  echo "<a href='/" . APPLICATION_ROOT . "/account/delete/{$user->id}'>Delete</a>";
}

else
{
    echo '<li>No User</li>';
}

?>
</ul>
<br><a href="javascript:history.back();"> >> Back >> </a>
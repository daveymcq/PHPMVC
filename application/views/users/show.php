<ul>
<?php

if($PARAMS['users'])
{
  $user = $PARAMS['users'];

  echo "<li><strong>Phone:</strong> {$user->phone_number}</li>";
  echo "<li><strong>Email:</strong> {$user->email}</li>";
  echo "<li><strong>First Name:</strong> {$user->first_name}</li>";
  echo "<li><strong>Last Name:</strong> {$user->last_name}</li>";

  echo "<br><a href='../edit/{$user->id}'>Edit</a>";
  echo "<a href='../../account/delete/{$user->id}'>Delete</a>";
}

else
{
    echo '<li>No User</li>';
}

?>
</ul>
<br><a href="javascript:history.back();"> >> Back >> </a>
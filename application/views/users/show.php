<h2>Show Account</h2>
<ul>
<?php

  if($PARAMS['users'])
  {
    $user = $PARAMS['users'];

    echo "<strong>Phone:&nbsp;</strong>{$user->phone_number}<br>";
    echo "<strong>Email:&nbsp;</strong>{$user->email}<br>";
    echo "<strong>First Name:&nbsp;</strong>{$user->first_name}<br>";
    echo "<strong>Last Name:&nbsp;</strong>{$user->last_name}<br>";

    echo "<br><a href='/" . APPLICATION_ROOT . "/account/edit/{$user->id}'>Edit</a>";
    echo "<a href='/" . APPLICATION_ROOT . "/account/delete/{$user->id}'>Delete</a>";
  }

  else
  {
      echo '<p>No User</p>';
  }
  
?>
</ul>
<br><a href="javascript:history.back();"> >> Back >> </a>
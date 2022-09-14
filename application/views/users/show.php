<h2>Show Account</h2>
<ul>
<?php

  $user = (new Request('users'))->requestObject;

  if($user)
  {
    echo "<strong>Phone:&nbsp;</strong>{$user->phone_number}<br>";
    echo "<strong>Email:&nbsp;</strong>{$user->email}<br>";
    echo "<strong>First Name:&nbsp;</strong>{$user->first_name}<br>";
    echo "<strong>Last Name:&nbsp;</strong>{$user->last_name}<br>";

    echo "<br><a href='" . route("account/edit/{$user->id}") . "'>Edit</a>";
    echo "<a href='" . route("account/delete/{$user->id}") . "'>Delete</a><br><br>";
    echo "<pre>";
    print_r($user);
    echo "</pre>";
  }

  else
  {
      echo '<p>No User</p>';
  }
  
?>
</ul>
<br><a href="javascript:history.back();"> >> Back >> </a>

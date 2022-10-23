<h2>Show Account</h2>
<ul>
<?php

  $user = new HttpRequestObject();

  if($user->valid())
  {
    echo "<strong>Phone:&nbsp;</strong>{$user->phone_number}<br>";
    echo "<strong>Email:&nbsp;</strong>{$user->email}<br>";
    echo "<strong>First Name:&nbsp;</strong>{$user->first_name}<br>";
    echo "<strong>Last Name:&nbsp;</strong>{$user->last_name}<br>";

    echo "<br><a href='" . link_to("account/{$user->id}/edit") . "'>Edit</a>";
    echo "<a href='" . link_to("account/{$user->id}/delete") . "'>Delete</a><br><br>";
    echo "<pre>";
    echo "</pre>";
  }

  else
  {
      echo '<p>No User</p>';
  }
  
?>
</ul>
<br><a href="javascript:history.back();"> >> Back >> </a>

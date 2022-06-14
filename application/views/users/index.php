<h2>Account List</h2>
<?php

  if(!empty($PARAMS['users']))
  {
    foreach($PARAMS['users'] as $user)
    {
        echo "<strong><a href='/" . APPLICATION_ROOT . "/account/show/{$user->id}'>{$user->first_name} {$user->last_name}</a></strong><br>";
    }
  }

  else
  {
    echo '<p>No Users</p>';
  }

?>

<br><a href="/<?php echo APPLICATION_ROOT; ?>/account/signup">New User</a>



<h2>Account List</h2>
<?php

  $users = (new Request('users'))->requestObject;

  if(!empty($users))
  {
    foreach($users as $user)
    {
        echo "<strong><a href='" . route("/account/show/{$user->id}") . "'>{$user->first_name} {$user->last_name}</a></strong><br>";
    }
  }

  else
  {
    echo '<p>No Users</p>';
  }

?>

<br><a href="<?php echo route('/account/new'); ?>">New User</a>



<?php 

  $user = (new Request('users'))->requestObject;

  if($user)
  {
      error_messages_for($user);
  }
  
?>

<h2>Create New Account</h2>
<form action="<?php echo route('account/create'); ?>" method="post">
  <label for="phone">Phone</label>
  <p><input type="phone" id="phone" style="width:30%;" name="user[phone_number]" placeholder="Phone Number" maxlength="12"></p>
  <label for="email">Email</label>
  <p><input type="email" id="email" style="width:30%;" name="user[email]" placeholder="Email Address" maxlength="60"></p>
  <label for="first-name">First Name</label>
  <p><input type="text" id="first-name" style="width:30%;" name="user[first_name]" placeholder="First Name" maxlength="30"></p>
  <label for="last-name">Last Name</label>
  <p><input type="text" id="last-name" style="width:30%;" name="user[last_name]" placeholder="Last Name" maxlength="30"></p>
  <p><input type="submit" name="create" value="Create User"></p>
</form>

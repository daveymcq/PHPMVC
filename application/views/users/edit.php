<?php if($PARAMS['users']): ?>
<?php $user = $PARAMS['users']; ?>

<form action="update" method="post">
  <label for="phone">Phone</label>
  <p><input type="phone" id="phone" name="user[phone_number]" placeholder="Phone Number" maxlength="12" value="<?php echo $user->phone_number; ?>"></p>
  <label for="email">Email</label>
  <p><input type="email" id="email" name="user[email]" placeholder="Email Address" maxlength="60" value="<?php echo $user->email; ?>"></p>
  <label for="first-name">First Name</label>
  <p><input type="text" id="first-name" name="user[first_name]" placeholder="First Name" maxlength="30" value="<?php echo $user->first_name; ?>"></p>
  <label for="last-name">Last Name</label>
  <p><input type="text" id="last-name" name="user[last_name]" placeholder="Last Name" maxlength="30" value="<?php echo $user->last_name; ?>"></p>    
  <p><input type="hidden" name="user[id]" value="<?php echo $user->id; ?>"></p>
  <p><input type="submit" name="update" value="Update User"></p>
</form>

<?php else: ?>
    <p>Invalid User</p>
<?php endif; ?>

<a href="javascript:history.back();"> >> Back >> </a>
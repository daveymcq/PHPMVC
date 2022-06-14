<form action="/PHPMVC/account/create" method="post">
  <label for="phone">Phone</label>
  <p><input type="phone" id="phone" name="user[phone_number]" placeholder="Phone Number" maxlength="12"></p>
  <label for="email">Email</label>
  <p><input type="email" id="email" name="user[email]" placeholder="Email Address" maxlength="60"></p>
  <label for="first-name">First Name</label>
  <p><input type="text" id="first-name" name="user[first_name]" placeholder="First Name" maxlength="30"></p>
  <label for="last-name">Last Name</label>
  <p><input type="text" id="last-name" name="user[last_name]" placeholder="Last Name" maxlength="30"></p>
  <p><input type="submit" name="create" value="Create User"></p>
</form>
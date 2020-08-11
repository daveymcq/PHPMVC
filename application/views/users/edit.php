<?php require_once('application/views/layout/header.php'); ?>

<p>Users#Edit</p>

<form action="/user/<?php echo $_PARAMS['url']['id'] ?>/update" method="post">
    <input type="email" name="user[email]"></p>
    <input type="text" name="user[first_name]"></p>
    <input type="text" name="user[last_name]"></p>
    <input type="text" name="user[active]"></p>
    <input type="submit" name="submit" value="Submit">
</form>

<?php require_once('application/views/layout/footer.php'); ?>

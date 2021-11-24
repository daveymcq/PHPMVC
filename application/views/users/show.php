<?php require_once('application/views/layout/header.php'); ?>

<p>Users#Show</p>

<?php
    print_r(new User);
    $user = $_PARAMS['users'];

    if($user)
    {
        echo '<p>' . $user->id . '</p>';
        echo '<p>' . $user->email . '</p>';
        echo '<p>' . $user->first_name . '</p>';
        echo '<p>' . $user->last_name . '</p>';
        echo "<a href='/user/{$user->id}/delete'>Delete</a>";
        echo '<br>';
    }
?>

<?php require_once('application/views/layout/footer.php'); ?>

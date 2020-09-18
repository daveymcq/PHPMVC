<?php require_once('application/views/layout/header.php'); ?>
 
<p>Users#Index</p>

<?php
    print_r(new User);
    
    $users = $_PARAMS['users'];

    foreach($users as $user)
    {
        echo '<p>' . $user->id . '</p>';
        echo '<p>' . $user->email . '</p>';
        echo '<p>' . $user->first_name . '</p>';
        echo '<p>' . $user->last_name . '</p>';
        echo '<p>' . (int)$user->active . '</p>';
        echo '<br>';
    }
?>

<?php require_once('application/views/layout/footer.php'); ?>

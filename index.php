<?php
require_once 'core/init.php';

if (Session::exists('home')) {
    echo '<p>' . Session::flash('home') . '</p>';
}

$user = new User();


if ($user->isLoggedIn()) {
    ?>
    <p>Sveiki, <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->username); ?></a></p>

    <ul>
        <li><a href="logout.php">Atsijungti</a></li>
        <li><a href="update.php">Atnaujinti profilį</a></li>
        <li><a href="changepassword.php">Pakeisti slaptažodį</a></li>
    </ul>

<?php

    include_once 'tasks.php';
} else {
    echo '<p>Norint matyti užduotis jums reikia <a href="login.php">prisijungti</a> arba <a href="register.php">registruotis</a>.</p>';
}

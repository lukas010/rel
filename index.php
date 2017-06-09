<?php
require_once 'core/init.php';

include 'includes/head.php';
include 'includes/navbar.php';

// if (Session::exists('home')) {
//     echo '<p>' . Session::flash('home') . '</p>';
// }

if ($user->isLoggedIn()) {
    if (Session::exists('msg_add') && $_SESSION['msg_add'] === 'true') {
        Session::flash('msg_add'); ?><div class="container">
            <div class="alert alert-success" role="alert">
                <p>Užduotis priskirta!</p>
            </div>
        </div><?php

    }
    if (Session::exists('msg_update') && $_SESSION['msg_update'] === 'true') {
        Session::flash('msg_update'); ?><div class="container">
            <div class="alert alert-success" role="alert">
                <p>Užduotis redaguota!</p>
            </div>
        </div><?php

    }
    if (Session::exists('msg_del') && $_SESSION['msg_del'] === 'true') {
        Session::flash('msg_del'); ?><div class="container">
            <div class="alert alert-success" role="alert">
                <p>Užduotis ištrinta!</p>
            </div>
        </div><?php

    }
    if (Session::exists('msg_mark') && $_SESSION['msg_mark'] === 'true') {
        Session::flash('msg_mark'); ?><div class="container">
            <div class="alert alert-success" role="alert">
                <p>Užduotis pažymėta kaip įvykdyta!</p>
            </div>
        </div><?php

    }

    if (Session::exists('update_task') && $_SESSION['update_task'] === 'true') {
        include_once 'updatetask.php';
        Session::delete('update_task');
    } elseif (Session::exists('delete_task') && $_SESSION['delete_task'] === 'true') {
        include_once 'deletetask.php';
        Session::delete('delete_task');
    } else {
        include_once 'showtasks.php';
    }
} else {
    Session::delete('isLoggedIn');
    Redirect::to('login.php');
}

include 'includes/footer.php';

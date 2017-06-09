<?php
require_once 'core/init.php';
Session::put('delete_task', 'true');
include_once 'index.php';

if ($user->hasPermission('admin')) {
    if ($_GET['tid'] && is_numeric($_GET['tid'])) {
        if ($task->deleteTask($_GET['tid'])) {
            Session::flash('msg_del', 'true');
            Redirect::to('index.php');
        }
    } else {
        Redirect::to('index.php');
    }
} else {
    Redirect::to('index.php');
}

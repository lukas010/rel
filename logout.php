<?php
require_once 'core/init.php';

$user = new User();
$user->logout();
Session::delete('isLoggedIn');

Redirect::to('index.php');

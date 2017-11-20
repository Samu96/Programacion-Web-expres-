<?php
include_once 'lib.php';
User::logout();
header('location:index.php');
die;

?>
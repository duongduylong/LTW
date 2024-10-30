<?php
session_start();
ob_start();
unset($_SESSION['login']);
unset($_SESSION['credit']);
header('Location: login');
?>
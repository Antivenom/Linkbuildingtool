<?php
require_once 'config.php';

unset($_SESSION['UserID']);
unset($_SESSION['CustomerID']);
session_destroy();

header('Location: index.php');
	
?>
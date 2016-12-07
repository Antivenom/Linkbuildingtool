<?php
	
require_once '../config.php';

if(!isset($_SESSION['UserID']) || !$hasPermission->activeUser($_SESSION['UserID']) || !$hasPermission->activeCustomer($_SESSION['CustomerID']))
{
session_destroy();
	header('Location: ../offline/offline.html');
} else {
	if(empty($_GET['user'])) {
		header('HTTP/1.1 404 Not Found');
		header('Location: ../offline/notfound.html');
	} else {
		$UserID = $_SESSION['UserID'];
		$permission = $hasPermission->manageUser($UserID);
		
		if(!$permission)
		{
			$htmlPage = file_get_contents('../offline/denied.html');
			$title = 'Denied';		
			echo $htmlPage;
		} else {
			$objUser->delete($_GET['user']);

			$objUser->redirect('users.php');
		}
	}
}
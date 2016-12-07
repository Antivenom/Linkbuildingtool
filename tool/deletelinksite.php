<?php
	
require_once '../config.php';

if(!isset($_SESSION['UserID']) || !$hasPermission->activeUser($_SESSION['UserID']) || !$hasPermission->activeCustomer($_SESSION['CustomerID']))
{
session_destroy();
	header('Location: ../offline/offline.html');
} else {
	if(empty($_GET['linksite'])) {
		header('HTTP/1.1 404 Not Found');
		header('Location: ../offline/notfound.html');
	} else {
		$UserID = $_SESSION['UserID'];
		$CustomerID = $_SESSION['CustomerID'];
		$hasAccess = ($hasPermission->Linksite($_GET['linksite'], $CustomerID));
		
		if($hasAccess)
		{
			$objLinksite->delete($_GET['linksite']);

			$objUser->redirect('linksites.php');
		} else {
			
			$htmlPage = file_get_contents('../offline/denied.html');
			$title = 'Denied';		
			echo $htmlPage;
		}
	}
}
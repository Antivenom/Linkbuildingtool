<?php
	
require_once '../config.php';

if(!isset($_SESSION['UserID']) || !$hasPermission->activeUser($_SESSION['UserID']) || !$hasPermission->activeCustomer($_SESSION['CustomerID']))
{
	session_destroy();
	header('Location: ../offline/offline.html');
} else {
	if(empty($_GET['campaign'])) {
		header('HTTP/1.1 404 Not Found');
		header('Location: ../offline/notfound.html');
	} else {
		$UserID = $_SESSION['UserID'];
		$CustomerID = $_SESSION['CustomerID'];
		$hasAccess = ($hasPermission->isSuperuser($UserID) && $hasPermission->Campaign($_GET['campaign'], $CustomerID));
		
		if($hasAccess)
		{
			$objCampaign->delete($_GET['campaign']);

			$objUser->redirect('campaigns.php');
		} else {
			
			$htmlPage = file_get_contents('../offline/denied.html');
			$title = 'Denied';		
			echo $htmlPage;
		}
	}
}
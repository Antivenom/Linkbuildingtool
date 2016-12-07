<?php
	
require_once '../config.php';

if(!isset($_SESSION['UserID']) || !$hasPermission->activeUser($_SESSION['UserID']) || !$hasPermission->activeCustomer($_SESSION['CustomerID']))
{
session_destroy();
	header('Location: ../offline/offline.html');
} else {
	$UserID = $_SESSION['UserID'];
	$noPerms = !$hasPermission->isSuperuser($UserID);
	
	if($noPerms)
	{
		$objUser->redirect('../offline/denied.html');
	} else {
		if(isset($_POST['adduser']))
		{
			$CustomerID = $_SESSION['CustomerID'];
			$email = trim($_POST['email']);
			$password = $_POST['password'];
			$firstname = trim($_POST['firstname']);
			$lastname = trim($_POST['lastname']);
			$superUser = $_POST['superuser'];
			if($objUser->add($CustomerID, $email, $password, $firstname, $lastname, $superUser))
			{
				$objUser->redirect('../offline/added.html');
			}
		}

		
		$htmlPage = file_get_contents('../html/manageuser.html');
	
		$title = 'Register a user';
		$headText = 'Register a user';
		$buttonText = 'REGISTER';
		$submitName = 'adduser';
		
		$campaigns = '<li><a href="../tool/campaigns.php">Campaigns</a></li>';
		$linksites = '<li><a href="../tool/linksites.php">Linksites</a></li>';
		$moderate = '<li class="active"><a href="../tool/moderate.php">Admin</a></li>';
		$htmlPage = str_replace('%campaigns%', $campaigns, $htmlPage);
		$htmlPage = str_replace('%linksites%', $linksites, $htmlPage);
		$htmlPage = str_replace('%admin%', $moderate, $htmlPage);	
		
		$getUser = ($objUser->getUser($_SESSION['UserID']));
			
		$userFirstName = $getUser['firstname'];
		$userLastName = $getUser['lastname'];

		$htmlPage = str_replace('%emailPlaceholder%', '', $htmlPage);
		$htmlPage = str_replace('%passwordPlaceholder%', '', $htmlPage);
		$htmlPage = str_replace('%firstnamePlaceholder%', $firstname, $htmlPage);
		$htmlPage = str_replace('%lastnamePlaceholder%', $lastname, $htmlPage);
		
		$errorDiv = '<div class="alert alert-danger">
					<i class="fa fa-exclamation-triangle"></i> &nbsp; '. $error .'
				</div>';
					
		if(empty($error))
		{
			$htmlPage = str_replace('%error%', '', $htmlPage);
		} else {
			$htmlPage = str_replace('%error%', $errorDiv, $htmlPage);
		}
		
		$htmlPage = str_replace('%title%', $title, $htmlPage);
		$htmlPage = str_replace('%headText%', $headText, $htmlPage);
		$htmlPage = str_replace('%buttonText%', $buttonText, $htmlPage);
		
		$htmlPage = str_replace('%userFirstName%', $userFirstName, $htmlPage);
		$htmlPage = str_replace('%userLastName%', $userLastName, $htmlPage);
		
		$htmlPage = str_replace('%submitname%', $submitName, $htmlPage);
		
		echo $htmlPage;	
	}
}
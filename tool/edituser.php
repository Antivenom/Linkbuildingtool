<?php
	
require_once '../config.php';

if(!isset($_SESSION['UserID']) || !$hasPermission->activeUser($_SESSION['UserID']) || !$hasPermission->activeCustomer($_SESSION['CustomerID'])) {
	header('Location: ../offline/offline.html');
} else {
	$UserID = $_SESSION['UserID'];
	$permission = $hasPermission->manageUser($_GET['user']);
	
	if(!$permission)
	{
		$objUser->redirect('../offline/denied.html');
	} else {
		if(isset($_POST['edituser']))
		{
			$UserID = ($_GET['user']);
			$email = trim($_POST['email']);
			$firstname = trim($_POST['firstname']);
			$lastname = trim($_POST['lastname']);
			$SuperUser = $_POST['superuser'];
			$active = $_POST['active'];
			if($objUser->update($UserID, $email, $firstname, $lastname, $SuperUser, $active))
			{
				$objUser->redirect('../offline/updated.html');
			}
		}

		
		$htmlPage = file_get_contents('../html/manageuser.html');
	
		$title = 'Edit a user';
		$headText = 'Edit a user';
		$buttonText = 'SAVE';
		$submitName = 'edituser';
		
		$campaigns = '<li><a href="../tool/campaigns.php">Campaigns</a></li>';
		$linksites = '<li><a href="../tool/linksites.php">Linksites</a></li>';
		$moderate = '<li class="active"><a href="../tool/moderate.php">Admin</a></li>';
		$htmlPage = str_replace('%campaigns%', $campaigns, $htmlPage);
		$htmlPage = str_replace('%linksites%', $linksites, $htmlPage);
		$htmlPage = str_replace('%admin%', $moderate, $htmlPage);	
		
		$getLoggedUser = ($objUser->getUser($_SESSION['UserID']));
		
		$getUserWhereID = ($_GET['user']);
		$getUser = $objUser->getUser($getUserWhereID);
			
		$userFirstName = $getLoggedUser['firstname'];
		$userLastName = $getLoggedUser['lastname'];
		
		$errorDiv = '<div class="alert alert-danger">
					<i class="fa fa-exclamation-triangle"></i> &nbsp; '. $error .'
				</div>';
					
		if(empty($error))
		{
			$htmlPage = str_replace('%error%', '', $htmlPage);
		} else {
			$htmlPage = str_replace('%error%', $errorDiv, $htmlPage);
		}
		
		if($getUser['superuser'] == "0")
		{
			$htmlPage = str_replace('%selectedNo%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedNo%', '', $htmlPage);
		}
		if($getUser['superuser'] == "1")
		{
			$htmlPage = str_replace('%selectedYes%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedYes%', '', $htmlPage);
		}
		
		if($getUser['active'] == "0")
		{
			$htmlPage = str_replace('%selectedANo%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedANo%', '', $htmlPage);
		}
		if($getUser['active'] == "1")
		{
			$htmlPage = str_replace('%selectedAYes%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedAYes%', '', $htmlPage);
		}
		
		$email = $getUser['email'];
		$firstname = $getUser['firstname'];
		$lastname = $getUser['lastname'];
		
		$htmlPage = str_replace('%emailPlaceholder%', $email, $htmlPage);
		$htmlPage = str_replace('%passwordPlaceholder%', '', $htmlPage);
		$htmlPage = str_replace('%firstnamePlaceholder%', $firstname, $htmlPage);
		$htmlPage = str_replace('%lastnamePlaceholder%', $lastname, $htmlPage);
		
		$htmlPage = str_replace('%title%', $title, $htmlPage);
		$htmlPage = str_replace('%headText%', $headText, $htmlPage);
		$htmlPage = str_replace('%buttonText%', $buttonText, $htmlPage);
		
		$htmlPage = str_replace('%userFirstName%', $userFirstName, $htmlPage);
		$htmlPage = str_replace('%userLastName%', $userLastName, $htmlPage);
		
		$htmlPage = str_replace('%submitname%', $submitName, $htmlPage);
		
		echo $htmlPage;	
	}
}
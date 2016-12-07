<?php
	
require_once '../config.php';

if(!isset($_SESSION['UserID']) || !$hasPermission->activeUser($_SESSION['UserID']) || !$hasPermission->activeCustomer($_SESSION['CustomerID'])){
	header('Location: ../offline/offline.html');
} else {
	$UserID = $_SESSION['UserID'];
	$noSuperUser = !$hasPermission->isSuperuser($UserID);
	
	if($noSuperUser)
	{
		$htmlPage = file_get_contents('../html/profile.html');
		
		$title = 'Profile';
		
		$headText = 'View profile';
		
		$campaigns = '<li class="active"><a href="../tool/campaigns.php">Campaigns</a></li>';
		$linksites = '<li><a href="../tool/linksites.php">Linksites</a></li>';
		$moderate = '';
		
		$firstname = 'Name: '. ($objUser->getUser($_SESSION['UserID'])['firstname']);
		$lastname =  ($objUser->getUser($_SESSION['UserID'])['lastname']);
		$email = ($objUser->getUser($_SESSION['UserID'])['email']);
		$password = 'Password: <a href="changepassword.php">Change Password</a>';
		
		$getUser = ($objUser->getUser($_SESSION['UserID']));
				
		$userFirstName = $getUser['firstname'];
		$userLastName = $getUser['lastname'];
		
		$htmlPage = str_replace('%userFirstName%', $userFirstName, $htmlPage);
		$htmlPage = str_replace('%userLastName%', $userLastName, $htmlPage);
		
		$htmlPage = str_replace('%campaigns%', $campaigns, $htmlPage);
		$htmlPage = str_replace('%linksites%', $linksites, $htmlPage);
		$htmlPage = str_replace('%admin%', $moderate, $htmlPage);
		
		$htmlPage = str_replace('%title%', $title, $htmlPage);
		$htmlPage = str_replace('%headText%', $headText, $htmlPage);
		
		$htmlPage = str_replace('%firstname%', $firstname, $htmlPage);
		$htmlPage = str_replace('%lastname%', $lastname, $htmlPage);
		$htmlPage = str_replace('%email%', $email, $htmlPage);
		$htmlPage = str_replace('%password%', $password, $htmlPage);
		
		echo $htmlPage;
	} else {
		$htmlPage = file_get_contents('../html/profile.html');
		
		$title = 'Profile';
		
		$headText = 'View profile';
		
		$campaigns = '<li class="active"><a href="../tool/campaigns.php">Campaigns</a></li>';
		$linksites = '<li><a href="../tool/linksites.php">Linksites</a></li>';
		$moderate = '<li><a href="../tool/moderate.php">Admin</a></li>';
		
		$firstname = 'Name: '. ($objUser->getUser($_SESSION['UserID'])['firstname']);
		$lastname =  ($objUser->getUser($_SESSION['UserID'])['lastname']);
		$email = ($objUser->getUser($_SESSION['UserID'])['email']);
		$password = 'Password: <a href="changepassword.php">Change Password</a>';
		
		$getUser = ($objUser->getUser($_SESSION['UserID']));
				
		$userFirstName = $getUser['firstname'];
		$userLastName = $getUser['lastname'];
		
		$htmlPage = str_replace('%userFirstName%', $userFirstName, $htmlPage);
		$htmlPage = str_replace('%userLastName%', $userLastName, $htmlPage);
		
		$htmlPage = str_replace('%campaigns%', $campaigns, $htmlPage);
		$htmlPage = str_replace('%linksites%', $linksites, $htmlPage);
		$htmlPage = str_replace('%admin%', $moderate, $htmlPage);
		
		$htmlPage = str_replace('%title%', $title, $htmlPage);
		$htmlPage = str_replace('%headText%', $headText, $htmlPage);
		
		$htmlPage = str_replace('%firstname%', $firstname, $htmlPage);
		$htmlPage = str_replace('%lastname%', $lastname, $htmlPage);
		$htmlPage = str_replace('%email%', $email, $htmlPage);
		$htmlPage = str_replace('%password%', $password, $htmlPage);
		
		echo $htmlPage;
	}
}
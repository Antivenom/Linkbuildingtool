<?php
	
require_once '../config.php';

if(!isset($_SESSION['UserID']) || !$hasPermission->activeUser($_SESSION['UserID']) || !$hasPermission->activeCustomer($_SESSION['CustomerID'])){
	header('Location: ../offline/offline.html');
} else {
	$UserID = $_SESSION['UserID'];
	$noPerms = !$hasPermission->isSuperuser($UserID);
	
	if($noPerms)
	{
		$objUser->redirect('../offline/denied.html');
	} else {
		$htmlPage = file_get_contents('../html/moderate.html');
		
		$title = 'Admin Panel';
		$headText = 'Admin panel';
		
		$addUser = '../tool/adduser.php';
		$addCampaign = '../tool/addcampaign.php';
		$addLinksite = '../tool/addlinksite.php';
		
		$editUsers = '../tool/users.php';
		$editCampaigns = '../tool/campaigns.php';
		$editLinksites = '../tool/linksites.php';
		
		$viewProfile = '../tool/profile.php';

		$Robin = '../robin/index.php';

		$backupWS = '../backup/backupws.php';
		$backupDB = '../backup/backupdb.php';
		
		$campaigns = '<li><a href="../tool/campaigns.php">Campaigns</a></li>';
		$linksites = '<li><a href="../tool/linksites.php">Linksites</a></li>';
		$moderate = '<li class="active"><a href="../tool/moderate.php">Admin </a></li>';
		
		$getUser = ($objUser->getUser($_SESSION['UserID']));
				
		$userFirstName = $getUser['firstname'];
		$userLastName = $getUser['lastname'];
		
		$htmlPage = str_replace('%userFirstName%', $userFirstName, $htmlPage);
		$htmlPage = str_replace('%userLastName%', $userLastName, $htmlPage);
		
		$htmlPage = str_replace('%campaigns%', $campaigns, $htmlPage);
		$htmlPage = str_replace('%linksites%', $linksites, $htmlPage);
		$htmlPage = str_replace('%admin%', $moderate, $htmlPage);
	
		$htmlPage=  str_replace('%title%', $title, $htmlPage);
		
		$htmlPage = str_replace('%headText%', $headText, $htmlPage);
		
		$htmlPage = str_replace('%addUser%', $addUser, $htmlPage);
		$htmlPage = str_replace('%addCampaign%', $addCampaign, $htmlPage);
		$htmlPage = str_replace('%addLinksite%', $addLinksite, $htmlPage);
		
		$htmlPage = str_replace('%editUsers%', $editUsers, $htmlPage);
		$htmlPage = str_replace('%editCampaigns%', $editCampaigns, $htmlPage);
		$htmlPage = str_replace('%editLinksites%', $editLinksites, $htmlPage);
		
		$htmlPage = str_replace('%viewProfile%', $viewProfile, $htmlPage);
		
		echo $htmlPage;
	}
}
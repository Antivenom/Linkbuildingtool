<?php
	
require_once '../config.php';

if(!isset($_SESSION['UserID']) || !$hasPermission->activeUser($_SESSION['UserID']) || !$hasPermission->activeCustomer($_SESSION['CustomerID'])){
	session_destroy();
	header('Location: ../offline/offline.html');
} else {
	$UserID = $_SESSION['UserID'];
	$CustomerID = $_SESSION['CustomerID'];
	$activeCustomer = $hasPermission->activeUser($CustomerID);
	$activeUser = $hasPermission->activeUser($UserID);

	$active = '';

	if($activeCustomer = '1' && $activeUser = '1') {
		$active = '1';
	}

	$permission = $hasPermission->isSuperuser($UserID) && $active = '1';

	if(!$permission)
	{
		$htmlPage = file_get_contents('../html/toolindex.html');
		$title = 'Home';
		$userName = ($objUser->getUser($_SESSION['UserID'])['firstname']);
		$campaigns = '<li><a href="../tool/campaigns.php">Campaigns</a></li>';
		$linksites = '<li><a href="../tool/linksites.php">Linksites</a></li>';
		$moderate = '';

		$linksitesbtn = '<a href="linksites.php" class="hi-icon hi-icon-support">Support</a>';
		$campaignsbtn = '<a href="campaigns.php" class="hi-icon hi-icon-earth">Earth</a>';
		$moderatebtn = '';
		
		$htmlPage = str_replace('%campaignsbtn%', $campaignsbtn, $htmlPage);
		$htmlPage = str_replace('%linksitesbtn%', $linksitesbtn, $htmlPage);
		$htmlPage = str_replace('%moderatebtn%', $moderatebtn, $htmlPage);
		
		$getUser = ($objUser->getUser($_SESSION['UserID']));
		$userFirstName = $getUser['firstname'];
		$userLastName = $getUser['lastname'];
		
		if($getUser = $permission)
		{
			$htmlPage = str_replace('%amISU%', 'Status: Admin', $htmlPage);
		} else {
			$htmlPage = str_replace('%amISU%', 'Status: User', $htmlPage);
		}
		
		$CustomerID = $_SESSION['CustomerID'];
		$amountOfCampaigns = 'Amount of Campaigns: '. $objCampaign->count($CustomerID);
		$amountOfLinksites = 'Amount of Linksites: '. $objLinksite->count($CustomerID);
		
		$htmlPage = str_replace('%amountOfCampaigns%', $amountOfCampaigns, $htmlPage);
		$htmlPage = str_replace('%amountOfLinksites%', $amountOfLinksites, $htmlPage);
		
		$htmlPage = str_replace('%title%', $title, $htmlPage);
		$htmlPage = str_replace('%home%', $home, $htmlPage);
		$htmlPage = str_replace('%campaigns%', $campaigns, $htmlPage);
		$htmlPage = str_replace('%linksites%', $linksites, $htmlPage);
		$htmlPage = str_replace('%admin%', $moderate, $htmlPage);
		$htmlPage = str_replace('%userFirstName%', $userFirstName, $htmlPage);
		$htmlPage = str_replace('%userLastName%', $userLastName, $htmlPage);
		
		$htmlPage = str_replace('%userName%', $userName, $htmlPage);
		
		
		
		echo $htmlPage;
	} else {
		$htmlPage = file_get_contents('../html/toolindex.html');
		$title = 'Home';
		$userName = ($objUser->getUser($_SESSION['UserID'])['firstname']);
		$campaigns = '<li><a href="campaigns.php">Campaigns</a></li>';
		$linksites = '<li><a href="linksites.php">Linksites</a></li>';
		$moderate = '<li><a href="moderate.php">Admin</a></li>';
		
		$linksitesbtn = '<li><a href="linksites.php"><i class="fa fa-link"></i></a></li>';
		$campaignsbtn = '<a href="campaigns.php" class="hi-icon hi-icon-earth">Campaigns<span>Campaigns</span></a>';
		$moderatebtn = '<a href="moderate.php" class="hi-icon hi-icon-locked">Admin<span>Admin</span></a>';
		
		$htmlPage = str_replace('%campaignsbtn%', $campaignsbtn, $htmlPage);
		$htmlPage = str_replace('%linksitesbtn%', $linksitesbtn, $htmlPage);
		$htmlPage = str_replace('%moderatebtn%', $moderatebtn, $htmlPage);
		
		$getUser = ($objUser->getUser($_SESSION['UserID']));
		$userFirstName = $getUser['firstname'];
		$userLastName = $getUser['lastname'];

		if($getUser = $permission)
		{
			$htmlPage = str_replace('%amISU%', 'Status: Admin', $htmlPage);
		} else {
			$htmlPage = str_replace('%amISU%', 'Status: User', $htmlPage);
		}
		
		$CustomerID = $_SESSION['CustomerID'];
		$amountOfCampaigns = 'Amount of Campaigns: '. $objCampaign->count($CustomerID);
		$amountOfLinksites = 'Amount of Linksites: '. $objLinksite->count($CustomerID);
		
		$htmlPage = str_replace('%amountOfCampaigns%', $amountOfCampaigns, $htmlPage);
		$htmlPage = str_replace('%amountOfLinksites%', $amountOfLinksites, $htmlPage);
		
		$htmlPage = str_replace('%title%', $title, $htmlPage);
		$htmlPage = str_replace('%home%', $home, $htmlPage);
		$htmlPage = str_replace('%campaigns%', $campaigns, $htmlPage);
		$htmlPage = str_replace('%linksites%', $linksites, $htmlPage);
		$htmlPage = str_replace('%admin%', $moderate, $htmlPage);
		$htmlPage = str_replace('%userFirstName%', $userFirstName, $htmlPage);
		$htmlPage = str_replace('%userLastName%', $userLastName, $htmlPage);
		
		$htmlPage = str_replace('%userName%', $userName, $htmlPage);


		
		echo $htmlPage;
	}
}

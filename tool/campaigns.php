<?php
	
require_once '../config.php';

if(!isset($_SESSION['UserID']) || !$hasPermission->activeUser($_SESSION['UserID']) || !$hasPermission->activeCustomer($_SESSION['CustomerID']))
{
session_destroy();
	header('Location: ../offline/offline.html');
} else {
	$UserID = $_SESSION['UserID'];
	$noSuperUser = !$hasPermission->isSuperuser($UserID);
	
	if($noSuperUser)
	{
		$htmlPage = file_get_contents('../html/campaigns.html');
	
		$title = 'Campaigns';
		
		$campaigns = '<li class="active"><a href="../tool/campaigns.php">Campaigns</a></li>';
		$linksites = '<li><a href="../tool/linksites.php">Linksites</a></li>';
		$moderate = '';
	
		
		$CustomerID = $_SESSION['CustomerID'];
		$getCampaigns = $objCampaign->getCampaigns($CustomerID);
		
		$getUser = ($objUser->getUser($_SESSION['UserID']));
				
		$userFirstName = $getUser['firstname'];
		$userLastName = $getUser['lastname'];
		
		$htmlPage = str_replace('%userFirstName%', $userFirstName, $htmlPage);
		$htmlPage = str_replace('%userLastName%', $userLastName, $htmlPage);
		
		$htmlPage = str_replace('%title%', $title, $htmlPage);
		$htmlPage = str_replace('%campaigns%', $campaigns, $htmlPage);
		$htmlPage = str_replace('%linksites%', $linksites, $htmlPage);
		$htmlPage = str_replace('%admin%', $moderate, $htmlPage);
		
		$angularData = "";
		foreach($getCampaigns as $campaign)
		{	
			$angularData .= '
				{
					"id" : "'.$campaign['id'].'",
					"name" : "'.$campaign['name'].'",
			        "url" : "'.$campaign['url'].'",
			        "bot" : "'.$campaign['bot_enabled'].'",
			        "active" : "'.$campaign['active'].'"
				},';
		}
		
		$htmlPage = str_replace('%angularData%', $angularData, $htmlPage);
		
		
		
		echo $htmlPage;
	} else {
		$htmlPage = file_get_contents('../html/campaigns.html');
	
		$title = 'Campaigns';
		
		$campaigns = '<li class="active"><a href="../tool/campaigns.php">Campaigns</a></li>';
		$linksites = '<li><a href="../tool/linksites.php">Linksites</a></li>';
		$moderate = '<li><a href="../tool/moderate.php">Admin</a></li>';
		
		
		$CustomerID = $_SESSION['CustomerID'];
		$getCampaigns = ($objCampaign->getCampaigns($CustomerID));
		
		$getUser = ($objUser->getUser($_SESSION['UserID']));
				
		$userFirstName = $getUser['firstname'];
		$userLastName = $getUser['lastname'];
		
		$htmlPage = str_replace('%userFirstName%', $userFirstName, $htmlPage);
		$htmlPage = str_replace('%userLastName%', $userLastName, $htmlPage);
		
		$htmlPage = str_replace('%title%', $title, $htmlPage);
		$htmlPage = str_replace('%campaigns%', $campaigns, $htmlPage);
		$htmlPage = str_replace('%linksites%', $linksites, $htmlPage);
		$htmlPage = str_replace('%admin%', $moderate, $htmlPage);
		

		
		$angularData = "";
		foreach($getCampaigns as $campaign)
		{
			$bot = ($campaign['bot_status'] == '0')? "Disabled" : "Enabled";
			$active = ($campaign['active'] == '0')? "No" : "Yes";

			$angularData .= '
				{
					"id" : "'.$campaign['id'].'",
					"name" : "'.$campaign['name'].'",
			        "url" : "'.$campaign['url'].'",
			        "bot" : "'.$bot.'",
			        "active" : "'.$active.'"
				},';
		}
		
		$htmlPage = str_replace('%angularData%', $angularData, $htmlPage);
		
		if($campaign['bot_enabled'] == "1") {
			$htmlPage = str_replace('%botText%', 'Online', $htmlPage);
		} else {
			$htmlPage = str_replace('%botText%', 'Terminated', $htmlPage);
		}
		
		if($campaign['active'] == "1") {
			$htmlPage = str_replace('%active%', 'Online', $htmlPage);
		} else {
			$htmlPage = str_replace('%active%', 'Terminated', $htmlPage);
		}
		echo $htmlPage;
		
	}
}

<?php
	
require_once '../config.php';

if(!isset($_SESSION['UserID']) || !$hasPermission->activeUser($_SESSION['UserID']) || !$hasPermission->activeCustomer($_SESSION['CustomerID'])){
	header('Location: ../offline/offline.html');
} else {
	$UserID = $_SESSION['UserID'];
	$noSuperUser = !$hasPermission->isSuperuser($UserID);
	
	if($noSuperUser)
	{
		$htmlPage = file_get_contents('../html/linksites.html');
		$title = 'Linksites';
		$campaigns = '<li><a href="../tool/campaigns.php">Campaigns </a></li>';
		$linksites = '<li class="active"><a href="../tool/linksites.php">Linksites</a></li>';
		$moderate = '';
		
		$CustomerID = $_SESSION['CustomerID'];
		$getLinksites = $objLinksite->getLinksites($CustomerID);
		
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
		foreach($getLinksites as $linksite)
		{	
			$angularData .= '
				{
					"id" : "'.$linksite['id'].'",
					"name" : "'.$linksite['name'].'",
			        "type" : "'.$linksite['type'].'",
			        "category" : "'.$linksite['category'].'",
			        "url" : "'.$linksite['url'].'",
			        "rip" : "'.$linksite['rip_status'].'"
				},';
		}
		
		$htmlPage = str_replace('%angularData%', $angularData, $htmlPage);
		
		echo $htmlPage;
	} else {
		$htmlPage = file_get_contents('../html/linksites.html');
		$title = 'Linksites';
		$campaigns = '<li><a href="../tool/campaigns.php">Campaigns </a></li>';
		$linksites = '<li class="active"><a href="../tool/linksites.php">Linksites</a></li>';
		$moderate = '<li><a href="../tool/moderate.php">Admin</a></li>';
		
		$CustomerID = $_SESSION['CustomerID'];
		$getLinksites = $objLinksite->getLinksites($CustomerID);
		
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
		foreach($getLinksites as $linksite)
		{
			$rip = ($linksite['rip_status'] == '0')? "No" : "Yes";


			$angularData .= '
				{
					"id" : "'.$linksite['id'].'",
					"name" : "'.$linksite['name'].'",
			        "type" : "'.$linksite['type'].'",
			        "category" : "'.$linksite['category'].'",
			        "url" : "'.$linksite['url'].'",
			        "rip" : "'.$rip.'"
				},';
		}
		
		$htmlPage = str_replace('%angularData%', $angularData, $htmlPage);
		
		
		echo $htmlPage;
	}
}

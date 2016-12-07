<?php
	
require_once '../config.php';

if(!isset($_SESSION['UserID']) || !$hasPermission->activeUser($_SESSION['UserID']) || !$hasPermission->activeCustomer($_SESSION['CustomerID'])){
	header('Location: ../offline/offline.html');
} else {
	$UserID = $_SESSION['UserID'];
	$noSuperUser = !$hasPermission->isSuperuser($UserID);
	
	if($noSuperUser)
	{
		$htmlPage = file_get_contents('../offline/denied.html');
		$title = 'Denied';		
		echo $htmlPage;
	} else {
		$htmlPage = file_get_contents('../html/users.html');
		$title = 'Users';
		$campaigns = '<li><a href="../tool/campaigns.php">Campaigns </a></li>';
		$linksites = '<li><a href="../tool/linksites.php">Linksites</a></li>';
		$moderate = '<li class="active"><a href="../tool/moderate.php">Admin</a></li>';
		
		$CustomerID = $_SESSION['CustomerID'];
		$getAllUsers = $objUser->getAllUsers($CustomerID);

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
		foreach($getAllUsers as $user)
		{
			$superuser = ($user['superuser'] == '0')? "No" : "Yes";
			$active = ($user['active'] == '0')? "No" : "Yes";

			$angularData .= '
				{
					"id" : "'.$user['id'].'",
					"firstname" : "'.$user['firstname'].'",
			        "lastname" : "'.$user['lastname'].'",
			        "email" : "'.$user['email'].'",
			        "superuser" : "'.$superuser.'",
			        "active" : "'.$active.'"

				},';
		}
		
		$htmlPage = str_replace('%angularData%', $angularData, $htmlPage);

		echo $htmlPage;
	}
}

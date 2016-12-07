<?php
	
require_once '../config.php';

if(!isset($_SESSION['UserID']) || !$hasPermission->activeUser($_SESSION['UserID']) || !$hasPermission->activeCustomer($_SESSION['CustomerID'])){
	header('Location: ../index.php');
} else {
	if(empty($_GET['linksite'])) {
		header('HTTP/1.1 404 Not Found');
		header('Location: ../offline/notfound.html');
	} else {
		if(!$hasPermission->Linksite($_GET['linksite'], $_SESSION['CustomerID']))
		{
			header('HTTP/1.1 403 Forbidden');
			$objUser->redirect('../offline/denied.html');
		} else {
			$UserID = $_SESSION['UserID'];
			$noSuperUser = !$hasPermission->isSuperuser($UserID);
			
			if($noSuperUser)
			{
				$linksite = $objLinksite->get($_GET['linksite']);

				$LinksiteID = $_GET['linksite'];
				$getLinksite = $objLinksite->get($LinksiteID);

				$htmlPage = file_get_contents('../html/linksite.html');

				$getUser = ($objUser->getUser($_SESSION['UserID']));

				$userFirstName = $getUser['firstname'];
				$userLastName = $getUser['lastname'];

				$htmlPage = str_replace('%userFirstName%', $userFirstName, $htmlPage);
				$htmlPage = str_replace('%userLastName%', $userLastName, $htmlPage);

				$title = 'Viewing Linksite';
				$htmlPage = str_replace('%title%', $title, $htmlPage);

				$campaigns = '<li><a href="../tool/campaigns.php">Campaigns</a></li>';
				$linksites = '<li class="active"><a href="../tool/linksites.php">Linksites</a></li>';
				$moderate = '';
				$htmlPage = str_replace('%campaigns%', $campaigns, $htmlPage);
				$htmlPage = str_replace('%linksites%', $linksites, $htmlPage);
				$htmlPage = str_replace('%admin%', $moderate, $htmlPage);

				$linksiteName = "";
				$linksiteType = "";
				$linksiteCategory = "";
				$linksiteRating = "";
				$linksiteComment = "";
				$linksiteURL = "";
				$linksiteSubmitPage = "";
				$linksiteCosts = "";
				$linksiteCostsAmount = "";
				$linksiteBacklink = "";
				$linksiteOwner = "";
				$linksiteOwnerEmail = "";
				$linksiteActive = "";


				foreach($getLinksite as $linksite){
					if($linksite['rating'] == '0') {
						$rating = "<i class=\"fa fa-star-o\"></i><i class=\"fa fa-star-o\"></i><i class=\"fa fa-star-o\"></i><i class=\"fa fa-star-o\"></i><i class=\"fa fa-star-o\"></i>";
					}

					if($linksite['rating'] == '1') {
						$rating = "<i class=\"fa fa-star\"></i><i class=\"fa fa-star-o\"></i><i class=\"fa fa-star-o\"></i><i class=\"fa fa-star-o\"></i><i class=\"fa fa-star-o\"></i>";
					}

					if($linksite['rating'] == '2') {
						$rating = "<i class=\"fa fa-star\"></i><i class=\"fa fa-star\"></i><i class=\"fa fa-star-o\"></i><i class=\"fa fa-star-o\"></i><i class=\"fa fa-star-o\"></i>";
					}

					if($linksite['rating'] == '3') {
						$rating = "<i class=\"fa fa-star\"></i><i class=\"fa fa-star\"></i><i class=\"fa fa-star\"></i><i class=\"fa fa-star-o\"></i><i class=\"fa fa-star-o\"></i>";
					}

					if($linksite['rating'] == '4') {
						$rating = "<i class=\"fa fa-star\"></i><i class=\"fa fa-star\"></i><i class=\"fa fa-star\"></i><i class=\"fa fa-star\"></i><i class=\"fa fa-star-o\"></i>";
					}

					if($linksite['rating'] == '5') {
						$rating = "<i class=\"fa fa-star\"></i><i class=\"fa fa-star\"></i><i class=\"fa fa-star\"></i><i class=\"fa fa-star\"></i><i class=\"fa fa-star\"></i>";
					}
					$cost = ($linksite['costs'] == '0')? "No" : "Yes";
					$backlink = ($linksite['backlink'] == '0')? "No" : "Yes";
					$active = ($linksite['rip_status'] == '0')? "No" : "Yes";

					$linksiteName = $linksite['name'];
					$linksiteType = $linksite['type'];
					$linksiteCategory = $linksite['category'];
					$linksiteRating = $rating;
					$linksiteComment = $linksite['comment'];
					$linksiteURL = $linksite['url'];
					$linksiteSubmitPage = $linksite['submit_page'];
					$linksiteCosts = $cost;
					$linksiteCostsAmount = $linksite['costs_amount'];
					$linksiteBacklink = $backlink;
					$linksiteOwner = $linksite['owner'];
					$linksiteOwnerEmail = $linksite['owner_email'];
					$linksiteActive = $active;
				}

				$htmlPage = str_replace('%linksiteName%', $linksiteName, $htmlPage);
				$htmlPage = str_replace('%linksiteType%', $linksiteType, $htmlPage);
				$htmlPage = str_replace('%linksiteCategory%', $linksiteCategory, $htmlPage);
				$htmlPage = str_replace('%linksiteRating%', $linksiteRating, $htmlPage);
				$htmlPage = str_replace('%linksiteComment%', $linksiteComment, $htmlPage);
				$htmlPage = str_replace('%linksiteURL%', $linksiteURL, $htmlPage);
				$htmlPage = str_replace('%linksiteSubmitPage%', $linksiteSubmitPage, $htmlPage);
				$htmlPage = str_replace('%linksiteCost%', $linksiteCosts, $htmlPage);
				$htmlPage = str_replace('%linksiteCostAmount%', $linksiteCostsAmount, $htmlPage);
				$htmlPage = str_replace('%linksiteBacklink%', $linksiteBacklink, $htmlPage);
				$htmlPage = str_replace('%linksiteOwner%', $linksiteOwner, $htmlPage);
				$htmlPage = str_replace('%linksiteOwnerEmail%', $linksiteOwnerEmail, $htmlPage);
				$htmlPage = str_replace('%linksiteActive%', $linksiteActive, $htmlPage);

				echo $htmlPage;
			} else {
				$linksite = $objLinksite->get($_GET['linksite']);

				$LinksiteID = $_GET['linksite'];
				$getLinksite = $objLinksite->get($LinksiteID);
			
				$htmlPage = file_get_contents('../html/linksite.html');
				
				$getUser = ($objUser->getUser($_SESSION['UserID']));
				
				$userFirstName = $getUser['firstname'];
				$userLastName = $getUser['lastname'];
				
				$htmlPage = str_replace('%userFirstName%', $userFirstName, $htmlPage);
				$htmlPage = str_replace('%userLastName%', $userLastName, $htmlPage);

				$title = 'Viewing Linksite';
				$htmlPage = str_replace('%title%', $title, $htmlPage);
				
				$campaigns = '<li><a href="../tool/campaigns.php">Campaigns</a></li>';
				$linksites = '<li class="active"><a href="../tool/linksites.php">Linksites</a></li>';
				$moderate = '<li><a href="../tool/moderate.php">Admin</a></li>';
				$htmlPage = str_replace('%campaigns%', $campaigns, $htmlPage);
				$htmlPage = str_replace('%linksites%', $linksites, $htmlPage);
				$htmlPage = str_replace('%admin%', $moderate, $htmlPage);

				$linksiteName = "";
				$linksiteType = "";
				$linksiteCategory = "";
				$linksiteRating = "";
				$linksiteComment = "";
				$linksiteURL = "";
				$linksiteSubmitPage = "";
				$linksiteCosts = "";
				$linksiteCostsAmount = "";
				$linksiteBacklink = "";
				$linksiteOwner = "";
				$linksiteOwnerEmail = "";
				$linksiteActive = "";


				foreach($getLinksite as $linksite){
					if($linksite['rating'] == '0') {
						$rating = "<i class=\"fa fa-star-o\"></i><i class=\"fa fa-star-o\"></i><i class=\"fa fa-star-o\"></i><i class=\"fa fa-star-o\"></i><i class=\"fa fa-star-o\"></i>";
					}

					if($linksite['rating'] == '1') {
						$rating = "<i class=\"fa fa-star\"></i><i class=\"fa fa-star-o\"></i><i class=\"fa fa-star-o\"></i><i class=\"fa fa-star-o\"></i><i class=\"fa fa-star-o\"></i>";
					}

					if($linksite['rating'] == '2') {
						$rating = "<i class=\"fa fa-star\"></i><i class=\"fa fa-star\"></i><i class=\"fa fa-star-o\"></i><i class=\"fa fa-star-o\"></i><i class=\"fa fa-star-o\"></i>";
					}

					if($linksite['rating'] == '3') {
						$rating = "<i class=\"fa fa-star\"></i><i class=\"fa fa-star\"></i><i class=\"fa fa-star\"></i><i class=\"fa fa-star-o\"></i><i class=\"fa fa-star-o\"></i>";
					}

					if($linksite['rating'] == '4') {
						$rating = "<i class=\"fa fa-star\"></i><i class=\"fa fa-star\"></i><i class=\"fa fa-star\"></i><i class=\"fa fa-star\"></i><i class=\"fa fa-star-o\"></i>";
					}

					if($linksite['rating'] == '5') {
						$rating = "<i class=\"fa fa-star\"></i><i class=\"fa fa-star\"></i><i class=\"fa fa-star\"></i><i class=\"fa fa-star\"></i><i class=\"fa fa-star\"></i>";
					}
					$cost = ($linksite['costs'] == '0')? "No" : "Yes";
					$backlink = ($linksite['backlink'] == '0')? "No" : "Yes";
					$active = ($linksite['rip_status'] == '0')? "No" : "Yes";

					$linksiteName = $linksite['name'];
					$linksiteType = $linksite['type'];
					$linksiteCategory = $linksite['category'];
					$linksiteRating = $rating;
					$linksiteComment = $linksite['comment'];
					$linksiteURL = $linksite['url'];
					$linksiteSubmitPage = $linksite['submit_page'];
					$linksiteCosts = $cost;
					$linksiteCostsAmount = $linksite['costs_amount'];
					$linksiteBacklink = $backlink;
					$linksiteOwner = $linksite['owner'];
					$linksiteOwnerEmail = $linksite['owner_email'];
					$linksiteActive = $active;
				}

				$htmlPage = str_replace('%linksiteName%', $linksiteName, $htmlPage);
				$htmlPage = str_replace('%linksiteType%', $linksiteType, $htmlPage);
				$htmlPage = str_replace('%linksiteCategory%', $linksiteCategory, $htmlPage);
				$htmlPage = str_replace('%linksiteRating%', $linksiteRating, $htmlPage);
				$htmlPage = str_replace('%linksiteComment%', $linksiteComment, $htmlPage);
				$htmlPage = str_replace('%linksiteURL%', $linksiteURL, $htmlPage);
				$htmlPage = str_replace('%linksiteSubmitPage%', $linksiteSubmitPage, $htmlPage);
				$htmlPage = str_replace('%linksiteCost%', $linksiteCosts, $htmlPage);
				$htmlPage = str_replace('%linksiteCostAmount%', $linksiteCostsAmount, $htmlPage);
				$htmlPage = str_replace('%linksiteBacklink%', $linksiteBacklink, $htmlPage);
				$htmlPage = str_replace('%linksiteOwner%', $linksiteOwner, $htmlPage);
				$htmlPage = str_replace('%linksiteOwnerEmail%', $linksiteOwnerEmail, $htmlPage);
				$htmlPage = str_replace('%linksiteActive%', $linksiteActive, $htmlPage);
				
				echo $htmlPage;
			}
		}
	}
}
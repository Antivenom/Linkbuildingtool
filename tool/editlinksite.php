<?php
	
require_once '../config.php';

if(!isset($_SESSION['UserID']) || !$hasPermission->activeUser($_SESSION['UserID']) || !$hasPermission->activeCustomer($_SESSION['CustomerID']))
{
	session_destroy();
	header('Location: ../offline/offline.html');
} else {
	$CustomerID = $_SESSION['CustomerID'];
	if(isset($_POST['editlinksite'])){
		$noPerms = !$hasPermission->Linksite($_POST['linkID'], $CustomerID);
	}else{
		$noPerms = !$hasPermission->Linksite($_GET['linksite'], $CustomerID);
	}

	
	if($noPerms)
	{
		$objUser->redirect('../offline/denied.html');
	} else {
		if(isset($_POST['editlinksite']))
		{
			$id = $_GET['linksite'];
			$name = trim($_POST['name']);
			$type = trim($_POST['type']);
			$category = trim($_POST['category']);
			$rating = $_POST['rating'];
			$comment = trim($_POST['comment']);
			$url = trim($_POST['url']);
			$submitpage = trim($_POST['submit_page']);
			$costs = isset($_POST['hasCosts']);
			$costs_amount = $_POST['costs'];
			$backlink = isset($_POST['backlink']);
			$owner = trim($_POST['owner']);
			$owneremail = trim($_POST['owneremail']);
			$rip_status = $_POST['rip'];
			$connectLinksites = $_POST['linked'];
			$linksiteID = $_POST['linkID'];
			if($objLinksite->update($linksiteID, $name, $type, $category, $rating, $comment, $url, $submitpage, $costs, $costs_amount, $backlink, $owner, $owneremail, $rip_status, $connectLinksites))
			{
				echo 'updated niggers';
			}
		}
		
		$htmlPage = file_get_contents('../html/managelinksite.html');	
		
		$title = 'Edit Linksite';
		$formName = 'editlinksite.php?linksite='.$_GET['linksite'];
		$headText = 'Edit a linksite';
		$buttonText = 'Save Changes';
		$submitName = 'editlinksite';
		
		$campaigns = '<li><a href="../tool/campaigns.php">Campaigns</a></li>';
		$linksites = '<li class="active"><a href="../tool/linksites.php">Linksites</a></li>';
		$moderate = '<li><a href="../tool/moderate.php">Admin</a></li>';
		$htmlPage = str_replace('%campaigns%', $campaigns, $htmlPage);
		$htmlPage = str_replace('%linksites%', $linksites, $htmlPage);
		$htmlPage = str_replace('%admin%', $moderate, $htmlPage);
		
		$getUser = ($objUser->getUser($_SESSION['UserID']));

		$userFirstName = $getUser['firstname'];
		$userLastName = $getUser['lastname'];



		$errorDiv = '<div class="alert alert-danger">
					<i class="fa fa-exclamation-triangle"></i> &nbsp; '. $error .'
				</div>';
					
		if(empty($error))
		{
			$htmlPage = str_replace('%error%', '', $htmlPage);
		} else {
			$htmlPage = str_replace('%error%', $errorDiv, $htmlPage);
		}
		
		if(empty($comment))
		{
			$htmlPage = str_replace('%comment%', '', $htmlPage);
		} else {
			$htmlPage = str_replace('%comment%', $commentPlaceholder, $htmlPage);
		}

		$getLinksite = ($objLinksite->getLinksite($_GET['linksite']));
		$linkSiteName = $getLinksite['name'];
		$linkSiteType = $getLinksite['type'];
		$linkSiteCategory = $getLinksite['category'];
		$linkSiteRating = $getLinksite['rating'];
		$linkSiteComment = $getLinksite['comment'];
		$linkSiteUrl = $getLinksite['url'];
		$linkSiteSubmitPage = $getLinksite['submit_page'];
		$linkSiteCosts = $getLinksite['costs'];
		$linkSiteCostsAmount = $getLinksite['costs_amount'];
		$linkSiteBacklink = $getLinksite['backlink'];
		$linkSiteOwner = $getLinksite['owner'];
		$linkSiteOwnerEmail = $getLinksite['owner_email'];

		if($linkSiteType == "Startpage")
		{
			$htmlPage = str_replace('%selectedStartpage%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedStartpage%', '', $htmlPage);
		}

		if($linkSiteType == "Blog")
		{
			$htmlPage = str_replace('%selectedBlog%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedBlog%', '', $htmlPage);
		}

		if($linkSiteType == "Search Engine")
		{
			$htmlPage = str_replace('%selectedSearchEngine%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedSearchEngine%', '', $htmlPage);
		}

		if($linkSiteType == "App")
		{
			$htmlPage = str_replace('%selectedApp%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedApp%', '', $htmlPage);
		}

		if($linkSiteType == "Social Media")
		{
			$htmlPage = str_replace('%selectedSocialMedia%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedSocialMedia%', '', $htmlPage);
		}

		if($linkSiteType == "Other")
		{
			$htmlPage = str_replace('%selectedOtherType%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedOtherType%', '', $htmlPage);
		}

		if($linkSiteCategory == "Art and Amusement")
		{
			$htmlPage = str_replace('%selectedArtAndAmusement%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedArtAndAmusement%', '', $htmlPage);
		}

		if($linkSiteCategory == "Automobileindustry")
		{
			$htmlPage = str_replace('%selectedAutomobileindustry%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedAutomobileindustry%', '', $htmlPage);
		}

		if($linkSiteCategory == "Beauty And Fitness")
		{
			$htmlPage = str_replace('%selectedBeautyAndFitness%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedBeautyAndFitness%', '', $htmlPage);
		}

		if($linkSiteCategory == "Books And Literature")
		{
			$htmlPage = str_replace('%selectedBooksAndLiterature%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedBooksAndLiterature%', '', $htmlPage);
		}

		if($linkSiteCategory == "Companies And industry")
		{
			$htmlPage = str_replace('%selectedCompaniesAndIndustry%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedCompaniesAndIndustry%', '', $htmlPage);
		}

		if($linkSiteCategory == "Computers and Electronics")
		{
			$htmlPage = str_replace('%selectedComputersAndElectronics%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedComputersAndElectronics%', '', $htmlPage);
		}

		if($linkSiteCategory == "Financial Services")
		{
			$htmlPage = str_replace('%selectedFinancialServices%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedFinancialServices%', '', $htmlPage);
		}

		if($linkSiteCategory == "Food and Drinks")
		{
			$htmlPage = str_replace('%selectedFoodAndDrinks%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedFoodAndDrinks%', '', $htmlPage);
		}

		if($linkSiteCategory == "Games")
		{
			$htmlPage = str_replace('%selectedGames%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedGames%', '', $htmlPage);
		}

		if($linkSiteCategory == "Healthcare")
		{
			$htmlPage = str_replace('%selectedHealthcare%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedHealthcare%', '', $htmlPage);
		}

		if($linkSiteCategory == "Hobbies")
		{
			$htmlPage = str_replace('%selectedHobbies%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedHobbies%', '', $htmlPage);
		}

		if($linkSiteCategory == "House and Garden")
		{
			$htmlPage = str_replace('%selectedHouseAndGarden%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedHouseAndGarden%', '', $htmlPage);
		}

		if($linkSiteCategory == "Internet and Telecom")
		{
			$htmlPage = str_replace('%selectedInternetAndTelecom%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedInternetAndTelecom%', '', $htmlPage);
		}

		if($linkSiteCategory == "Vacant and Education")
		{
			$htmlPage = str_replace('%selectedVacantAndEducation%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedVacantAndEducation%', '', $htmlPage);
		}

		if($linkSiteCategory == "Law and Government")
		{
			$htmlPage = str_replace('%selectedLawAndGovernment%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedLawAndGovernment%', '', $htmlPage);
		}

		if($linkSiteCategory == "News")
		{
			$htmlPage = str_replace('%selectedNews%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedNews%', '', $htmlPage);
		}

		if($linkSiteCategory == "Online Community")
		{
			$htmlPage = str_replace('%selectedOnlineCommunity%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedOnlineCommunity%', '', $htmlPage);
		}

		if($linkSiteCategory == "People and Society")
		{
			$htmlPage = str_replace('%selectedPeopleAndSociety%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedPeopleAndSociety%', '', $htmlPage);
		}

		if($linkSiteCategory == "Pets and Animal")
		{
			$htmlPage = str_replace('%selectedPetsAndAnimal%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedPetsAndAnimal%', '', $htmlPage);
		}

		if($linkSiteCategory == "Property")
		{
			$htmlPage = str_replace('%selectedProperty%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedProperty%', '', $htmlPage);
		}

		if($linkSiteCategory == "Reference")
		{
			$htmlPage = str_replace('%selectedReference%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedReference%', '', $htmlPage);
		}

		if($linkSiteCategory == "Science")
		{
			$htmlPage = str_replace('%selectedScience%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedScience%', '', $htmlPage);
		}

		if($linkSiteCategory == "Shopping")
		{
			$htmlPage = str_replace('%selectedShopping%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedShopping%', '', $htmlPage);
		}

		if($linkSiteCategory == "Sport")
		{
			$htmlPage = str_replace('%selectedSport%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedSport%', '', $htmlPage);
		}

		if($linkSiteCategory == "Traveling")
		{
			$htmlPage = str_replace('%selectedTraveling%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedTraveling%', '', $htmlPage);
		}

		if($linkSiteCategory == "Other")
		{
			$htmlPage = str_replace('%selectedOtherCategory%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedOtherCategory%', '', $htmlPage);
		}

		if($linkSiteCosts == "1")
		{
			$htmlPage = str_replace('%selectedCosts%', 'checked', $htmlPage);
			$htmlPage = str_replace('%selectedCostsAmount%', $linkSiteCostsAmount, $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedCosts%', '', $htmlPage);
			$htmlPage = str_replace('%selectedCostsAmount%', '', $htmlPage);
		}

		if($linkSiteBacklink == "1")
		{
			$htmlPage = str_replace('%selectedBacklink%', 'checked', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedBacklink%', '', $htmlPage);
		}

		if($getLinksite['rip_status'] == "1")
		{
			$htmlPage = str_replace('%selectedANo%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedANo%', '', $htmlPage);
		}
		if($getLinksite['rip_status'] == "0")
		{
			$htmlPage = str_replace('%selectedAYes%', 'selected', $htmlPage);
		} else {
			$htmlPage = str_replace('%selectedAYes%', '', $htmlPage);
		}

		if($linkSiteRating == "0")
		{
			$htmlPage = str_replace('%ratingValue%', '0', $htmlPage);
		}

		if($linkSiteRating == "1") {
			$htmlPage = str_replace('%ratingValue%', '1', $htmlPage);
		}

		if($linkSiteRating == "2")
		{
			$htmlPage = str_replace('%ratingValue%', '2', $htmlPage);
		}

		if($linkSiteRating == "3")
		{
			$htmlPage = str_replace('%ratingValue%', '3', $htmlPage);
		}

		if($linkSiteRating == "4")
		{
			$htmlPage = str_replace('%ratingValue%', '4', $htmlPage);
		}

		if($linkSiteRating == "5")
		{
			$htmlPage = str_replace('%ratingValue%', '5', $htmlPage);
		}
		
		$CustomerID = $_SESSION['CustomerID'];
		$getCampaigns = $objCampaign->getCampaigns($CustomerID);
		$angularData = "";
		foreach($getCampaigns as $campaign)
		{
			$currentLinksite = $_GET['linksite'];
			$submission = $objSubmission->getSubmission($campaign['id'], $currentLinksite);

			$select = '';
			if($submission === false) {
				$select = '';
			} else {
				$select = 'true';
			}

			$angularData .= '
				{
					"id" : "'.$campaign['id'].'",
					"name" : "'.$campaign['name'].'",
					"state" : "'.$select.'",
				},';
		}
		$htmlPage = str_replace('%angularData%', $angularData, $htmlPage);

		$htmlPage = str_replace('%linkID%', $_GET['linksite'], $htmlPage);
		$htmlPage = str_replace('%title%', $title, $htmlPage);
		$htmlPage = str_replace('%editLinksite%', $formName, $htmlPage);
		$htmlPage = str_replace('%headText%', $headText, $htmlPage);
		$htmlPage = str_replace('%buttonText%', $buttonText, $htmlPage);
		$htmlPage = str_replace('%submitname%', $submitName, $htmlPage);
		$htmlPage = str_replace('%linksite%', $submitName, $htmlPage);
		$htmlPage = str_replace('%userFirstName%', $userFirstName, $htmlPage);
		$htmlPage = str_replace('%userLastName%', $userLastName, $htmlPage);
		$htmlPage = str_replace('%linksiteName%', $linkSiteName, $htmlPage);
		$htmlPage = str_replace('%LinksiteComment%', $linkSiteComment, $htmlPage);
		$htmlPage = str_replace('%LinksiteUrl%', $linkSiteUrl, $htmlPage);
		$htmlPage = str_replace('%LinksiteSubmitPage%', $linkSiteSubmitPage, $htmlPage);
		$htmlPage = str_replace('%LinksiteOwner%', $linkSiteOwner, $htmlPage);
		$htmlPage = str_replace('%LinksiteOwnerEmail%', $linkSiteOwnerEmail, $htmlPage);
	
		echo $htmlPage;
	}
}
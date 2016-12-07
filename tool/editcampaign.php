<?php
	
require_once '../config.php';

if(!isset($_SESSION['UserID']) || !$hasPermission->activeUser($_SESSION['UserID']) || !$hasPermission->activeCustomer($_SESSION['CustomerID']))
{
session_destroy();
	header('Location: ../offline/offline.html');
} else {
	$CustomerID = $_SESSION['CustomerID'];
	$UserID = $_SESSION['UserID'];
	$noPerms = !$hasPermission->Campaign($_GET['campaign'], $CustomerID);
	$permission = $hasPermission->isSuperUser($UserID);
	
	if($noPerms)
	{
		$objUser->redirect('../offline/denied.html');
	} else {
		if(!$permission) {
			if(isset($_POST['editcampaign']))
			{
				$name = trim($_POST['name']);
				$email = trim($_POST['email']);
				$emailtemplate = trim($_POST['emailtemplate']);
				$url = trim($_POST['url']);
				$category = trim($_POST['category']);
				$title = trim($_POST['title']);
				$description = trim($_POST['description']);
				$owner = trim($_POST['owner']);
				$id = $_GET['campaign'];
				$active = $_POST['active'];
				
				if($objCampaign->update($CustomerID, $name, $email, $emailtemplate, $url, $category, $title, $description, $owner, $id, $active))
				{
					$objUser->redirect('account.php');
				}
			}
			
			$htmlPage = file_get_contents('../html/managecampaign.html');	
			
			$title = 'Edit Campaign';
			$headText = 'Edit a Campaign';
			$buttonText = 'Save Changes';
			$submitName = 'editcampaign';
			
			$campaigns = '<li class="active"><a href="../tool/campaigns.php">Campaigns</a></li>';
			$linksites = '<li><a href="../tool/linksites.php">Linksites</a></li>';
			$moderate = '';
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
			
			
			$getCampaign = ($objCampaign->getCampaign2($_GET['campaign']));
			$campaignName = $getCampaign['name'];
			$campaignEmail = $getCampaign['email'];
			$campaignEmailtemplate = $getCampaign['email_template'];
			$campaignUrl = $getCampaign['url'];
			$campaignCategory = $getCampaign['category'];
			$campaignTitle = $getCampaign['title'];
			$campaignDescription = $getCampaign['description'];
			$campaignOwner = $getCampaign['owner'];
			
			if($campaignCategory == "Business Index")
			{
				$htmlPage = str_replace('%selectedBusinessIndex%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedBusinessIndex%', '', $htmlPage);
			}
			
			if($campaignCategory == "Art and Amusement")
			{
				$htmlPage = str_replace('%selectedArtAndAmusement%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedArtAndAmusement%', '', $htmlPage);
			}
			
			if($campaignCategory == "Automobileindustry")
			{
				$htmlPage = str_replace('%selectedAutomobileindustry%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedAutomobileindustry%', '', $htmlPage);
			}
			
			if($campaignCategory == "Beauty And Fitness")
			{
				$htmlPage = str_replace('%selectedBeautyAndFitness%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedBeautyAndFitness%', '', $htmlPage);
			}
			
			if($campaignCategory == "Books And Literature")
			{
				$htmlPage = str_replace('%selectedBooksAndLiterature%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedBooksAndLiterature%', '', $htmlPage);
			}
			
			if($campaignCategory == "Companies And industry")
			{
				$htmlPage = str_replace('%selectedCompaniesAndIndustry%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedCompaniesAndIndustry%', '', $htmlPage);
			}
			
			if($campaignCategory == "Computers and Electronics")
			{
				$htmlPage = str_replace('%selectedComputersAndElectronics%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedComputersAndElectronics%', '', $htmlPage);
			}
			
			if($campaignCategory == "Financial Services")
			{
				$htmlPage = str_replace('%selectedFinancialServices%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedFinancialServices%', '', $htmlPage);
			}
			
			if($campaignCategory == "Food and Drinks")
			{
				$htmlPage = str_replace('%selectedFoodAndDrinks%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedFoodAndDrinks%', '', $htmlPage);
			}
			
			if($campaignCategory == "Games")
			{
				$htmlPage = str_replace('%selectedGames%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedGames%', '', $htmlPage);
			}
			
			if($campaignCategory == "Healthcare")
			{
				$htmlPage = str_replace('%selectedHealthcare%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedHealthcare%', '', $htmlPage);
			}
			
			if($campaignCategory == "Hobbies")
			{
				$htmlPage = str_replace('%selectedHobbies%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedHobbies%', '', $htmlPage);
			}
			
			if($campaignCategory == "House and Garden")
			{
				$htmlPage = str_replace('%selectedHouseAndGarden%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedHouseAndGarden%', '', $htmlPage);
			}
			
			if($campaignCategory == "Internet and Telecom")
			{
				$htmlPage = str_replace('%selectedInternetAndTelecom%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedInternetAndTelecom%', '', $htmlPage);
			}
			
			if($campaignCategory == "Vacant and Education")
			{
				$htmlPage = str_replace('%selectedVacantAndEducation%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedVacantAndEducation%', '', $htmlPage);
			}
			
			if($campaignCategory == "Law and Government")
			{
				$htmlPage = str_replace('%selectedLawAndGovernment%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedLawAndGovernment%', '', $htmlPage);
			}
			
			if($campaignCategory == "News")
			{
				$htmlPage = str_replace('%selectedNews%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedNews%', '', $htmlPage);
			}
			
			if($campaignCategory == "Online Community")
			{
				$htmlPage = str_replace('%selectedOnlineCommunity%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedOnlineCommunity%', '', $htmlPage);
			}
			
			if($campaignCategory == "People and Society")
			{
				$htmlPage = str_replace('%selectedPeopleAndSociety%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedPeopleAndSociety%', '', $htmlPage);
			}
			
			if($campaignCategory == "Pets and Animal")
			{
				$htmlPage = str_replace('%selectedPetsAndAnimal%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedPetsAndAnimal%', '', $htmlPage);
			}
			
			if($campaignCategory == "Property")
			{
				$htmlPage = str_replace('%selectedProperty%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedProperty%', '', $htmlPage);
			}
			
			if($campaignCategory == "Reference")
			{
				$htmlPage = str_replace('%selectedReference%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedReference%', '', $htmlPage);
			}
			
			if($campaignCategory == "Science")
			{
				$htmlPage = str_replace('%selectedScience%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedScience%', '', $htmlPage);
			}
			
			if($campaignCategory == "Shopping")
			{
				$htmlPage = str_replace('%selectedShopping%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedShopping%', '', $htmlPage);
			}
			
			if($campaignCategory == "Sport")
			{
				$htmlPage = str_replace('%selectedSport%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedSport%', '', $htmlPage);
			}
			
			if($campaignCategory == "Traveling")
			{
				$htmlPage = str_replace('%selectedTraveling%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedTraveling%', '', $htmlPage);
			}
			
			if($campaignCategory == "Other")
			{
				$htmlPage = str_replace('%selectedOtherCategory%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedOtherCategory%', '', $htmlPage);
			}
			
			if($getCampaign['active'] == "0")
			{
				$htmlPage = str_replace('%selectedANo%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedANo%', '', $htmlPage);
			}
			if($getCampaign['active'] == "1")
			{
				$htmlPage = str_replace('%selectedAYes%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedAYes%', '', $htmlPage);
			}
	
			if($getCampaign['bot_enabled'] == "0")
			{
				$htmlPage = str_replace('%selectedABNo%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedABNo%', '', $htmlPage);
			}
			if($getCampaign['bot_enabled'] == "1")
			{
				$htmlPage = str_replace('%selectedABYes%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedABYes%', '', $htmlPage);
			}
			
			
			$htmlPage = str_replace('%title%', $title, $htmlPage);
			$htmlPage = str_replace('%headText%', $headText, $htmlPage);
			$htmlPage = str_replace('%buttonText%', $buttonText, $htmlPage);
			$htmlPage = str_replace('%submitname%', $submitName, $htmlPage);
			$htmlPage = str_replace('%userFirstName%', $userFirstName, $htmlPage);
			$htmlPage = str_replace('%userLastName%', $userLastName, $htmlPage);
		
			$htmlPage = str_replace('%campaignName%', $campaignName, $htmlPage);
			$htmlPage = str_replace('%campaignEmail%', $campaignEmail, $htmlPage);
			$htmlPage = str_replace('%campaignEmailTemplate%', $campaignEmailtemplate, $htmlPage);
			$htmlPage = str_replace('%campaignUrl%', $campaignUrl, $htmlPage);
			$htmlPage = str_replace('%campaignTitle%', $campaignTitle, $htmlPage);
			$htmlPage = str_replace('%campaignDescription%', $campaignDescription, $htmlPage);
			$htmlPage = str_replace('%campaignOwner%', $campaignOwner, $htmlPage);
			
			echo $htmlPage;

		} else {
			if(isset($_POST['editcampaign']))
			{
				$name = trim($_POST['name']);
				$email = trim($_POST['email']);
				$emailtemplate = trim($_POST['emailtemplate']);
				$url = trim($_POST['url']);
				$category = trim($_POST['category']);
				$title = trim($_POST['title']);
				$description = trim($_POST['description']);
				$owner = trim($_POST['owner']);
				$id = $_GET['campaign'];
				$active = $_POST['active'];
				
				if($objUser->update($CustomerID, $name, $email, $emailtemplate, $url, $category, $title, $description, $owner, $id, $active))
				{
					$objUser->redirect('account.php');
				}
			}
			
			$htmlPage = file_get_contents('../html/managecampaign.html');	
			
			$title = 'Edit Campaign';
			$headText = 'Edit a Campaign';
			$buttonText = 'Save Changes';
			$submitName = 'editcampaign';
			
			$campaigns = '<li class="active"><a href="../tool/campaigns.php">Campaigns</a></li>';
			$linksites = '<li><a href="../tool/linksites.php">Linksites</a></li>';
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
			
			
			$getCampaign = ($objCampaign->getCampaign2($_GET['campaign']));
			$campaignName = $getCampaign['name'];
			$campaignEmail = $getCampaign['email'];
			$campaignEmailtemplate = $getCampaign['email_template'];
			$campaignUrl = $getCampaign['url'];
			$campaignCategory = $getCampaign['category'];
			$campaignTitle = $getCampaign['title'];
			$campaignDescription = $getCampaign['description'];
			$campaignOwner = $getCampaign['owner'];
			
			if($campaignCategory == "Business Index")
			{
				$htmlPage = str_replace('%selectedBusinessIndex%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedBusinessIndex%', '', $htmlPage);
			}
			
			if($campaignCategory == "Art and Amusement")
			{
				$htmlPage = str_replace('%selectedArtAndAmusement%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedArtAndAmusement%', '', $htmlPage);
			}
			
			if($campaignCategory == "Automobileindustry")
			{
				$htmlPage = str_replace('%selectedAutomobileindustry%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedAutomobileindustry%', '', $htmlPage);
			}
			
			if($campaignCategory == "Beauty And Fitness")
			{
				$htmlPage = str_replace('%selectedBeautyAndFitness%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedBeautyAndFitness%', '', $htmlPage);
			}
			
			if($campaignCategory == "Books And Literature")
			{
				$htmlPage = str_replace('%selectedBooksAndLiterature%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedBooksAndLiterature%', '', $htmlPage);
			}
			
			if($campaignCategory == "Companies And industry")
			{
				$htmlPage = str_replace('%selectedCompaniesAndIndustry%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedCompaniesAndIndustry%', '', $htmlPage);
			}
			
			if($campaignCategory == "Computers and Electronics")
			{
				$htmlPage = str_replace('%selectedComputersAndElectronics%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedComputersAndElectronics%', '', $htmlPage);
			}
			
			if($campaignCategory == "Financial Services")
			{
				$htmlPage = str_replace('%selectedFinancialServices%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedFinancialServices%', '', $htmlPage);
			}
			
			if($campaignCategory == "Food and Drinks")
			{
				$htmlPage = str_replace('%selectedFoodAndDrinks%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedFoodAndDrinks%', '', $htmlPage);
			}
			
			if($campaignCategory == "Games")
			{
				$htmlPage = str_replace('%selectedGames%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedGames%', '', $htmlPage);
			}
			
			if($campaignCategory == "Healthcare")
			{
				$htmlPage = str_replace('%selectedHealthcare%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedHealthcare%', '', $htmlPage);
			}
			
			if($campaignCategory == "Hobbies")
			{
				$htmlPage = str_replace('%selectedHobbies%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedHobbies%', '', $htmlPage);
			}
			
			if($campaignCategory == "House and Garden")
			{
				$htmlPage = str_replace('%selectedHouseAndGarden%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedHouseAndGarden%', '', $htmlPage);
			}
			
			if($campaignCategory == "Internet and Telecom")
			{
				$htmlPage = str_replace('%selectedInternetAndTelecom%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedInternetAndTelecom%', '', $htmlPage);
			}
			
			if($campaignCategory == "Vacant and Education")
			{
				$htmlPage = str_replace('%selectedVacantAndEducation%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedVacantAndEducation%', '', $htmlPage);
			}
			
			if($campaignCategory == "Law and Government")
			{
				$htmlPage = str_replace('%selectedLawAndGovernment%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedLawAndGovernment%', '', $htmlPage);
			}
			
			if($campaignCategory == "News")
			{
				$htmlPage = str_replace('%selectedNews%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedNews%', '', $htmlPage);
			}
			
			if($campaignCategory == "Online Community")
			{
				$htmlPage = str_replace('%selectedOnlineCommunity%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedOnlineCommunity%', '', $htmlPage);
			}
			
			if($campaignCategory == "People and Society")
			{
				$htmlPage = str_replace('%selectedPeopleAndSociety%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedPeopleAndSociety%', '', $htmlPage);
			}
			
			if($campaignCategory == "Pets and Animal")
			{
				$htmlPage = str_replace('%selectedPetsAndAnimal%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedPetsAndAnimal%', '', $htmlPage);
			}
			
			if($campaignCategory == "Property")
			{
				$htmlPage = str_replace('%selectedProperty%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedProperty%', '', $htmlPage);
			}
			
			if($campaignCategory == "Reference")
			{
				$htmlPage = str_replace('%selectedReference%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedReference%', '', $htmlPage);
			}
			
			if($campaignCategory == "Science")
			{
				$htmlPage = str_replace('%selectedScience%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedScience%', '', $htmlPage);
			}
			
			if($campaignCategory == "Shopping")
			{
				$htmlPage = str_replace('%selectedShopping%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedShopping%', '', $htmlPage);
			}
			
			if($campaignCategory == "Sport")
			{
				$htmlPage = str_replace('%selectedSport%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedSport%', '', $htmlPage);
			}
			
			if($campaignCategory == "Traveling")
			{
				$htmlPage = str_replace('%selectedTraveling%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedTraveling%', '', $htmlPage);
			}
			
			if($campaignCategory == "Other")
			{
				$htmlPage = str_replace('%selectedOtherCategory%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedOtherCategory%', '', $htmlPage);
			}
			
			if($getCampaign['active'] == "0")
			{
				$htmlPage = str_replace('%selectedANo%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedANo%', '', $htmlPage);
			}
			if($getCampaign['active'] == "1")
			{
				$htmlPage = str_replace('%selectedAYes%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedAYes%', '', $htmlPage);
			}
	
			if($getCampaign['bot_enabled'] == "0")
			{
				$htmlPage = str_replace('%selectedABNo%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedABNo%', '', $htmlPage);
			}
			if($getCampaign['bot_enabled'] == "1")
			{
				$htmlPage = str_replace('%selectedABYes%', 'selected', $htmlPage);
			} else {
				$htmlPage = str_replace('%selectedABYes%', '', $htmlPage);
			}

			$CustomerID = $_SESSION['CustomerID'];
			$getLinksites = $objLinksite->getLinksites($CustomerID);

			$angularData = "";
			foreach($getLinksites as $linksite)
			{
				$currentCampaign = $_GET['campaign'];
				$submission = $objSubmission->getSubmission($currentCampaign, $linksite['id']);

				$select = '';
				if($submission === false) {
					$select = '';
				} else {
					$select = 'true';
				}

				$angularData .= '
				{
					"id" : "'.$linksite['id'].'",
					"name" : "'.$linksite['name'].'",
					"state" : "'.$select.'",
				},';
			}
			$htmlPage = str_replace('%angularData%', $angularData, $htmlPage);
			$htmlPage = str_replace('%title%', $title, $htmlPage);
			$htmlPage = str_replace('%headText%', $headText, $htmlPage);
			$htmlPage = str_replace('%buttonText%', $buttonText, $htmlPage);
			$htmlPage = str_replace('%submitname%', $submitName, $htmlPage);
			$htmlPage = str_replace('%userFirstName%', $userFirstName, $htmlPage);
			$htmlPage = str_replace('%userLastName%', $userLastName, $htmlPage);
			$htmlPage = str_replace('%campaign%', $submitName, $htmlPage);
		
			$htmlPage = str_replace('%campaignName%', $campaignName, $htmlPage);
			$htmlPage = str_replace('%campaignEmail%', $campaignEmail, $htmlPage);
			$htmlPage = str_replace('%campaignEmailTemplate%', $campaignEmailtemplate, $htmlPage);
			$htmlPage = str_replace('%campaignUrl%', $campaignUrl, $htmlPage);
			$htmlPage = str_replace('%campaignTitle%', $campaignTitle, $htmlPage);
			$htmlPage = str_replace('%campaignDescription%', $campaignDescription, $htmlPage);
			$htmlPage = str_replace('%campaignOwner%', $campaignOwner, $htmlPage);
			
			echo $htmlPage;
		}
	}
}
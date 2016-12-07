<?php
	
require_once '../config.php';

if(!isset($_SESSION['UserID']) || !$hasPermission->activeUser($_SESSION['UserID']) || !$hasPermission->activeCustomer($_SESSION['CustomerID']))
{
	session_destroy();
	header('Location: ../offline/offline.html');
} else {
	$UserID = $_SESSION['UserID'];
	$permission = $hasPermission->manageUser($UserID);

	if (!$permission) {
		header('HTTP/1.1 403 Forbidden');
		$objUser->redirect('../offline/denied.html');
	} else {
		if ($hasPermission->addCampaign()) {
			if (isset($_POST['addcampaign'])) {
				$CustomerID = $_SESSION['CustomerID'];
				$name = trim($_POST['name']);
				$email = trim($_POST['email']);
				$emailtemplate = trim($_POST['emailtemplate']);
				$url = trim($_POST['url']);
				$category = trim($_POST['category']);
				$title = trim($_POST['title']);
				$description = trim($_POST['description']);
				$owner = trim($_POST['owner']);
				$active = $_POST['active'];
				$bot = $_POST['activebot'];

				$linksiteDATA = Array();
				$linksites = $objLinksite->getLinksites($CustomerID);
				foreach ($linksites as $linksite) {
					if (isset($_POST['enable' . $linksite['id']])) {
						$temp = Array();
						$temp['id'] = $linksite['id'];
						$temp['url'] = $linksite['url'];
						array_push($linksiteDATA, $temp);
					}
				}

				if ($objCampaign->add($CustomerID, $name, $email, $emailtemplate, $url, $category, $title, $description, $owner, $active, $bot, $linksiteDATA)) {
					$objUser->redirect('campaigns.php');
				}
			}

			$htmlPage = file_get_contents('../html/managecampaign.html');

			$title = 'Add Campaign';
			$headText = 'Add a Campaign';
			$buttonText = 'ADD CAMPAIGN';
			$submitName = 'addcampaign';

			$getUser = ($objUser->getUser($_SESSION['UserID']));

			$userFirstName = $getUser['firstname'];
			$userLastName = $getUser['lastname'];

			$campaigns = '<li class="active"><a href="../tool/campaigns.php">Campaigns</a></li>';
			$linksites = '<li><a href="../tool/linksites.php">Linksites</a></li>';
			$moderate = '<li><a href="../tool/moderate.php">Admin</a></li>';
			$htmlPage = str_replace('%campaigns%', $campaigns, $htmlPage);
			$htmlPage = str_replace('%linksites%', $linksites, $htmlPage);
			$htmlPage = str_replace('%admin%', $moderate, $htmlPage);


			$errorDiv = '<div class="alert alert-danger">
				<i class="fa fa-exclamation-triangle"></i> &nbsp; ' . $error . '
			</div>';

			if (empty($error)) {
				$htmlPage = str_replace('%error%', '', $htmlPage);
			} else {
				$htmlPage = str_replace('%error%', $errorDiv, $htmlPage);
			}

			if (empty($emailtemplate)) {
				$htmlPage = str_replace('%emailTemplate%', '', $htmlPage);
			} else {
				$htmlPage = str_replace('%emailTemplate%', $emailTemplatePlaceHolder, $htmlPage);
			}

			if (empty($description)) {
				$htmlPage = str_replace('%description%', '', $htmlPage);
			} else {
				$htmlPage = str_replace('%description%', $descriptionPlaceholder, $htmlPage);
			}


			$htmlPage = str_replace('%title%', $title, $htmlPage);
			$htmlPage = str_replace('%headText%', $headText, $htmlPage);
			$htmlPage = str_replace('%buttonText%', $buttonText, $htmlPage);
			$htmlPage = str_replace('%submitname%', $submitName, $htmlPage);
			$htmlPage = str_replace('%userFirstName%', $userFirstName, $htmlPage);
			$htmlPage = str_replace('%userLastName%', $userLastName, $htmlPage);
			$htmlPage = str_replace('%campaign%', $submitName, $htmlPage);

			$htmlPage = str_replace('%campaignName%', '', $htmlPage);
			$htmlPage = str_replace('%campaignEmail%', '', $htmlPage);
			$htmlPage = str_replace('%campaignEmailTemplate%', '', $htmlPage);
			$htmlPage = str_replace('%campaignUrl%', '', $htmlPage);
			$htmlPage = str_replace('%campaignTitle%', '', $htmlPage);
			$htmlPage = str_replace('%campaignDescription%', '', $htmlPage);
			$htmlPage = str_replace('%campaignOwner%', '', $htmlPage);

			// selected verstoppen
			$htmlPage = str_replace('$selectedBusinessIndex', '', $htmlPage);
			$htmlPage = str_replace('%selectedArtAndAmusement%', '', $htmlPage);
			$htmlPage = str_replace('%selectedAutomobileindustry%', '', $htmlPage);
			$htmlPage = str_replace('%selectedBeautyAndFitness%', '', $htmlPage);
			$htmlPage = str_replace('%selectedBooksAndLiterature%', '', $htmlPage);
			$htmlPage = str_replace('%selectedCompaniesAndIndustry%', '', $htmlPage);
			$htmlPage = str_replace('%selectedComputersAndElectronics%', '', $htmlPage);
			$htmlPage = str_replace('%selectedFinancialServices%', '', $htmlPage);
			$htmlPage = str_replace('%selectedFoodAndDrinks%', '', $htmlPage);
			$htmlPage = str_replace('%selectedGames%', '', $htmlPage);
			$htmlPage = str_replace('%selectedHealthcare%', '', $htmlPage);
			$htmlPage = str_replace('%selectedHobbies%', '', $htmlPage);
			$htmlPage = str_replace('%selectedHouseAndGarden%', '', $htmlPage);
			$htmlPage = str_replace('%selectedInternetAndTelecom%', '', $htmlPage);
			$htmlPage = str_replace('%selectedVacantAndEducation%', '', $htmlPage);
			$htmlPage = str_replace('%selectedLawAndGovernment%', '', $htmlPage);
			$htmlPage = str_replace('%selectedNews%', '', $htmlPage);
			$htmlPage = str_replace('%selectedOnlineCommunity%', '', $htmlPage);
			$htmlPage = str_replace('%selectedPeopleAndSociety%', '', $htmlPage);
			$htmlPage = str_replace('%selectedPetsAndAnimal%', '', $htmlPage);
			$htmlPage = str_replace('%selectedProperty%', '', $htmlPage);
			$htmlPage = str_replace('%selectedReference%', '', $htmlPage);
			$htmlPage = str_replace('%selectedScience%', '', $htmlPage);
			$htmlPage = str_replace('%selectedShopping%', '', $htmlPage);
			$htmlPage = str_replace('%selectedSport%', '', $htmlPage);
			$htmlPage = str_replace('%selectedTraveling%', '', $htmlPage);
			$htmlPage = str_replace('%selectedOtherCategory%', '', $htmlPage);
			$htmlPage = str_replace('%selectedANo%', '', $htmlPage);
			$htmlPage = str_replace('%selectedAYes%', '', $htmlPage);
			$htmlPage = str_replace('%selectedABNo%', '', $htmlPage);
			$htmlPage = str_replace('%selectedABYes%', '', $htmlPage);

			$CustomerID = $_SESSION['CustomerID'];
			$getLinksites = $objLinksite->getLinksites($CustomerID);
			$angularData = "";
			foreach ($getLinksites as $linksite) {
				$angularData .= '
				{
					"id" : "' . $linksite['id'] . '",
					"name" : "' . $linksite['name'] . '",
				},';
			}
			$htmlPage = str_replace('%angularData%', $angularData, $htmlPage);

			echo $htmlPage;
		} else {
			echo 'ERROR: Te veel DIKKE BMWs';
		}
	}
}
<?php
	
require_once '../config.php';

if(!isset($_SESSION['UserID']) || !$hasPermission->activeUser($_SESSION['UserID']) || !$hasPermission->activeCustomer($_SESSION['CustomerID']))
{
	session_destroy();
	header('Location: ../offline/offline.html');
} else {
	if(empty($_GET['campaign'])) {
		header('HTTP/1.1 404 Not Found');
		header('Location: ../offline/notfound.html');
	} else {
		if(!$hasPermission->Campaign($_GET['campaign'], $_SESSION['CustomerID']))
		{
			header('HTTP/1.1 403 Forbidden');
			header('Location: ../offline/denied.html');
		} else {
			$UserID = $_SESSION['UserID'];
			$noSuperUser = !$hasPermission->isSuperuser($UserID);
			
			if($noSuperUser)
			{
				$campaign = $objCampaign->getCampaign($_GET['campaign']);
			
				$CampaignID = $_GET['campaign'];
				$getCampaign = $objCampaign->getCampaign($CampaignID);
				
				$getUser = ($objUser->getUser($_SESSION['UserID']));
				
				$title = 'Viewing Campaign';
				
				$campaigns = '<li class="active"><a href="../tool/campaigns.php">Campaigns</a></li>';
				$linksites = '<li><a href="../tool/linksites.php">Linksites</a></li>';
				$moderate = '';
				
				$userFirstName = $getUser['firstname'];
				$userLastName = $getUser['lastname'];
				
				$htmlPage = file_get_contents('../html/campaign.html');
				
				$htmlPage = str_replace('%title%', $title, $htmlPage);
				$htmlPage = str_replace('%campaigns%', $campaigns, $htmlPage);
				$htmlPage = str_replace('%linksites%', $linksites, $htmlPage);
				$htmlPage = str_replace('%admin%', $moderate, $htmlPage);
				
				$htmlPage = str_replace('%userFirstName%', $userFirstName, $htmlPage);
				$htmlPage = str_replace('%userLastName%', $userLastName, $htmlPage);

				
				$campaignsHtml = "";
				$campaignsHtmlUrl = "";
				$campaignsHtmlEmail = "";
				$campaignsHtmlCategory = "";
				$campaignsHtmlOwner = "";
				$campaignsHtmlTitle = "";
				$campaignshtmlDesc = "";
				$campaignsHtmlEmailTemplate = "";
				
				foreach($getCampaign as $displayCampaign){
					$campaignsHtml .= $displayCampaign['name'];
					$campaignsHtmlUrl = $displayCampaign['url'];
					$campaignsHtmlEmail = $displayCampaign['email'];
					$campaignsHtmlCategory = $displayCampaign['category'];
					$campaignsHtmlOwner = $displayCampaign['owner'];
					$campaignsHtmlTitle = $displayCampaign['title'];
					$campaignshtmlDesc = $displayCampaign['description'];
					$campaignsHtmlEmailTemplate = $displayCampaign['email_template'];
				}
				
				
				$htmlPage = str_replace('%campaignName%', $campaignsHtml, $htmlPage);
				$htmlPage = str_replace('%campaignURL%', $campaignsHtmlUrl, $htmlPage);
				$htmlPage = str_replace('%campaignEmail%', $campaignsHtmlEmail, $htmlPage);
				$htmlPage = str_replace('%campaignCategory%', $campaignsHtmlCategory, $htmlPage);
				$htmlPage = str_replace('%campaignOwner%', $campaignsHtmlOwner, $htmlPage);
				$htmlPage = str_replace('%campaignTitle%', $campaignsHtmlTitle, $htmlPage);
				$htmlPage = str_replace('%campaignDescription%', $campaignshtmlDesc, $htmlPage);
				$htmlPage = str_replace('%campaignEmailTemplate%', $campaignsHtmlEmailTemplate, $htmlPage);

				$saveUrl = '../tool/savesubmissions.php';
				$htmlPage = str_replace('%saveSubmissions%', $saveUrl, $htmlPage);
				
				$CustomerID = $_SESSION['CustomerID'];

				$getSubmissions = $objSubmission->getSubmissions('campaign', $CampaignID);
				$angularData = "";
				foreach($getSubmissions as $submit)
				{
					if($submit['bot_status'] == '0') {
						$tooltip = 'Link not found on website.';
					} else if($submit['bot_status'] == '1') {
						$tooltip = 'Link found on website';
					} else if($submit['bot_status'] == '2') {
						$tooltip = 'Link found on website; Nofollow tag present';
					}


					$historyData = $objHistory->get($submit['id']);
					$htmlHistory = '';
					foreach($historyData as $data) {
						$htmlHistory .= '<a>'.$data['date'].' '.$data['firstname'].' '.$data['lastname'].'<span>'.$data['comment'].'</span></a>';
					}

					$angularData .= '
						{
							"id" : "'.$submit['id'].'",
							"linksites_id" : "'.$submit['linksites_id'].'",
							"name" : "'.$submit['name'].'",
					        "history" : "'.$htmlHistory.'",
					        "rating" : "'.$submit['rating'].'",
					        "comment" : "'.$submit['comment'].'",
					        "linkurl" : "'.$submit['link_url'].'",
					        "status" : "'.$submit['status'].'",
					        "bot_color" : "'.$submit['bot_color'].'",
					        "tooltip" : "'.$tooltip.'"
						},';
				}

				$htmlPage = str_replace('%angularData%', $angularData, $htmlPage);
				
				echo $htmlPage;
				
			} else {
				$campaign = $objCampaign->getCampaign($_GET['campaign']);
			
				$CampaignID = $_GET['campaign'];
				$getCampaign = $objCampaign->getCampaign($CampaignID);

				
				$CustomerID = $_SESSION['CustomerID'];
				$getLinksites = $objLinksite->getLinksites($CustomerID);
				
				$getUser = ($objUser->getUser($_SESSION['UserID']));
				
				$title = 'Viewing Campaign';
				
				$campaigns = '<li class="active"><a href="../tool/campaigns.php">Campaigns</a></li>';
				$linksites = '<li><a href="../tool/linksites.php">Linksites</a></li>';
				$moderate = '<li><a href="../tool/moderate.php">Admin</a></li>';

				$userFirstName = $getUser['firstname'];
				$userLastName = $getUser['lastname'];
				
				$htmlPage = file_get_contents('../html/campaign.html');
				
				$htmlPage = str_replace('%title%', $title, $htmlPage);
				$htmlPage = str_replace('%campaigns%', $campaigns, $htmlPage);
				$htmlPage = str_replace('%linksites%', $linksites, $htmlPage);
				$htmlPage = str_replace('%admin%', $moderate, $htmlPage);
				
				$htmlPage = str_replace('%userFirstName%', $userFirstName, $htmlPage);
				$htmlPage = str_replace('%userLastName%', $userLastName, $htmlPage);
				
				$campaignsHtml = "";
				$campaignsHtmlUrl = "";
				$campaignsHtmlEmail = "";
				$campaignsHtmlCategory = "";
				$campaignsHtmlOwner = "";
				$campaignsHtmlTitle = "";
				$campaignshtmlDesc = "";
				$campaignsHtmlEmailTemplate = "";
				
				foreach($getCampaign as $displayCampaign){
					$campaignsHtml = $displayCampaign['name'];
					$campaignsHtmlUrl = $displayCampaign['url'];
					$campaignsHtmlEmail = $displayCampaign['email'];
					$campaignsHtmlCategory = $displayCampaign['category'];
					$campaignsHtmlOwner = $displayCampaign['owner'];
					$campaignsHtmlTitle = $displayCampaign['title'];
					$campaignshtmlDesc = $displayCampaign['description'];
					$campaignsHtmlEmailTemplate = $displayCampaign['email_template'];
				}

				$htmlPage = str_replace('%campaignName%', $campaignsHtml, $htmlPage);
				$htmlPage = str_replace('%campaignURL%', $campaignsHtmlUrl, $htmlPage);
				$htmlPage = str_replace('%campaignEmail%', $campaignsHtmlEmail, $htmlPage);
				$htmlPage = str_replace('%campaignCategory%', $campaignsHtmlCategory, $htmlPage);
				$htmlPage = str_replace('%campaignOwner%', $campaignsHtmlOwner, $htmlPage);
				$htmlPage = str_replace('%campaignTitle%', $campaignsHtmlTitle, $htmlPage);
				$htmlPage = str_replace('%campaignDescription%', $campaignshtmlDesc, $htmlPage);
				$htmlPage = str_replace('%campaignEmailTemplate%', $campaignsHtmlEmailTemplate, $htmlPage);

				$saveUrl = 'savesubmissions.php?campaign='.$_GET['campaign'].'';
				$htmlPage = str_replace('%saveSubmissions%', $saveUrl, $htmlPage);

				$getSubmissions = $objSubmission->getSubmissions('campaign', $CampaignID);
				$angularData = "";
				foreach($getSubmissions as $submit)
				{
					if($submit['bot_status'] == '0') {
						$tooltip = 'Link not found on website.';
					} else if($submit['bot_status'] == '1') {
						$tooltip = 'Link found on website';
					} else if($submit['bot_status'] == '2') {
						$tooltip = 'Link found on website; Nofollow tag present';
					}


					$historyData = $objHistory->get($submit['id']);
					$htmlHistory = '';
					foreach($historyData as $data) {
						$date = new DateTime($data['date']);
						$date = $date->format('d-m-Y');
						$htmlHistory .= '<a>'.$date.' - '.$data['firstname'].' '.$data['lastname'].'<span>'.$data['comment'].'</span></a>';
					}

					$angularData .= '
						{
							"id" : "'.$submit['id'].'",
							"linksites_id" : "'.$submit['linksites_id'].'",
							"name" : "'.$submit['name'].'",
					        "history" : "'.$htmlHistory.'",
					        "rating" : "'.$submit['rating'].'",
					        "comment" : "'.$submit['comment'].'",
					        "linkurl" : "'.$submit['link_url'].'",
					        "status" : "'.$submit['status'].'",
					        "bot_color" : "'.$submit['bot_color'].'",
					        "tooltip" : "'.$tooltip.'"
						},';
				}
				
				$htmlPage = str_replace('%angularData%', $angularData, $htmlPage);
				
				echo $htmlPage;
			}
		}
	}
}
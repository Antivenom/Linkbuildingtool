<?php

require_once '../config.php';

if (!isset($_SESSION['UserID']) || !$hasPermission->activeUser($_SESSION['UserID']) || !$hasPermission->activeCustomer($_SESSION['CustomerID'])) {
    session_destroy();
    header('Location: ../offline/offline.html');
} else {
    if($hasPermission->addLinksite()) {
        $UserID = $_SESSION['UserID'];
        $superUser = $hasPermission->isSuperUser($UserID);

        if(!$superUser) {
            if (isset($_POST['addlinksite'])) {
                $CustomerID = $_SESSION['CustomerID'];
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

                $campaignIDs = Array();
                $campaigns = $objCampaign->getCampaigns($CustomerID);
                foreach ($campaigns as $campaign) {
                    if (isset($_POST['enable' . $campaign['id']])) {
                        array_push($campaignIDs, $campaign['id']);
                    }
                }


                if ($objLinksite->add($CustomerID, $name, $type, $category, $rating, $comment, $url, $submitpage, $costs, $costs_amount, $backlink, $owner, $owneremail, $campaignIDs)) {
                    $objUser->redirect('linksites.php');
                }
            }

            $htmlPage = file_get_contents('../html/managelinksite.html');

            $title = 'Add Linksite';
            $headText = 'Add a linksite';
            $buttonText = 'ADD LINKSITE';
            $submitName = 'addlinksite';

            $campaigns = '<li><a href="../tool/campaigns.php">Campaigns</a></li>';
            $linksites = '<li class="active"><a href="../tool/linksites.php">Linksites</a></li>';
            $moderate = '';
            $htmlPage = str_replace('%campaigns%', $campaigns, $htmlPage);
            $htmlPage = str_replace('%linksites%', $linksites, $htmlPage);
            $htmlPage = str_replace('%admin%', $moderate, $htmlPage);

            $getUser = ($objUser->getUser($_SESSION['UserID']));

            $userFirstName = $getUser['firstname'];
            $userLastName = $getUser['lastname'];

            $errorDiv = '<div class="alert alert-danger">
				<i class="fa fa-exclamation-triangle"></i> &nbsp; ' . $error . '
			</div>';

            if (empty($error)) {
                $htmlPage = str_replace('%error%', '', $htmlPage);
            } else {
                $htmlPage = str_replace('%error%', $errorDiv, $htmlPage);
            }

            $htmlPage = str_replace('%title%', $title, $htmlPage);
            $htmlPage = str_replace('%headText%', $headText, $htmlPage);
            $htmlPage = str_replace('%ratingValue%', 0, $htmlPage);
            $htmlPage = str_replace('%buttonText%', $buttonText, $htmlPage);
            $htmlPage = str_replace('%submitname%', $submitName, $htmlPage);
            $htmlPage = str_replace('%linksite%', $submitName, $htmlPage);
            $htmlPage = str_replace('%userFirstName%', $userFirstName, $htmlPage);
            $htmlPage = str_replace('%userLastName%', $userLastName, $htmlPage);

            $htmlPage = str_replace('%linksiteName%', '', $htmlPage);
            $htmlPage = str_replace('%linksitePlaceholder%', '', $htmlPage);
            $htmlPage = str_replace('%LinksiteComment%', '', $htmlPage);
            $htmlPage = str_replace('%LinksiteUrl%', '', $htmlPage);
            $htmlPage = str_replace('%LinksiteSubmitPage%', '', $htmlPage);
            $htmlPage = str_replace('%LinksiteOwner%', '', $htmlPage);
            $htmlPage = str_replace('%LinksiteOwnerEmail%', '', $htmlPage);


            $CustomerID = $_SESSION['CustomerID'];
            $getCampaigns = $objCampaign->getCampaigns($CustomerID);
            $angularData = "";
            foreach ($getCampaigns as $campaign) {
                $angularData .= '
				{
					"id" : "' . $campaign['id'] . '",
					"name" : "' . $campaign['name'] . '",
				},';
            }
            $htmlPage = str_replace('%angularData%', $angularData, $htmlPage);

            echo $htmlPage;
        } else {
            if (isset($_POST['addlinksite'])) {
                $CustomerID = $_SESSION['CustomerID'];
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

                $campaignIDs = Array();
                $campaigns = $objCampaign->getCampaigns($CustomerID);
                foreach ($campaigns as $campaign) {
                    if (isset($_POST['enable' . $campaign['id']])) {
                        array_push($campaignIDs, $campaign['id']);
                    }
                }


                if ($objLinksite->add($CustomerID, $name, $type, $category, $rating, $comment, $url, $submitpage, $costs, $costs_amount, $backlink, $owner, $owneremail, $campaignIDs)) {
                    $objUser->redirect('linksites.php');
                }
            }

            $htmlPage = file_get_contents('../html/managelinksite.html');

            $title = 'Add Linksite';
            $headText = 'Add a linksite';
            $buttonText = 'ADD LINKSITE';
            $submitName = 'addlinksite';

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
				<i class="fa fa-exclamation-triangle"></i> &nbsp; ' . $error . '
			</div>';

            if (empty($error)) {
                $htmlPage = str_replace('%error%', '', $htmlPage);
            } else {
                $htmlPage = str_replace('%error%', $errorDiv, $htmlPage);
            }

            $htmlPage = str_replace('%title%', $title, $htmlPage);
            $htmlPage = str_replace('%headText%', $headText, $htmlPage);
            $htmlPage = str_replace('%ratingValue%', 0, $htmlPage);
            $htmlPage = str_replace('%buttonText%', $buttonText, $htmlPage);
            $htmlPage = str_replace('%submitname%', $submitName, $htmlPage);
            $htmlPage = str_replace('%userFirstName%', $userFirstName, $htmlPage);
            $htmlPage = str_replace('%userLastName%', $userLastName, $htmlPage);

            $htmlPage = str_replace('%linksiteName%', '', $htmlPage);
            $htmlPage = str_replace('%linksitePlaceholder%', '', $htmlPage);
            $htmlPage = str_replace('%LinksiteComment%', '', $htmlPage);
            $htmlPage = str_replace('%LinksiteUrl%', '', $htmlPage);
            $htmlPage = str_replace('%LinksiteSubmitPage%', '', $htmlPage);
            $htmlPage = str_replace('%LinksiteOwner%', '', $htmlPage);
            $htmlPage = str_replace('%LinksiteOwnerEmail%', '', $htmlPage);


            $CustomerID = $_SESSION['CustomerID'];
            $getCampaigns = $objCampaign->getCampaigns($CustomerID);
            $angularData = "";
            foreach ($getCampaigns as $campaign) {
                $angularData .= '
				{
					"id" : "' . $campaign['id'] . '",
					"name" : "' . $campaign['name'] . '",
				},';
            }
            $htmlPage = str_replace('%angularData%', $angularData, $htmlPage);

            echo $htmlPage;
        }
    } else {
        echo 'dikke audi';
    }
}
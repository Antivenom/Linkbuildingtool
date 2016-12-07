<?php

require_once '../config.php';

if(!isset($_SESSION['UserID']) || !$hasPermission->activeUser($_SESSION['UserID']) || !$hasPermission->activeCustomer($_SESSION['CustomerID'])){
    header('Location: ../offline/offline.html');
} else {
    $UserID = $_SESSION['UserID'];
    $superUser = $hasPermission->isSuperuser($UserID);
    $noSuperUser = !$hasPermission->isSuperuser($UserID);

    if($noSuperUser)
    {
        $htmlPage = file_get_contents('../html/faq.html');

        $title = 'FAQ';
        $htmlPage = str_replace('%title%', $title, $htmlPage);

        $getUser = ($objUser->getUser($_SESSION['UserID']));
        $userName = ($objUser->getUser($_SESSION['UserID'])['firstname']);
        $userFirstName = $getUser['firstname'];
        $userLastName = $getUser['lastname'];
        $htmlPage = str_replace('%userFirstName%', $userFirstName, $htmlPage);
        $htmlPage = str_replace('%userLastName%', $userLastName, $htmlPage);

        $campaigns = '<li><a href="../tool/campaigns.php">Campaigns</a></li>';
        $linksites = '<li><a href="../tool/linksites.php">Linksites</a></li>';
        $moderate = '<li><a href="../tool/moderate.php">Admin</a></li>';
        $htmlPage = str_replace('%campaigns%', $campaigns, $htmlPage);
        $htmlPage = str_replace('%linksites%', $linksites, $htmlPage);
        $htmlPage = str_replace('%admin%', $moderate, $htmlPage);

        echo $htmlPage;
    } else {
        $htmlPage = file_get_contents('../html/faq.html');

        $title = 'FAQ';
        $htmlPage = str_replace('%title%', $title, $htmlPage);

        $getUser = ($objUser->getUser($_SESSION['UserID']));
        $userName = ($objUser->getUser($_SESSION['UserID'])['firstname']);
        $userFirstName = $getUser['firstname'];
        $userLastName = $getUser['lastname'];
        $htmlPage = str_replace('%userFirstName%', $userFirstName, $htmlPage);
        $htmlPage = str_replace('%userLastName%', $userLastName, $htmlPage);

        $campaigns = '<li><a href="../tool/campaigns.php">Campaigns</a></li>';
        $linksites = '<li><a href="../tool/linksites.php">Linksites</a></li>';
        $moderate = '<li><a href="../tool/moderate.php">Admin</a></li>';
        $htmlPage = str_replace('%campaigns%', $campaigns, $htmlPage);
        $htmlPage = str_replace('%linksites%', $linksites, $htmlPage);
        $htmlPage = str_replace('%admin%', $moderate, $htmlPage);

        echo $htmlPage;
    }
}

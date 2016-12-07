<?php

require_once '../config.php';

if(!isset($_SESSION['UserID']))
{
    header('Location: ../offline/offline.html');
} else {
    $UserID = $_SESSION['UserID'];
    $superUser = $hasPermission->isSuperuser($UserID);
    $noSuperUser = !$hasPermission->isSuperuser($UserID);

    if($noSuperUser)
    {
        // Gets the html file
        $htmlPage = file_get_contents('../html/template.html');

        // Sets & echoes the title of the page
        $title = 'CHANGE THIS';
        $htmlPage = str_replace('%title%', $title, $htmlPage);

        // Gets & echoes the username from the database to display it.
        $getUser = ($user->getUser($_SESSION['UserID']));
        $userName = ($user->getUser($_SESSION['UserID'])['firstname']);
        $userFirstName = $getUser['firstname'];
        $userLastName = $getUser['lastname'];
        $htmlPage = str_replace('%userFirstName%', $userFirstName, $htmlPage);
        $htmlPage = str_replace('%userLastName%', $userLastName, $htmlPage);

        // Sets & echoes the links on the navigation bar
        $campaigns = '<li><a href="../tool/campaigns.php">Campaigns</a></li>';
        $linksites = '<li><a href="../tool/linksites.php">Linksites</a></li>';
        $moderate = '<li><a href="../tool/moderate.php">Admin</a></li>';
        $htmlPage = str_replace('%campaigns%', $campaigns, $htmlPage);
        $htmlPage = str_replace('%linksites%', $linksites, $htmlPage);
        $htmlPage = str_replace('%admin%', $moderate, $htmlPage);

        /*  REPLACE THIS WITH CONTENT */
        /*  REPLACE THIS WITH CONTENT */
        /*  REPLACE THIS WITH CONTENT */
        /*  REPLACE THIS WITH CONTENT */
        /*  REPLACE THIS WITH CONTENT */

        // Echoes the html file it got from the first line.
        echo $htmlPage;
    } else {
        // Gets the html file
        $htmlPage = file_get_contents('../html/template.html');

        // Sets & echoes the title of the page
        $title = 'CHANGE THIS';
        $htmlPage = str_replace('%title%', $title, $htmlPage);

        // Gets & echoes the username from the database to display it.
        $getUser = ($user->getUser($_SESSION['UserID']));
        $userName = ($user->getUser($_SESSION['UserID'])['firstname']);
        $userFirstName = $getUser['firstname'];
        $userLastName = $getUser['lastname'];
        $htmlPage = str_replace('%userFirstName%', $userFirstName, $htmlPage);
        $htmlPage = str_replace('%userLastName%', $userLastName, $htmlPage);

        // Sets & echoes the links on the navigation bar
        $campaigns = '<li><a href="../tool/campaigns.php">Campaigns</a></li>';
        $linksites = '<li><a href="../tool/linksites.php">Linksites</a></li>';
        $moderate = '<li><a href="../tool/moderate.php">Admin</a></li>';
        $htmlPage = str_replace('%campaigns%', $campaigns, $htmlPage);
        $htmlPage = str_replace('%linksites%', $linksites, $htmlPage);
        $htmlPage = str_replace('%admin%', $moderate, $htmlPage);

        /*  REPLACE THIS WITH CONTENT */
        /*  REPLACE THIS WITH CONTENT */
        /*  REPLACE THIS WITH CONTENT */
        /*  REPLACE THIS WITH CONTENT */
        /*  REPLACE THIS WITH CONTENT */

        // Echoes the html file it got from the first line.
        echo $htmlPage;
    }
}

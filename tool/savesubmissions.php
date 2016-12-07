<?php

require_once '../config.php';

if(!isset($_SESSION['UserID']) || !$hasPermission->activeUser($_SESSION['UserID']) || !$hasPermission->activeCustomer($_SESSION['CustomerID'])){
    session_destroy();
    header('Location: ../offline/offline.html');
} else {
    if(empty($_GET['campaign'])) {
        header('HTTP/1.1 404 Not Found');
        header('Location: ../offline/notfound.html');
    } else {
        $userID = $_SESSION['UserID'];
        $campaignID = $_GET['campaign'];

        if(isset($_POST['saveSubmit'])) {
            $status = $_POST['status'];
            $comment = $_POST['comment'];

            $submissionID = 16;

            $objSubmission->update($submissionID, $status, $comment);
            $objHistory->insert($submissionID, $userID, $status, $comment);

            $objUser->redirect('campaign.php?campaign='.$_GET['campaign'].'');
        }
    }
}
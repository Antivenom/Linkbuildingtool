<?php
	
require_once '../config.php';

if(!isset($_SESSION['UserID']) || !$hasPermission->activeUser($_SESSION['UserID']) || !$hasPermission->activeCustomer($_SESSION['CustomerID']))
{
	session_destroy();
	header('Location: ../offline/offline.html');
} else {
	$UserID = $_SESSION['UserID'];
	$noSuperUser = !$hasPermission->isSuperuser($UserID);
	
	if($noSuperUser)
	{
		if(isset($_POST['changepassword']))
		{
			$userID = $_SESSION['UserID'];
			$oldPassword = md5($_POST['oldpassword']);
			$newPassword = md5($_POST['newpassword']);
			$repeatedNewPassword = md5($_POST['newpassword2']);

			if($objUser->changePassword($userID, $oldPassword, $newPassword, $repeatedNewPassword))
			{
				$objUser->redirect('../offline/changed.html');
			} else {
				$objUser->redirect('../offline/denied.html');
			}
		}
		
		$htmlPage = file_get_contents('../html/changepassword.html');
	
		
		$title = 'Change Password';
		$headText = 'Change your password';
		$buttonText = 'CHANGE PASSWORD';
		$submitName = 'changepassword';
		
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
		
		$htmlPage = str_replace('%campaigns%', $campaigns, $htmlPage);
		$htmlPage = str_replace('%linksites%', $linksites, $htmlPage);
		$htmlPage = str_replace('%admin%', $moderate, $htmlPage);
		
		$htmlPage = str_replace('%title%', $title, $htmlPage);
		$htmlPage = str_replace('%headText%', $headText, $htmlPage);
		$htmlPage = str_replace('%buttonText%', $buttonText, $htmlPage);
		$htmlPage = str_replace('%submitname%', $submitName, $htmlPage);
		
		$htmlPage = str_replace('%userFirstName%', $userFirstName, $htmlPage);
		$htmlPage = str_replace('%userLastName%', $userLastName, $htmlPage);
		
		echo $htmlPage;
	} else {
		if(isset($_POST['changepassword']))
		{
			$userID = $_SESSION['UserID'];
			$oldPassword = md5($_POST['oldpassword']);
			$newPassword = md5($_POST['newpassword']);
			$repeatedNewPassword = md5($_POST['newpassword2']);
			
			if($objUser->changePassword($userID, $oldPassword, $newPassword, $repeatedNewPassword))
			{
				$objUser->redirect('../offline/changed.html');
			} else {
				$objUser->redirect('../offline/denied.html');
			}
		}
		
		$htmlPage = file_get_contents('../html/changepassword.html');
		
		$campaigns = '<li><a href="../tool/campaigns.php">Campaigns</span></a></li>';
		$linksites = '<li><a href="../tool/linksites.php">Linksites</a></li>';
		$moderate = '<li><a href="../tool/moderate.php">Admin</a></li>';
		
		$htmlPage = str_replace('%campaigns%', $campaigns, $htmlPage);
		$htmlPage = str_replace('%linksites%', $linksites, $htmlPage);
		$htmlPage = str_replace('%admin%', $moderate, $htmlPage);
		
		$title = 'Change Password';
		$headText = 'Change your password';
		$buttonText = 'CHANGE PASSWORD';
		$submitName = 'changepassword';
		
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
		
		$htmlPage = str_replace('%campaigns%', $campaigns, $htmlPage);
		$htmlPage = str_replace('%linksites%', $linksites, $htmlPage);
		$htmlPage = str_replace('%admin%', $moderate, $htmlPage);
		
		$htmlPage = str_replace('%title%', $title, $htmlPage);
		$htmlPage = str_replace('%headText%', $headText, $htmlPage);
		$htmlPage = str_replace('%buttonText%', $buttonText, $htmlPage);
		$htmlPage = str_replace('%submitname%', $submitName, $htmlPage);
		
		$htmlPage = str_replace('%userFirstName%', $userFirstName, $htmlPage);
		$htmlPage = str_replace('%userLastName%', $userLastName, $htmlPage);
		
		echo $htmlPage;

	}
}
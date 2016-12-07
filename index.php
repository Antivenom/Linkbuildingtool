<?php
	
require_once 'config.php';

if($objUser->isLoggedIn())
{
	$objUser->redirect('tool/index.php');
}

if(isset($_POST['login']))
{
	$strUserMail = $_POST['email'];
	$Password = $_POST['password'];
	
	if($objUser->login($strUserMail, $Password))
	{
		$objUser->redirect('tool/index.php');
	} else {
		$error = 'Sorry, the entered data not match anything within the database.';
	}
}

$title = 'Login';

$htmlPage = file_get_contents('html/login.html');
$htmlPage = str_replace('%title%', $title, $htmlPage);
$errorDiv = '<div class="alert alert-danger">
				<i class="fa fa-exclamation-triangle"></i> &nbsp; '. $error .'
			</div>';
			
if(empty($error))
{
	$htmlPage = str_replace('%error%', '', $htmlPage);
} else {
	$htmlPage = str_replace('%error%', $errorDiv, $htmlPage);
}

echo $htmlPage;
?>
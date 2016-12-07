<?php
require_once '../config.php';


if(isset($_POST['forgot']))
{
    $strUserMail = $_POST['email'];

    if($objUser->forgot($strUserMail))
    {
        $fetchedPass = $objUser->forgot($strUserMail);
        $objUser->changeForgottenPassword($strUserMail);
        $objUser->redirect('../offline/sent.html');
    } else {
        $error = 'Sorry, your email did not match anything in the database.';
    }
}

$htmlPage = file_get_contents('../html/forgot.html');
$title = 'Forgot Password';
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
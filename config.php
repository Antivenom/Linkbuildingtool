<?php
session_start();

$strDB_host = "localhost";
//$strDB_user = "testssit";
$strDB_user = "root";
$strDB_pass = "root";
$strDB_name = "testssit_1";

$cName = session_name("Linkbuildingtool");

try {
    $objDB_con = new PDO("mysql:host={$strDB_host};dbname={$strDB_name}", $strDB_user, $strDB_pass);
    $objDB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}

include_once 'class/user.class.php';
include_once 'class/permission.class.php';
include_once 'class/robin.class.php';
include_once 'class/backup.class.php';
include_once 'class/history.class.php';
include_once 'class/campaign.class.php';
include_once 'class/linksite.class.php';
include_once 'class/submission.class.php';
include_once 'class/customer.class.php';

$objUser = new User($objDB_con);
$objRobin = new Robin($objDB_con);
$objBackup = new Backup();
$objHistory = new History($objDB_con);
$objCampaign = new Campaign($objDB_con);
$objLinksite = new Linksite($objDB_con);
$objSubmission = new Submission($objDB_con);
$hasPermission = new Permission($objDB_con);
$objCustomer = new Customer($objDB_con);
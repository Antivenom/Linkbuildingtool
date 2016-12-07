<?php

require_once '../../config.php';

if(!isset($_SESSION['UserID']) || !$hasPermission->activeUser($_SESSION['UserID']) || !$hasPermission->activeCustomer($_SESSION['CustomerID']))
{
    session_destroy();
    header('Location: ../offline/offline.html');
} else {
    if(!$objUser->Owner($_SESSION['UserID'])) {
        echo 'Permission Denied.';
    } else {
        $htmlPage = file_get_contents('addcustomer.html');
        $htmlPage = str_replace('%formName%', 'addcustomer.php', $htmlPage);

        if(isset($_POST['customer'])) {
            $name = $_POST['name'];
            $address = $_POST['address'];
            $addressnumber = $_POST['addressnumber'];
            $postalcode = $_POST['postalcode'];
            $city = $_POST['city'];
            $country = $_POST['country'];
            $taxnumber = $_POST['taxnumber'];
            $kvknumber = $_POST['kvknumber'];
            $phone = $_POST['phonenumber'];
            $email = $_POST['email'];
            $website = $_POST['website'];
            $active = $_POST['active'];

            if($objCustomer->add($name, $address, $addressnumber, $postalcode, $city, $country, $taxnumber, $kvknumber, $phone, $email, $website, $active)) {
                echo 'Succesfully added a customer.';
            }
        }

        echo $htmlPage;
    }
}


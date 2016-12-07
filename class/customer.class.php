<?php

class Customer
{
    private $db;

    function __construct($objDB_con)
    {
        $this->db = $objDB_con;
    }

    public function add($name, $address, $addressnumber, $postalcode, $city, $country, $taxnumber, $kvknumber, $phonenumber, $email, $website, $active) {
        $stmt = $this->db->prepare("
            INSERT INTO customers(
              name,
              address,
              addressnumber,
              postalcode,
              city,
              country,
              taxnumber,
              kvknumber,
              phonenumber,
              email,
              website,
              active,
            ) VALUES (
              :name,
              :address,
              :postalcode,
              :city,
              :country,
              :taxnumber,
              :kvknumber,
              :phonenumber,
              :email,
              :website,
              :active
            )
        ");

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':addressnumber', $addressnumber);
        $stmt->bindParam(':postalcode', $postalcode);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':taxnumber', $taxnumber);
        $stmt->bindParam(':kvknumber', $kvknumber);
        $stmt->bindParam(':phonenumber', $phonenumber);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':website', $website);
        $stmt->bindParam(':active', $active);
        $stmt->execute();
    }

    public function edit($CustomerID) {

    }

    public function delete($CustomerID) {

    }
}
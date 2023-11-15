<?php

include_once(__DIR__ . '/../db_connection.php');

class Address { 

    public $address_id;
    public $street_address;
    public $city;
    public $province;
    public $postal_code;
    public $country;
    public $userId;
    

    public function __construct($id = -1) {
        global $conn;

        if ($id < 0) {
            // initialize default values
            $this->addressId = -1;
            $this->streetAddress = "";
            $this->city = "";
            $this->province = "";
            $this->postalCode = "";
            $this->country = "";
            $this->userId = 0;
        } else {
            // fetch address details from the database
            $sql = "SELECT * FROM `ADDRESS` WHERE ADDRESS_ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $res = $stmt->get_result();
            $assocAddress = $res->fetch_assoc();

             // set object properties
            $this->addressId = $id;
            $this->streetAddress = $assocAddress['STREET_ADDRESS'];
            $this->city = $assocAddress['CITY'];
            $this->province = $assocAddress['PROVINCE'];
            $this->postalCode = $assocAddress['POSTAL_CODE'];
            $this->country = $assocAddress['COUNTRY'];
            $this->userId = $assocAddress['USER_ID'];

            $stmt->close();
        }
    }

        
    public function getAddressInfo($userId): ?array {
        global $conn;
        $sql = 'SELECT * FROM ADDRESS WHERE USER_ID = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) { // at least one row found
            return $result->fetch_assoc();
        }

        return null;
    }

    //TO ADD: listAddress functions

    public function create($streetAddress, $city, $province, $postalCode, $country, $userId) {
        global $conn;
        $sql = 'INSERT INTO ADDRESS (STREET_ADDRESS, CITY, PROVINCE, POSTAL_CODE, COUNTRY, USER_ID) VALUES (?, ?, ?, ?, ?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssi', $streetAddress, $city, $province, $postalCode, $country, $userId);
        $stmt->execute();
        $insertedAddressId = $stmt->insert_id;
        $stmt->close();

        return $insertedAddressId;
    }

    public function update() {
        global $conn;
        $sql = 'UPDATE ADDRESS SET STREET_ADDRESS = ?, CITY = ?, PROVINCE = ?, POSTAL_CODE = ?, COUNTRY = ? WHERE USER_ID = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssi', $this->streetAddress, $this->city, $this->province, $this->postalCode, $this->country, $this->userId);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function delete() {
        global $conn;
        $sql = 'DELETE FROM ADDRESS WHERE ADDRESS_ID = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $this->addressId);
        $stmt->execute();
        return $stmt->affected_rows;
    }
}

?>
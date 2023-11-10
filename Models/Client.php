<?php

class Client {

    public $user_id;
    public $fname;
    public $lname;
    public $email;
    public $password;
    public $group_id; // client group_id is 1

    // Address information
    public $address_id;
    public $street_address;
    public $city;
    public $province;
    public $postal_code;
    public $country;

    private static $_connection = null;

    public function __construct() {
        if (self::$_connection == null) {
            $host = 'localhost';
            $user = 'root';
            $password = '';
            $dbname = 'shmewelry'; 

            self::$_connection = new mysqli($host, $user, $password, $dbname);

            if (self::$_connection->connect_error) {
                die("Connection failed: " . self::$_connection->connect_error);
            }
        }
    }

    public static function getConnection() {
        return self::$_connection;
    }

    public function getAll() {
        $SQL = 'SELECT * FROM USER WHERE GROUP_ID = 1'; // client group_id is 1
        $result = self::$_connection->query($SQL);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($user_id): ?array {
        $SQL = 'SELECT * FROM USER WHERE USER_ID = ? AND GROUP_ID = 1'; // client group_id is 1
        $stmt = self::$_connection->prepare($SQL);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) { // no rows found
            return $result->fetch_assoc();
        }

        return null;
    }

    public function delete() {
        $SQL = 'DELETE FROM USER WHERE USER_ID = ? AND GROUP_ID = 1'; // client group_id is 1
        $stmt = self::$_connection->prepare($SQL);
        $stmt->bind_param('i', $this->user_id);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function getAddressInfo($user_id): ?array {
        $SQL = 'SELECT * FROM ADDRESS WHERE USER_ID = ?';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) { // at least one row found
            return $result->fetch_assoc();
        }

        return null;
    }

    public function updateAddress() {
        $SQL = 'UPDATE ADDRESS SET STREET_ADDRESS = ?, CITY = ?, PROVINCE = ?, POSTAL_CODE = ?, COUNTRY = ? WHERE USER_ID = ?';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->bind_param('sssssi', $this->street_address, $this->city, $this->province, $this->postal_code, $this->country, $this->user_id);
        $stmt->execute();
        return $stmt->affected_rows;
    }
    
}

?>

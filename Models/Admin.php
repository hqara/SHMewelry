<?php

class AdminModel
{
    private $userId;
    private $groupId;
    private $email;
    private $firstName;
    private $lastName;
    private $password;
    //private $address;

    public function __construct($userId = -1)
    {
        if ($userId < 0)
        {
            $this->userId = -1;
            $this->groupId = 3;
            $this->email = "";
            $this->firstName = "";
            $this->lastName = "";
            $this->password = "";
            //$this->address = ""; // change to address object
        }
        else
        {
            global $conn;
            $sql = "SELECT * FROM USER WHERE
            USER_ID = " . $userId . ";";
            $result = $conn->query($sql);
            $data = $result->fetch_assoc();
            $this->userId = $userId;
            $this->groupId = $data["GROUP_ID"];
            $this->email = $data["EMAIL"];
            $this->firstName = $data["FNAME"];
            $this->lastName = $data["LNAME"];
            $this->password = $data["PASSWORD"];
        }
    }

    public static function listAdmins()
    {
        global $conn;
        $list = array();

        $sql = "SELECT * FROM USER";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc())
        {
            $admin = new AdminModel();
            $admin->userId = $row["USER_ID"];
            $admin->groupId = $row["GROUP_ID"];
            $admin->email = $row["EMAIL"];
            $admin->firstName = $row["FNAME"];
            $admin->lastName = $row["LNAME"];
            $admin->password = $row["PASSWORD"];

            array_push($list, $admin);
        }

        return $list;
    }

    public static function updateAdmin($userId, $groupId, $email, $firstName, $lastName, $password)
    {
        global $conn;

        $userId = (int) $userId;
        $groupId = (int) $groupId;
        $email = $conn->real_escape_string($email);
        $firstName = $conn->real_escape_string($firstName);
        $lastName = $conn->real_escape_string($lastName);
        $password = $conn->real_escape_string($password);

        $sql = "UPDATE USER SET GROUP_ID = '$groupId',
            EMAIL = '$email',
            FNAME = '$firstName',
            LNAME = '$lastName',
            PASSWORD = '$password'";

        if ($conn->query($sql) === TRUE)
        {
            echo "Product record updated successfully";
        }
        else
        {
            echo "Error updating record\n" . $conn->error;
        }
    }

    public static function createAdmin($email, $firstName, $lastName, $password)
    {
        global $conn;

        $email = $conn->real_escape_string($email);
        $firstName = $conn->real_escape_string($firstName);
        $lastName = $conn->real_escape_string($lastName);
        $password = $conn->real_escape_string($password);

        $sql = "INSERT INTO USER (GROUP_ID, EMAIL, FNAME, LNAME, PASSWORD) 
        VALUES (3, '$email', '$firstName', '$lastName', '$password')";

        if ($conn->query($sql) === TRUE)
        {
            echo "User created successfully";
        }
        else
        {
            echo "Error creating admin: \n" . $conn->error;
        }
    }

    public static function delete($userId)
    {
        global $conn;

        $id = (int) $userId;
        $sql = "DELETE FROM USER WHERE USER_ID = $userId";

        if ($conn->query($sql) === TRUE)
        {
            echo "Product deleted successfully";
        }
        else
        {
            echo "There was a problem deleting this user. \n" . $conn->error;
        }
    }

    public static function getOneAdmin($userId)
    {
        global $conn;

        $userId = (int) $userId;
        $sql = "SELECT * FROM USER WHERE USER_ID = $userId";
        $result = $conn->query($sql);

        if ($result->num_rows == 1)
        {
            $data = $result->fetch_assoc();
            $admin = new AdminModel();
            $admin->userId = $data["USER_ID"];
            $admin->groupId = $data["GROUP_ID"];
            $admin->email = $data["EMAIL"];
            $admin->firstName = $data["FNAME"];
            $admin->lastName = $data["LNAME"];
            $admin->password = $data["PASSWORD"];

            return $admin;
        }
        else
        {
            return null;
        }
    }

}

    //hibba's model, but need to review...
    class Admin {

        public $user_id;
        public $fname;
        public $lname;
        public $email;
        public $password;
        public $group_id; 
    
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
            $SQL = 'SELECT * FROM USER WHERE GROUP_ID = 3'; // admin group_id is 3
            $result = self::$_connection->query($SQL);
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    
        public function getById($user_id): ?array {
            $SQL = 'SELECT * FROM USER WHERE USER_ID = ? AND GROUP_ID = 2'; // admin group_id is 3
            $stmt = self::$_connection->prepare($SQL);
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) { // no rows found
                return $result->fetch_assoc();
            }
    
            return null;
        }

        public function create($fname, $lname, $email, $password) {
            $SQL = 'INSERT INTO USER (FNAME, LNAME, EMAIL, PASSWORD, GROUP_ID) VALUES (?, ?, ?, ?, ?)';
            $stmt = self::$_connection->prepare($SQL);
            $stmt->bind_param('ssssi', $fname, $lname, $email, $password, $group_id);
            $stmt->execute();
            return $stmt->insert_id;
        }

        public function update($user_id, $fname, $lname, $email, $password) {
            $SQL = 'UPDATE USER SET FNAME = ?, LNAME = ?, EMAIL = ?, PASSWORD = ?, GROUP_ID = ? WHERE USER_ID = ?';
            $stmt = self::$_connection->prepare($SQL);
            $stmt->bind_param('ssssii', $fname, $lname, $email, $password, $group_id, $user_id);
            $stmt->execute();
            return $stmt->affected_rows;
        }
    
        public function delete($user_id) { 
            $SQL = 'DELETE FROM USER WHERE USER_ID = ?';
            $stmt = self::$_connection->prepare($SQL);
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            return $stmt->affected_rows;
        }

        public function deleteAdmin($user_id) {
            // Check if there is at least one admin with GROUP_ID = 3
            $checkSQL = 'SELECT COUNT(*) as count FROM USER WHERE GROUP_ID = 3';
            $checkResult = self::$_connection->query($checkSQL);
            $count = $checkResult->fetch_assoc()['count'];
            if ($count <= 1) {
               
                return; // Do nothing
            }
            // Allow deletion since there is more than one admin with GROUP_ID = 3
            $deleteSQL = 'DELETE FROM USER WHERE USER_ID = ?';
            $stmt = self::$_connection->prepare($deleteSQL);
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            return $stmt->affected_rows;
        }
    
}


?>
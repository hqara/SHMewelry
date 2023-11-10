<?php

class Moderator {

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
        $SQL = 'SELECT * FROM USER WHERE GROUP_ID = 2'; // mod group_id is 2
        $result = self::$_connection->query($SQL);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($user_id): ?array {
        $SQL = 'SELECT * FROM USER WHERE USER_ID = ? AND GROUP_ID = 2'; // mod group_id is 2
        $stmt = self::$_connection->prepare($SQL);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) { // no rows found
            return $result->fetch_assoc();
        }

        return null;
    }

        
}

?>

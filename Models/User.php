<?php

include_once(__DIR__ . '/../db_connection.php');

class User {

    public $user_id;
    public $fname;
    public $lname;
    public $email;
    public $password;
    public $group_id;

    public function __construct($id = -1) {
        global $conn;

        if ($id < 0) {
             // initialize default values
            $this->user_id = -1;
            $this->fname = "";
            $this->lname = "";
            $this->email = "";
            $this->password = "";
            $this->group_id = 0;
        } else {
            // fetch user details from the database
            $sql = "SELECT * FROM `USER` WHERE USER_ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $res = $stmt->get_result();
            $assocUser = $res->fetch_assoc();

            // set object properties
            $this->user_id = $id;
            $this->fname = $assocUser['FNAME'];
            $this->lname = $assocUser['LNAME'];
            $this->email = $assocUser['EMAIL'];
            $this->password = $assocUser['PASSWORD'];
            $this->group_id = $assocUser['GROUP_ID'];

            $stmt->close();
        }
    }

    public function getAllUsersInfo() {
        global $conn;
        $sql = 'SELECT * FROM USER JOIN `GROUP` ON USER.GROUP_ID = `GROUP`.GROUP_ID';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($user_id): ?array {
        global $conn;
        $sql = 'SELECT * FROM USER WHERE USER_ID = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return null;
    }

    public function getByUserIdandGroup($user_id): ?array {
        global $conn;
        $sql = 'SELECT * FROM USER WHERE USER_ID = ? AND GROUP_ID = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $user_id, $this->group_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return null;
    }

    public function create($fname, $lname, $email, $password, $group_id) { //need update
        global $conn;
        $sql = 'INSERT INTO USER (FNAME, LNAME, EMAIL, PASSWORD, GROUP_ID) VALUES (?, ?, ?, ?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssi', $fname, $lname, $email, $password, $group_id);
        $stmt->execute();
        return $stmt->insert_id;
    }
    

    public function update($group_id, $user_id) {
        global $conn;
        $sql = 'UPDATE USER SET GROUP_ID = ? WHERE USER_ID = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $group_id, $user_id);
        $stmt->execute();
        return $stmt->affected_rows;
    }
    
    public function delete() {
        global $conn;
    
        if ($this->group_id == 3) {
            // Check if there is only one admin left
            $checksql = 'SELECT COUNT(*) as count FROM USER WHERE GROUP_ID = 3';
            $checkResult = $conn->query($checksql);
            $count = $checkResult->fetch_assoc()['count'];
    
            if ($count <= 1) {
                // Do not delete the last admin
                return;
            }
    
            // Delete the admin
            $deletesql = 'DELETE FROM USER WHERE USER_ID = ? AND GROUP_ID = 3';
        } else {
            // Delete a regular user
            $deletesql = 'DELETE FROM USER WHERE USER_ID = ?';
        }
    
        $stmt = $conn->prepare($deletesql);
        $stmt->bind_param('i', $this->user_id);
        $stmt->execute();
        return $stmt->affected_rows;
    }
    
}


 /*



<?php

//DISPLACED MEGANE'S CODE HERE
class Admin
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
            $admin = new Admin();
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

    public static function update($userId, $groupId, $email, $firstName, $lastName, $password)
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
*/


?>

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
            echo "Error creating product: \n" . $conn->error;
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

?>
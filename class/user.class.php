<?php

class User
{
    private $db;

    function __construct($objDB_con)
    {
        $this->db = $objDB_con;
    }

    public function add($CustomerID, $email, $password, $firstname, $lastName, $superUser)
    {
        $hashPassword = md5($password);

        $stmt = $this->db->prepare("
            INSERT INTO users(
                customers_id,
                email,
                password,
                firstname,
                lastname,
                superuser
            ) VALUES (
                :customers_id,
                :email,
                :password,
                :firstname,
                :lastname,
                :superuser
            )
        ");

        $stmt->bindParam(':customers_id', $CustomerID);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashPassword);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastName);
        $stmt->bindParam(':superuser', $superUser);

        $stmt->execute();

        return $stmt;
    }

    public function login($strUserMail, $Password)
    {
        $hasPermission = new Permission($this->db);
        try {
            $stmt = $this->db->prepare("
				SELECT *
				FROM users
				WHERE
					email = :email
			");

            $stmt->execute(array(
                ':email' => $strUserMail
            ));

            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() > 0) {
                if (md5($Password) == $userRow['password']) {
                    if (($hasPermission->activeUser($userRow['id'])) && ($hasPermission->activeCustomer($userRow['customers_id']))) {
                        $_SESSION['UserID'] = $userRow['id'];
                        $_SESSION['CustomerID'] = $userRow['customers_id'];
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function changePassword($userID, $oldPassword, $newPassword, $repeatedNewPassword)
    {
        $stmt = $this->db->prepare("
			SELECT password
			FROM users
			WHERE
				id = :id
		");

        $stmt->bindValue(':id', $userID);
        $stmt->execute();
        $passwordResult = $stmt->fetch(PDO::FETCH_ASSOC);

        $fetchedPass = $passwordResult['password'];

        if ($oldPassword === $fetchedPass) {
            if ($newPassword === $repeatedNewPassword) {
                $stmtChange = $this->db->prepare("
					UPDATE users
					SET
						password = :password
					WHERE
						id = " . $_SESSION['UserID'] . "
				");

                $stmtChange->bindParam(':password', $newPassword);
                $stmtChange->execute();

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function isLoggedIn()
    {
        if (isset($_SESSION['UserID'])) {
            return true;
        } else {
            return false;
        }
    }

    public function redirect($url)
    {
        header("Location: $url");
    }

    public function logout()
    {
        session_destroy();

        unset($_SESSION['UserID']);
        unset($_SESSION['CustomerID']);

        return true;
    }

    public function getUser($UserID)
    {
        $getUser = $this->db->prepare("
			SELECT *
			FROM users
			WHERE
				id = :id
		");

        $getUser->bindParam(':id', $UserID);
        $getUser->execute();
        $User = $getUser->fetch(PDO::FETCH_ASSOC);
        return $User;
    }

    public function getAllUsers($CustomerID)
    {
        $getUsers = $this->db->prepare("
			SELECT *
			FROM users
			WHERE
				customers_id = :customersid
		");

        $getUsers->bindParam(':customersid', $CustomerID);
        $getUsers->execute();

        $fetchedUsers = $getUsers->fetchAll(PDO::FETCH_ASSOC);
        return $fetchedUsers;
    }

    public function delete($UserID)
    {
        $stmt = $this->db->prepare("
			DELETE
			FROM users
			WHERE
				id = :id
		");

        $stmt->bindValue(':id', $UserID);
        $stmt->execute();
    }

    public function update($UserID, $email, $firstname, $lastname, $SuperUser, $active)
    {

        $stmt = $this->db->prepare("
			UPDATE users 
			SET
				email = :email,
				firstname = :firstname,
				lastname = :lastname,
				superuser = :superuser,
				active = :active
			WHERE
				id = :id
		");

        $stmt->bindValue(':id', $UserID);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':firstname', $firstname);
        $stmt->bindValue(':lastname', $lastname);
        $stmt->bindValue(':superuser', $SuperUser);
        $stmt->bindValue(':active', $active);

        $stmt->execute();

        return $stmt;
    }

    public function forgot($email) {
        $stmt = $this->db->prepare("
            SELECT email
            FROM users
            WHERE email = :email
        ");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $fetch = $stmt->fetch(PDO::FETCH_ASSOC);

        if($fetch) {
            $result = implode($fetch);
        } else {
            $result = '';
        }

        return $result;
    }

    public function generateNewPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        return implode($pass);
    }

    public function changeForgottenPassword($email) {
        $password = $this->generateNewPassword();

        $hash = md5($password);
        $message = "Your new password: $password \n";
        $message .= "Please make sure to change your password as soon as you log in.";

        $headers = 'From: webmaster@linkbuildingtool.eu' . "\r\n" .
            'Reply-To: webmaster@linkbuildingtool.eu' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        $stmt = $this->db->prepare("
            UPDATE users
            SET
              password = :password
            WHERE
              email = :email
        ");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hash);
        $stmt->execute();

        mail($email, 'Forgot password', $message, $headers);
    }

    public function Owner($UserID) {
        $stmt = $this->db->prepare("
            SELECT id
            FROM users
            WHERE
            id = :id
        ");

        $stmt->bindParam(':id', $UserID);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result == '13') {
            //return true;
            return 'ik ben 13';
        }
        //return false;
        return 'ik ben niet 13';
    }
}
<?php
require_once 'Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Find user by username
    public function findUserByUsername($username) {
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        // Check if user exists
        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    // Login user
    public function login($username, $password) {
        $row = $this->findUserByUsername($username);

        if ($row == false) return false;

        $hashedPassword = $row->password; // Adjust this according to your database schema
        if ($password == $hashedPassword) {
            return $row;
        } else {
            return false;
        }
    }

    public function setSession($username) {
        $sessionToken = bin2hex(random_bytes(32));
        $this->db->query('UPDATE users SET session_id = :token WHERE username = :username');
        $this->db->bind(':username', $username);
        $this->db->bind(':token', $sessionToken);

        if ($this->db->execute()) {
            return $sessionToken;
        } else {
            return false;
        }
    }

    public function deleteSession($sessionToken) {
        $this->db->query('UPDATE users SET session_id = NULL WHERE session_id = :session_id');
        $this->db->bind(':session_id', $sessionToken);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>

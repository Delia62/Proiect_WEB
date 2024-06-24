<?php

require_once 'Database.php';
require_once 'User.php';

$user = new User();

$sessionToken = $_COOKIE['userSession'] ?? '';

if ($user->deleteSession($sessionToken)) {
    setcookie('userSession', '', time() - 3600, '/');
    echo json_encode(['success' => true, 'message' => 'Logout successful']);
} else {
    echo json_encode(['success' => false, 'message' => 'Logout failed']);
}

?>
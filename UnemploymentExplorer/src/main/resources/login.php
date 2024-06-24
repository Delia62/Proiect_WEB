<?php
require_once './php/Database.php';
require_once './php/user.php';

$user = new User();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if($loggedInUser = $user->login($username, $password)){
    $sessionToken = $user->setSession($username);
    setcookie("userSession", $sessionToken, [
        'expires' => time() + 3600, 
        'path' => '/',
        'secure' => true, 
        'httponly' => true, 
        'samesite' => 'Lax', 
    ]);
    echo json_encode(['success' => true, 'message' => 'Login successful']);
} else {
    
    echo json_encode(['success' => false, 'message' => 'Invalid username or password']);
}
?>

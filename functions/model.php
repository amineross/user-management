<?php
include_once 'security.php';

function dbConnect() {
    $pdo = new PDO('mysql:host=localhost;dbname=user_management', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    return $pdo;
}

function createUser($lastName, $firstName, $address, $userEmail, $userPassword, $passwordConfirmation) {
    $pdo = dbConnect();
    $role = 2; 

    if ($userPassword !== $passwordConfirmation) {
        return "password_mismatch";
    }

    $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ?");
    $stmt->execute([$userEmail]);
    if ($stmt->fetch()) {
        return "email_exists";
    }

    $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, adresse, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$lastName, $firstName, $address, $userEmail, $hashedPassword, $role]);
    return true;
}

function authenticateUser($userEmail, $userPassword) {
    $pdo = dbConnect();
    $stmt = $pdo->prepare("SELECT id, email, password FROM utilisateurs WHERE email = ?");
    $stmt->execute([$userEmail]);
    $user = $stmt->fetch();

    if ($user && password_verify($userPassword, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        return true;
    }
    return "wrong_email_password";
}

function fetchUserDetails($userId) {
    $pdo = dbConnect();
    $stmt = $pdo->prepare("SELECT id, nom, prenom, adresse, email FROM utilisateurs WHERE id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetch();
}

function updateUserDetails($userId, $lastName, $firstName, $address, $userEmail, $userPassword, $passwordConfirmation) {
    $pdo = dbConnect();

    if ($userPassword !== $passwordConfirmation) {
        return "password_mismatch";
    }

    if ($userEmail !== $_SESSION['email']) {
        $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ? AND id != ?");
        $stmt->execute([$userEmail, $userId]);
        if ($stmt->fetch()) {
            return "email_exists";
        }
    }

    $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE utilisateurs SET nom = ?, prenom = ?, adresse = ?, email = ?, password = ? WHERE id = ?");
    $stmt->execute([$lastName, $firstName, $address, $userEmail, $hashedPassword, $userId]);
    $_SESSION['email'] = $userEmail;
    return true;
}

function removeUserAccount($userId) {
    $pdo = dbConnect();
    $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id = ?");
    $stmt->execute([$userId]);
    session_destroy();
}

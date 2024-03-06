<?php

function processRegistration() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check CSRF token
        checkCsrfToken(); 

        // Collect form data
        $lastName = sanitizeInput($_POST['nom']); 
        $firstName = sanitizeInput($_POST['prenom']); 
        $address = sanitizeInput($_POST['adresse']); 
        $userEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); 
        $userPassword = $_POST['password']; 
        $passwordConfirmation = $_POST['confirm_password']; 

        // Validate form data
        $formErrors = validateRegistrationForm($lastName, $firstName, $address, $userEmail, $userPassword, $passwordConfirmation); // Changed function call

        if (!empty($formErrors)) {
            // Pass errors to the form data array
            $formData['errors'] = $formErrors;
            include 'templates/register.php';
        } else {
            // Attempt to register the user
            $registrationError = createUser($lastName, $firstName, $address, $userEmail, $userPassword, $passwordConfirmation); // Changed function name

            if ($registrationError === true) {
                header("Location: index.php?route=signin");
                exit();
            } else {
                // Display errors on the registration page
                $formData['error'] = $registrationError;
                include 'templates/register.php';
            }
        }
    } else {
        include 'templates/register.php';
    }
}

function processLogin() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // CSRF token verification
        checkCsrfToken();

        $userEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $userPassword = $_POST['password']; 

        $loginError = authenticateUser($userEmail, $userPassword);

        if ($loginError === true) {
            header("Location: index.php?route=profile");
            exit();
        } else {
            include 'templates/login.php';
        }
    } else {
        include 'templates/login.php';
    }
}

function processUpdateProfile() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        checkCsrfToken();

        $userId = $_SESSION['user_id']; 
        $lastName = sanitizeInput($_POST['nom']);
        $firstName = sanitizeInput($_POST['prenom']);
        $address = sanitizeInput($_POST['adresse']);
        $userEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $userPassword = $_POST['password'];
        $passwordConfirmation = $_POST['confirm_password'];

        $formErrors = validateRegistrationForm($lastName, $firstName, $address, $userEmail, $userPassword, $passwordConfirmation);

        if (!empty($formErrors)) {
            $formData['errors'] = $formErrors;
            include 'templates/update.php';
        } else {
            $updateError = updateUserDetails($userId, $lastName, $firstName, $address, $userEmail, $userPassword, $passwordConfirmation);

            if ($updateError === true) {
                header("Location: index.php?route=profile");
                exit();
            } else {
                $formData['error'] = $updateError;
                include 'templates/update.php';
            }
        }
    } else {
        include 'templates/update.php';
    }
}

function processAccountClosure() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId = $_SESSION['user_id'];

        checkCsrfToken();

        removeUserAccount($userId);

        session_destroy();

        header("Location: index.php");
        exit();
    }
}

function processLogout() {
    session_destroy();
    header("Location: index.php");
    exit();
}

function showDashboard()
{
    include 'templates/dashboard.php';
}
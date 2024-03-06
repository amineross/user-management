<?php

require 'model.php';
require 'security.php';
require 'service.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function route() {
    try {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            checkCsrfToken(); 
        }

        if (!empty($_GET['route'])) {
            $route = $_GET['route'];

            switch ($route) {
                case 'signup':
                    processRegistration(); 
                    break;
                case 'signin':
                    processLogin(); 
                    break;
                case 'profile':
                    showDashboard(); 
                    break;
                case 'edit':
                    processUpdateProfile(); 
                    break;
                case 'delete':
                    processAccountClosure(); 
                    break;
                case 'signout':
                    processLogout(); 
                    break;
                default:
                    showHomePage(); 
                    break;
            }
        } else {
            showHomePage(); 
        }
    } catch (Exception $e) {

        $errorMsg = $e->getMessage();
        include 'templates/error.php'; 
    }
}

function showHomePage() {
    include 'templates/home.php';
}
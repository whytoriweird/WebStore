<?php
session_start();

try {
    // Check if user is actually logged in
    if (!isset($_SESSION['user_id'])) {
        header('Location: auth.php');
        exit();
    }

    // Clear specific session variables first
    unset($_SESSION['user_id']);
    unset($_SESSION['role']);
    unset($_SESSION['kompaniia_id']);

    // Clear all session data
    session_unset();
    session_destroy();

    // Clear session cookie
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-3600, '/');
    }

    // Redirect with success message
    header('Location: ../index.php?logout=success');
    exit();
    
} catch (Exception $e) {
    // Log error (in production, use proper logging)
    error_log('Logout error: ' . $e->getMessage());
    
    // Redirect with error
    header('Location: ../index.php?error=logout_failed');
    exit();
}
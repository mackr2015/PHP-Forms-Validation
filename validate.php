<?php
/**
 * validate.php - central validation and redirect handler
 * Supports username, email, and password
 * Uses preg_match only
 */

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function validate_form($type, $value)
{
    $validate_email = function($email) {
        if (!isset($email) || trim($email) === '') {
            return "Email field is required.";
        }
        if (!preg_match('/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/', $email)) {
            return "Invalid email format.";
        }
        return true;
    };

    $validate_username = function($username) {
        if (!isset($username) || trim($username) === '') {
            return "Username is required.";
        }
        if (!preg_match('/^[A-Za-z0-9_]{3,20}$/', $username)) {
            return "Username must be 3–20 characters and use only letters, numbers, or _.";
        }
        return true;
    };

    $validate_password = function($password) {
        if (!isset($password) || trim($password) === '') {
            return "Password is required.";
        }
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*[0-9]).{6,}$/', $password)) {
            return "Password must be at least 6 characters long and contain letters and numbers.";
        }
        return true;
    };

    switch ($type) {
        case 'email': return $validate_email($value);
        case 'username': return $validate_username($value);
        case 'password': return $validate_password($value);
        default: return "Unknown validation type: $type";
    }
}

function process_validation($post)
{
    $errors = [];

    $rules = [
        'email' => 'email',
        'username' => 'username',
        'password' => 'password'
    ];

    foreach ($rules as $field => $type) {
        $result = validate_form($type, $post[$field] ?? null);
        if ($result !== true) {
            $errors[$field] = $result;
        }
    }

    if (!empty($errors)) {
        // Store errors and old input in session, redirect back to index.php
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $post;
        header('Location: index.php');
        exit;
    }

    // Success: store username and redirect to dashboard
    $_SESSION['username'] = $post['username'];
    header('Location: dashboard.php');
    exit;
}
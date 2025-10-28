<?php
// controllers/login.php

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Get stored user from session (in real app, use database)
    if (isset($_SESSION['registered_user'])) {
        $storedUser = $_SESSION['registered_user'];
        
        if ($storedUser['username'] === $username && $storedUser['password'] === $password) {
            $_SESSION['user'] = $storedUser;
            $_SESSION['toast'] = [
                'type' => 'success',
                'message' => 'Login successful! Welcome back.'
            ];
            header('Location: /dashboard');
            exit;
        } else {
            $error = 'Invalid username or password. Please try again.';
            $_SESSION['toast'] = [
                'type' => 'error',
                'message' => $error
            ];
        }
    } else {
        $error = 'No account found. Please sign up first.';
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => $error
        ];
    }
}

echo $twig->render('login.twig', ['error' => $error]);
?>
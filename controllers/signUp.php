<?php
// controllers/signup.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Store user in session (in real app, use database)
    $_SESSION['registered_user'] = [
        'username' => $username,
        'email' => $email,
        'password' => $password // In real app, hash this!
    ];
    
    $_SESSION['user'] = $_SESSION['registered_user'];
    $_SESSION['toast'] = [
        'type' => 'success',
        'message' => 'Account created successfully! Welcome to tickHandler.'
    ];
    
    header('Location: /dashboard');
    exit;
}

echo $twig->render('signUp.twig');
?>
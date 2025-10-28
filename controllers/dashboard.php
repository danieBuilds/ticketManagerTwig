<?php
// controllers/dashboard.php

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit;
}

// Initialize tickets in session if not exists
if (!isset($_SESSION['tickets'])) {
    $_SESSION['tickets'] = [];
}

// Handle ticket actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add_ticket') {
        $name = $_POST['ticket_name'] ?? '';
        $desc = $_POST['ticket_desc'] ?? '';
        $status = $_POST['ticket_status'] ?? 'open';
        
        if (empty(trim($name))) {
            $_SESSION['toast'] = [
                'type' => 'error',
                'message' => 'Ticket title cannot be empty'
            ];
        } elseif (empty(trim($desc))) {
            $_SESSION['toast'] = [
                'type' => 'error',
                'message' => 'Ticket description cannot be empty'
            ];
        } else {
            $_SESSION['tickets'][] = [
                'id' => uniqid(),
                'name' => $name,
                'desc' => $desc,
                'status' => $status
            ];
            $_SESSION['toast'] = [
                'type' => 'success',
                'message' => 'Ticket created successfully!'
            ];
        }
    } elseif ($action === 'delete_ticket') {
        $ticketId = $_POST['ticket_id'] ?? '';
        $_SESSION['tickets'] = array_filter($_SESSION['tickets'], function($ticket) use ($ticketId) {
            return $ticket['id'] !== $ticketId;
        });
        $_SESSION['tickets'] = array_values($_SESSION['tickets']); // Re-index array
        $_SESSION['toast'] = [
            'type' => 'success',
            'message' => 'Ticket deleted successfully!'
        ];
    }
    
    header('Location: /dashboard');
    exit;
}

$tickets = $_SESSION['tickets'];
$user = $_SESSION['user'];

// Calculate stats
$totalTickets = count($tickets);
$openTickets = count(array_filter($tickets, fn($t) => $t['status'] === 'open'));
$inProgressTickets = count(array_filter($tickets, fn($t) => $t['status'] === 'in progress'));
$closedTickets = count(array_filter($tickets, fn($t) => $t['status'] === 'closed'));

echo $twig->render('dashboard.twig', [
    'user' => $user,
    'tickets' => $tickets,
    'total_tickets' => $totalTickets,
    'open_tickets' => $openTickets,
    'in_progress_tickets' => $inProgressTickets,
    'closed_tickets' => $closedTickets
]);
?>
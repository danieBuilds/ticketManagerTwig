// public/js/dashboard.js - Dashboard interactions

let currentView = 'dashboard'; // dashboard, tickets, add-ticket
let currentFilter = 'all';

function toggleView() {
    const dashboardView = document.getElementById('dashboard-view');
    const ticketsView = document.getElementById('tickets-view');
    const toggleBtn = document.getElementById('toggle-btn');
    const addTicketView = document.getElementById('add-ticket-view');
    
    if (currentView === 'dashboard') {
        dashboardView.style.display = 'none';
        ticketsView.style.display = 'block';
        addTicketView.style.display = 'none';
        toggleBtn.textContent = 'dashboard';
        currentView = 'tickets';
    } else {
        dashboardView.style.display = 'block';
        ticketsView.style.display = 'none';
        addTicketView.style.display = 'none';
        toggleBtn.textContent = 'tickets';
        currentView = 'dashboard';
    }
}

function showAddTicket() {
    document.getElementById('dashboard-view').style.display = 'none';
    document.getElementById('tickets-view').style.display = 'none';
    document.getElementById('add-ticket-view').style.display = 'block';
    currentView = 'add-ticket';
}

function filterTickets(status) {
    currentFilter = status;
    const tickets = document.querySelectorAll('.ticket-card');
    const buttons = document.querySelectorAll('.sortTickets button');
    
    // Update active button
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Filter tickets
    tickets.forEach(ticket => {
        if (status === 'all' || ticket.dataset.status === status) {
            ticket.style.display = 'block';
        } else {
            ticket.style.display = 'none';
        }
    });
}

function showFullDetails(element) {
    const ticketCard = element.closest('.ticket-card');
    const desc = ticketCard.querySelector('.ticket-desc');
    
    if (desc.style.display === 'none') {
        desc.style.display = 'block';
        ticketCard.classList.add('fullTicket-card');
        element.textContent = 'Hide Details';
    } else {
        desc.style.display = 'none';
        ticketCard.classList.remove('fullTicket-card');
        element.textContent = 'Show Details';
    }
}

function deleteTicket(ticketId) {
    if (confirm('Are you sure you want to delete this ticket?')) {
        document.getElementById('delete-ticket-id').value = ticketId;
        document.getElementById('delete-form').submit();
    }
}

// Check for toast message from server
// document.addEventListener('DOMContentLoaded', function() {
//     // PHP will inject toast data if exists
//     <?php if (isset($_SESSION['toast'])): ?>
//         showToast('<?php echo addslashes($_SESSION['toast']['message']); ?>', '<?php echo $_SESSION['toast']['type']; ?>');
//         <?php unset($_SESSION['toast']); ?>
//     <?php endif; ?>
// });
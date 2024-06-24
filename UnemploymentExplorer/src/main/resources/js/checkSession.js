$(document).ready(function() {
    $.ajax({
        url: '../php/checkSession.php',
        type: 'GET',
        success: function(response) {
            response = JSON.parse(response);
            if (!response.authenticated) {
                // If not authenticated, redirect to login page
                window.location.href = 'login.html';
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
});
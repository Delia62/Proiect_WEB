
document.getElementById('logout-button').addEventListener('click', function() {

    $.ajax({
        url: '../php/logout.php',
        type: 'GET',
        success: function(data) {
            console.log(data);
            window.location.href = 'login.html';
        },
        error: function(error) {
            console.log(error);
        }
    });

});
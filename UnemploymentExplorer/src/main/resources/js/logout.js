
document.getElementById('logout-button1').addEventListener('click', function() {

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


document.getElementById('logout-button2').addEventListener('click', function() {

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
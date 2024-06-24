document.getElementById('login-form').addEventListener('submit', function(e) {
    e.preventDefault();


    

    $.ajax({
        url: '../login.php',
        type: 'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function(response) {
            response = JSON.parse(response);

            if (response.success) {
                window.location.href = 'admin.html';
            } else {
                document.getElementById('error-message').textContent = response.message;
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });


    // const formData = new FormData(this);
    
    // fetch('http://localhost:8081/login.php', {  // Adaptează calea în funcție de configurarea ta
    //     method: 'POST',
    //     body: formData
    // })
    // .then(response => response.json())
    // .then(data => {
    //     if (data.success) {
    //         window.location.href = 'home.html';
    //     } else {
    //         document.getElementById('error-message').textContent = data.message;
    //     }
    // })
    // .catch(error => {
    //     console.error('Error:', error);
    // });
});

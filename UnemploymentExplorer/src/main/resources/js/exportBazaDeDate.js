document.addEventListener('DOMContentLoaded', function() {
    var submitButton = document.getElementById('submitButton');

    submitButton.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default form submission

        document.getElementById('loadingGif').style.display = 'block';

       $.ajax({
            url: '../php/repository/exportDb.php',
            type: 'POST',
            success: function(response) {
                document.getElementById('loadingGif').style.display = 'none'; // Hide the loading GIF

                // Create a Blob from the response
                var blob = new Blob([response], { type: 'application/octet-stream' });
                
                // Create an Object URL for the Blob
                var downloadUrl = URL.createObjectURL(blob);
                
                // Create a temporary anchor element and set its attributes
                var a = document.createElement("a");
                a.href = downloadUrl;
                a.download = "database_backup.sql"; // Set the file name for the download
                
                document.body.appendChild(a); // Append the anchor to the body
                a.click(); // Programmatically click the anchor to trigger the download
                
                document.body.removeChild(a); // Remove the anchor from the body
                URL.revokeObjectURL(downloadUrl); // Cleanup the Object URL
                
            },
            error: function(xhr, status, error) {
                console.error(xhr);
                console.error(status);
                console.error(error);
                document.getElementById('loadingGif').style.display = 'none';
            }
        });
    });
});

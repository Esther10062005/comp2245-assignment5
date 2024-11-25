// Wait for the document to be fully loaded
$(document).ready(() => {
    // Handle 'Lookup' button click
    $('#lookup').click(() => {
        // Get the country input value
        const country = $('#country').val();

        // Send an AJAX GET request to 'world.php'
        $.ajax({
            url: `world.php?country=${country}`, // Request URL with country as a query parameter
            method: 'GET', // HTTP method
        })
        .done(response => {
            // If successful, display the response in the 'result' div
            $('#result').html(response);
        })
        .fail(() => {
            // If an error occurs, show an alert
            alert('Error: Unable to process the request.');
        });
    });

    // Handle 'Lookup Cities' button click
    $('#lookupCities').click(() => {
        // Get the country input value
        const country = $('#country').val();

        // Send an AJAX GET request to 'world.php' with an additional 'lookup=cities' parameter
        $.ajax({
            url: `world.php?country=${country}&lookup=cities`, // Add 'lookup=cities' for cities-specific data
            method: 'GET', // HTTP method
        })
        .done(response => {
            // If successful, display the response in the 'result' div
            $('#result').html(response);
        })
        .fail(() => {
            // If an error occurs, show an alert
            alert('Error: Unable to process the request.');
        });
    });
});

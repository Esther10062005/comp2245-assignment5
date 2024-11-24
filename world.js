document.getElementById('lookup').addEventListener('click', function() {
    console.log('Button clicked!'); // Check if the button click is being captured
    const country = document.getElementById('country').value.trim();
    let url = 'world.php';
    if (country) {
        url += `?country=${encodeURIComponent(country)}`;
    }

    fetch(url)
        .then(response => response.text())
        .then(data => {
            document.getElementById('result').innerHTML = data;
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            document.getElementById('result').innerHTML = 'Error fetching data.';
        });
});

<?php
// Database connection
$host = 'localhost';
$dbname = 'world';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get the country parameter from the GET request
$country = isset($_GET['country']) ? $_GET['country'] : '';

// SQL query to fetch countries using the LIKE operator for partial matching
$query = "SELECT * FROM countries WHERE name LIKE :country";
$stmt = $pdo->prepare($query);
$stmt->execute(['country' => "%$country%"]);

// Fetch results from the query
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display the results
if (count($results) > 0) {
    foreach ($results as $row) {
        echo "<p><strong>Country:</strong> {$row['name']}<br>";
        echo "<strong>Region:</strong> {$row['region']}<br>";
        echo "<strong>Population:</strong> {$row['population']}</p>";
    }
} else {
    echo "<p>No countries found matching '$country'.</p>";
}
?>

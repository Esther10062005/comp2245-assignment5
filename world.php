<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage()); // Use die for immediate script termination if connection fails
}

// Get sanitized input values
$country = $_GET['country'] ?? '';
$lookup = $_GET['lookup'] ?? 'countries';

// Define query based on lookup type
$query = $lookup === 'cities'
    ? "SELECT cities.name, cities.district, cities.population 
       FROM cities 
       JOIN countries ON cities.country_code = countries.code 
       WHERE countries.name LIKE :country"
    : "SELECT name, continent, independence_year, head_of_state 
       FROM countries 
       WHERE name LIKE :country";

$stmt = $conn->prepare($query);
$stmt->execute(['country' => "%$country%"]); // Bind the country parameter for security
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table>
    <thead>
        <tr>
            <?php if ($lookup === 'cities'): ?>
                <th>Name</th>
                <th>District</th>
                <th>Population</th>
            <?php else: ?>
                <th>Country Name</th>
                <th>Continent</th>
                <th>Independence Year</th>
                <th>Head of State</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $row): ?>
            <tr>
                <?php foreach ($row as $value): ?>
                    <td><?= htmlspecialchars($value) ?></td> <!-- Escape output for security -->
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
s
<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Retrieve input parameters
$country = $_GET['country'] ?? '';
$lookup = $_GET['lookup'] ?? 'countries';

// Define queries based on the lookup type
if ($lookup === 'cities') {
    $query = "SELECT cities.name, cities.district, cities.population 
              FROM cities 
              JOIN countries ON cities.country_code = countries.code 
              WHERE countries.name LIKE :country";
} else {
    $query = "SELECT name, continent, independence_year, head_of_state 
              FROM countries 
              WHERE name LIKE :country";
}

// Prepare and execute the query
$stmt = $conn->prepare($query);
$stmt->execute(['country' => "%$country%"]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output the results in an HTML table
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
                    <td><?= htmlspecialchars($value) ?></td> <!-- Escape for security -->
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


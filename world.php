<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage()); // Stop the script if connection fails
}

// Retrieve and sanitize the country input
$country = $_GET['country'] ?? '';
$country = htmlspecialchars($country, ENT_QUOTES, 'UTF-8');

// Prepare the query to fetch Country Name and Continent
$query = "SELECT name, continent FROM countries WHERE name LIKE :country";

$stmt = $conn->prepare($query);
$stmt->execute(['country' => "%$country%"]); // Execute the query with the input
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generate the HTML table
if ($results): // Check if results are not empty
?>
<table>
    <thead>
        <tr>
            <th>Country Name</th>
            <th>Continent</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['continent']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
else:
    echo "<p>No countries match your search.</p>";
endif;
?>

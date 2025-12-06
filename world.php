<?php
header("Content-Type: text/html; charset=UTF-8");

// Read GET parameter
$country = isset($_GET['country']) ? $_GET['country'] : "";

// Database connection
$host = 'localhost';
$username = 'root';
$password = '';  // XAMPP default
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Modify the country parameter for LIKE search
$country = "%$country%";

// Prepare SQL query
$stmt = $conn->prepare("SELECT name, continent, independence_year, head_of_state FROM countries WHERE name LIKE :country");
$stmt->bindParam(":country", $country, PDO::PARAM_STR);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display table
?>
<table border="1">
    <tr>
        <th>Name</th>
        <th>Continent</th>
        <th>Independence Year</th>
        <th>Head of State</th>
    </tr>
    <?php foreach ($results as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['continent']) ?></td>
            <td><?= htmlspecialchars($row['independence_year']) ?></td>
            <td><?= htmlspecialchars($row['head_of_state']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
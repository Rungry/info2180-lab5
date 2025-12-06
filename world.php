<?php
header("Content-Type: text/html; charset=UTF-8");

// Read GET parameter
$country = isset($_GET['country']) ? $_GET['country'] : "";
$lookup = isset($_GET['lookup']) ? $_GET['lookup'] : "";

// Database connection
$host = 'localhost';
$username = 'root';
$password = '';  // XAMPP default
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($lookup === "cities") {

    $search = "%$country%";

    $stmt = $conn->prepare("
        SELECT cities.name AS city, cities.district, cities.population
        FROM cities
        JOIN countries ON countries.code = cities.country_code
        WHERE countries.name LIKE :country
    ");

    $stmt->bindParam(':country', $search, PDO::PARAM_STR);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<table border='1'>
            <tr>
                <th>City</th>
                <th>District</th>
                <th>Population</th>
            </tr>";

    foreach ($results as $row) {
        echo "<tr>
                <td>" . htmlspecialchars($row['city']) . "</td>
                <td>" . htmlspecialchars($row['district']) . "</td>
                <td>" . htmlspecialchars($row['population']) . "</td>
              </tr>";
    }

    echo "</table>";

    exit; // IMPORTANT — stops PHP from running the country query
}


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
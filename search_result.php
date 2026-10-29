<?php
require_once "settings.php";

$conn = mysqli_connect($host, $user, $pwd, $sql_db);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>

    <style>
        table {
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>

<h1>Car Search Results</h1>

<?php
if (isset($_GET['model']) && trim($_GET['model']) !== '') {

    $model = mysqli_real_escape_string($conn, trim($_GET['model']));

    $sql = "SELECT * FROM cars WHERE model LIKE '%$model%'";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {

        echo "<table>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Make</th>";
        echo "<th>Model</th>";
        echo "<th>Price</th>";
        echo "<th>Year</th>";
        echo "</tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . (int)$row['car_id'] . "</td>";
            echo "<td>" . htmlspecialchars($row['make']) . "</td>";
            echo "<td>" . htmlspecialchars($row['model']) . "</td>";
            echo "<td>" . htmlspecialchars($row['price']) . "</td>";
            echo "<td>" . (int)$row['yom'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";

    } elseif ($result) {
        echo "<p>No matching cars found.</p>";
    } else {
        echo "<p>Unable to search cars.</p>";
    }

} else {
    echo "<p>Please enter a model to search.</p>";
}

mysqli_close($conn);
?>

<p><a href="search_form.php">Search Again</a></p>

</body>
</html>

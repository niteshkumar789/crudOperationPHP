<?php
include '../config/db.php';

$result = $conn->query("SELECT * FROM users");

if ($result->num_rows > 0) {
    echo "<h3>Current Employee Table</h3>";
    echo "<table><tr><th>ID</th><th>Name</th><th>Email</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['ID']}</td><td>{$row['NAME']}</td><td>{$row['EMAIL']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>No records found.</p>";
}

$conn->close();
?>

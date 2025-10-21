<?php
include '../config/db.php';

$result = $conn->query("SELECT * FROM users");

// Determine if we are in delete mode to render checkboxes
$isDeleteMode = isset($_GET['mode']) && $_GET['mode'] === 'delete';

if ($result->num_rows > 0) {
    echo "<h3>Current Employee Table" . ($isDeleteMode ? " (Delete Mode)" : "") . "</h3>";
    echo "<table>";
    echo "<tr>";
    if ($isDeleteMode) {
        echo "<th><input type='checkbox' id='selectAll' title='Select All'></th>";
    }
    echo "<th>ID</th><th>Name</th><th>Email</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        if ($isDeleteMode) {
            $id = (int)$row['ID'];
            echo "<td><input type='checkbox' class='rowCheckbox' data-id='" . $id . "'></td>";
        }
        echo "<td>{$row['ID']}</td><td>{$row['NAME']}</td><td>{$row['EMAIL']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    if ($isDeleteMode) {
        echo "<button id='bulkDeleteBtn' style='margin-top:10px;'>Delete Selected</button>";
    }
} else {
    echo "<p>No records found.</p>";
}

$conn->close();
?>

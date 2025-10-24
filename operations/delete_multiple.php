<?php
include '../config/db.php';

if (isset($_POST['ids'])) {
    $ids = $_POST['ids'];
    if (!is_array($ids)) {
        $ids = explode(',', $ids);
    }
    $ids = array_map('intval', $ids);
    $idList = implode(",", $ids);

    // Fetch photo paths before deletion
    $photoResult = $conn->query("SELECT photo FROM users WHERE ID IN ($idList)");
    if ($photoResult->num_rows > 0) {
        while ($row = $photoResult->fetch_assoc()) {
            if (!empty($row['photo']) && file_exists("../" . $row['photo'])) {
                unlink("../" . $row['photo']); // delete actual photo
            }
        }
    }

    // Delete records from database
    $sql = "DELETE FROM users WHERE ID IN ($idList)";
    if ($conn->query($sql)) {
        echo "Selected records and photos deleted successfully!";
    } else {
        echo "Error deleting records: " . $conn->error;
    }
} else {
    echo "No records selected.";
}

$conn->close();
?>

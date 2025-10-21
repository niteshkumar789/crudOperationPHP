<?php
// Handle bulk delete (IDS=[]) or single delete (ID)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../config/db.php';

    if (isset($_POST['IDS']) && is_array($_POST['IDS'])) {
        $ids = array_map('intval', $_POST['IDS']);
        $ids = array_filter($ids, function($v){ return $v > 0; });
        if (count($ids) === 0) {
            echo "No valid IDs provided.";
            $conn->close();
            exit;
        }
        $inClause = implode(',', $ids);
        $sql = "DELETE FROM users WHERE ID IN ($inClause)";
        if ($conn->query($sql)) {
            echo "Deleted " . $conn->affected_rows . " record(s) successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
        $conn->close();
        exit;
    }

    if (isset($_POST['ID'])) {
        $id = (int)$_POST['ID'];
        $sql = "DELETE FROM users WHERE ID=$id";
        echo $conn->query($sql) ? "Deleted Successfully!" : "Error: " . $conn->error;
        $conn->close();
        exit;
    }
}
?>

<form id="deleteForm">
  <h3>Delete Employee</h3>
  <input type="number" name="ID" placeholder="Enter ID to Delete" required><br>
  <button type="submit">Delete</button>
</form>

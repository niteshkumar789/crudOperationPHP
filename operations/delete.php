<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID'])) {
    include '../config/db.php';
    $id = (int)$_POST['ID'];

    $sql = "DELETE FROM users WHERE ID=$id";
    echo $conn->query($sql) ? "Deleted Successfully!" : "Error: " . $conn->error;
    $conn->close();
    exit;
}
?>

<form id="deleteForm">
  <h3>Delete Employee</h3>
  <input type="number" name="ID" placeholder="Enter ID to Delete" required><br>
  <button type="submit">Delete</button>
</form>

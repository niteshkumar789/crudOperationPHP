<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID'])) {
    include '../config/db.php';
    $id = (int)$_POST['ID'];
    $name = $conn->real_escape_string($_POST['NAME']);
    $email = $conn->real_escape_string($_POST['EMAIL']);

    $sql = "UPDATE users SET NAME='$name', EMAIL='$email' WHERE ID=$id";
    echo $conn->query($sql) ? "Updated Successfully!" : "Error: " . $conn->error;
    $conn->close();
    exit;
}
?>

<form id="updateForm">
  <h3>Update Employee</h3>
  <input type="number" name="ID" placeholder="Enter ID" required><br>
  <input type="text" name="NAME" placeholder="New Name" required><br>
  <input type="email" name="EMAIL" placeholder="New Email" required><br>
  <button type="submit">Update</button>
</form>

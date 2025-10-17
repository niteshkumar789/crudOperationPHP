<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['NAME'])) {
    include '../config/db.php';
    $name = $conn->real_escape_string($_POST['NAME']);
    $email = $conn->real_escape_string($_POST['EMAIL']);

    $sql = "INSERT INTO users (NAME, EMAIL) VALUES ('$name', '$email')";
    echo $conn->query($sql) ? "Inserted Successfully!" : "Error: " . $conn->error;
    $conn->close();
    exit;
}
?>

<form id="insertForm">
  <h3>Insert Employee</h3>
  <input type="text" name="NAME" placeholder="Name" required><br>
  <input type="email" name="EMAIL" placeholder="Email" required><br>
  <button type="submit">Insert</button>
</form>
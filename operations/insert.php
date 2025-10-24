<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['NAME'])) {
    $name = $conn->real_escape_string($_POST['NAME']);
    $email = $conn->real_escape_string($_POST['EMAIL']);
    $photoPath = NULL;

    // Handle photo upload
    if (isset($_FILES['PHOTO']) && $_FILES['PHOTO']['error'] === 0) {
        $uploadDir = '../empPhotos/';
        $filename = time() . '_' . basename($_FILES['PHOTO']['name']);
        $targetFile = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['PHOTO']['tmp_name'], $targetFile)) {
            $photoPath = "empPhotos/$filename"; // store relative path in DB
        }
    }

    $sql = "INSERT INTO users (NAME, EMAIL, photo) VALUES ('$name', '$email', " . ($photoPath ? "'$photoPath'" : "NULL") . ")";
    echo $conn->query($sql) ? "Inserted successfully!" : "Error: " . $conn->error;
    $conn->close();
    exit;
}
?>

<form id="insertForm" enctype="multipart/form-data">
  <h3>Insert Employee</h3>
  <input type="text" name="NAME" placeholder="Name" required><br>
  <input type="email" name="EMAIL" placeholder="Email" required><br>
  <input type="file" name="PHOTO" accept="image/*" id="insertPhoto"><br>
  <img id="insertPreview" src="" alt="Photo Preview" style="display:none; width:80px; height:80px; margin-top:5px;"><br>
  <button type="submit">Insert</button>
</form>


<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID'])) {
    $id = (int)$_POST['ID'];
    $name = $conn->real_escape_string($_POST['NAME']);
    $email = $conn->real_escape_string($_POST['EMAIL']);

    $photoPath = NULL;
    if (isset($_FILES['PHOTO']) && $_FILES['PHOTO']['error'] === 0) {
        $uploadDir = '../empPhotos/';
        $filename = time() . '_' . basename($_FILES['PHOTO']['name']);
        $targetFile = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['PHOTO']['tmp_name'], $targetFile)) {
            $photoPath = "empPhotos/$filename";
        }
    }

    $sql = "UPDATE users SET NAME='$name', EMAIL='$email'" . ($photoPath ? ", photo='$photoPath'" : "") . " WHERE ID=$id";
    echo $conn->query($sql) ? "Updated successfully!" : "Error: " . $conn->error;
    $conn->close();
    exit;
}
?>

<form id="updateForm" enctype="multipart/form-data">
  <h3>Update Employee</h3>
  <input type="number" name="ID" placeholder="Enter ID" required><br>
  <input type="text" name="NAME" placeholder="New Name" required><br>
  <input type="email" name="EMAIL" placeholder="New Email" required><br>
  <input type="file" name="PHOTO" accept="image/*" id="updatePhoto"><br>
  <img id="updatePreview" src="" alt="Photo Preview" style="display:none; width:80px; height:80px; margin-top:5px;"><br>
  <button type="submit">Update</button>
</form>


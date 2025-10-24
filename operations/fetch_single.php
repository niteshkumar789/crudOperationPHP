<?php
include '../config/db.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $result = $conn->query("SELECT * FROM users WHERE ID=$id");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <form id="updateForm" enctype="multipart/form-data">
            <h3>Update Employee</h3>
            <input type="hidden" name="ID" value="<?= $row['ID'] ?>">
            <input type="text" name="NAME" placeholder="Name" value="<?= htmlspecialchars($row['NAME']) ?>" required><br>
            <input type="email" name="EMAIL" placeholder="Email" value="<?= htmlspecialchars($row['EMAIL']) ?>" required><br>
            <input type="file" name="PHOTO" accept="image/*" id="updatePhoto"><br>
            <img id="updatePreview" src="<?= $row['photo'] ?: '' ?>" 
                 alt="Photo Preview" 
                 style="width:80px; height:80px; margin-top:5px; <?= $row['photo'] ? '' : 'display:none;' ?>"><br>
            <button type="submit">Update</button>
        </form>
        <?php
    } else {
        echo "Employee not found.";
    }
}
$conn->close();
?>

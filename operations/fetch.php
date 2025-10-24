<?php
include '../config/db.php';

$result = $conn->query("SELECT * FROM users");

if ($result->num_rows > 0) {
  echo "<h3>Current Employee Table</h3>";
  echo "<form id='multiDeleteForm'>";
  echo "<table>
        <tr>
          <th><input type='checkbox' id='selectAll'> Select All</th>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Photo</th>
          <th>Action</th> <!-- changed from empty to 'Action' -->
        </tr>";

  while ($row = $result->fetch_assoc()) {
    $photo = $row['photo'] ? "<img src='{$row['photo']}' width='50' height='50'>" : "No Photo";
    echo "<tr>
            <td><input type='checkbox' class='recordCheckbox' name='ids[]' value='{$row['ID']}'></td>
            <td>{$row['ID']}</td>
            <td>{$row['NAME']}</td>
            <td>{$row['EMAIL']}</td>
            <td>$photo</td>
            <td><button type='button' class='editBtn' data-id='{$row['ID']}'>Edit</button></td>
          </tr>";
  }


  echo "</table>
        <br>
        <button type='submit'>Delete Selected</button>
        </form>";
} else {
  echo "<p>No records found.</p>";
}
$conn->close();
?>

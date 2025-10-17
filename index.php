<!DOCTYPE html>
<html>
<head>
  <title>Employee Management System</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="public/js/app.js"></script>
  <style>
    body { font-family: Arial; margin: 40px; }
    select, input, button { margin: 5px; }
    table, th, td { border: 1px solid #ccc; border-collapse: collapse; padding: 8px; }
    table { margin-top: 20px; width: 60%; }
    .message { color: green; margin: 10px 0; }
  </style>
</head>
<body>
  <h2>Employee Management System</h2>

  <label>Select Operation:</label>
  <select id="operation">
    <option value="insert">Insert</option>
    <option value="update">Update</option>
    <option value="delete">Delete</option>
  </select>
  <button id="goBtn">Go</button>

  <div id="operationArea"></div> <!-- Form will appear here -->
  <div id="tableArea"></div>     <!-- Table will appear here -->

</body>
</html>


<?php
if (isset($_POST['action'])) {
  switch ($_POST['action']) {
    case 'insert':
      include 'operations/insert.php';
      break;
    case 'update':
      include 'operations/update.php';
      break;
    case 'delete':
      include 'operations/delete.php';
      break;
    default:
      echo "<p>Invalid operation.</p>";
  }
  exit;
}
?>



<!-- Flow Summary
    - User selects an operation (insert/update/delete).
    - index.php switch-case loads respective form dynamically.
    - AJAX submits to the corresponding operation file.
    - Table updates dynamically after each operation. 
-->

<!-- NiteshPHP/
    ├── index.php
    ├── public/
    │   └── js/
    │       └── app.js
    ├── operations/
    │   ├── insert.php
    │   ├── update.php
    │   ├── delete.php
    │   └── fetch.php
    └── config/
        └── db.php 
-->

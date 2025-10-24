<!DOCTYPE html>
<html>
<head>
  <title>Employee Management System</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="public/js/app.js"></script>
  <style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    select, input, button { margin: 5px; padding: 5px; }
    table { border-collapse: collapse; margin-top: 20px; width: 65%; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    .message { margin: 10px 0; color: green; font-weight: bold; }
    .form-section { margin-top: 20px; } 
  </style>
</head>
<body>
  <h2>Employee Management System</h2>

  <label>Select Operation:</label>
  <select id="operation">
    <option value="insert">Insert</option>
    <option value="update">Update</option>
  </select>
  <button id="goBtn">Go</button>

  <div class="form-section" id="operationArea"></div>
  <div id="tableArea"></div>
</body>
</html>

<!--
    crudOperationPHP/
    │
    ├── index.php
    ├── config/
    │   └── db.php
    │
    ├── public/
    │   └── js/
    │       └── app.js
    │
    ├── operations/
    │   ├── router.php       ← single entry point for all operations
    │   ├── fetch.php
    │   ├── insert.php
    │   ├── update.php
    │   ├── delete.php
    │   └── delete_multiple.php
    │
    └── empPhotos (storing photos)
-->

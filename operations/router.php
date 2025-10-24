<?php
if (!isset($_POST['action']) && !isset($_GET['action'])) {
  echo "No action provided.";
  exit;
}

$action = $_POST['action'] ?? $_GET['action'];

switch ($action) {
  case 'fetch':
    include 'fetch.php';
    break;
  case 'insert':
    include 'insert.php';
    break;
  case 'update':
    include 'update.php';
    break;
  case 'delete_multiple':
    include 'delete_multiple.php';
    break;
  default:
    echo "Invalid action.";
}
?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require "db.php";

$message  = "";
$msgClass = "";

$id = intval($_GET["id"] ?? 0);

if ($id) {
    $stmt = $conn->prepare("DELETE FROM employees WHERE emp_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows === 1) {
            $message  = "Employee ID $id deleted. Rows affected: " . $stmt->affected_rows;
            $msgClass = "success";
        } else {
            $message  = "No record found with ID $id.";
            $msgClass = "error";
        }
    } else {
        $message  = "Error: " . $stmt->error;
        $msgClass = "error";
    }
    $stmt->close();
} else {
    $message  = "Invalid ID provided.";
    $msgClass = "error";
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delete Employee — CW-06</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="demo-page">
  <div class="demo-shell">

    <header class="demo-header">
      <h1>Delete Employee</h1>
      <p class="demo-tagline">DELETE — Remove a record using a prepared statement with WHERE</p>
    </header>

    <div class="demo-card">
      <div class="demo-msg <?= htmlspecialchars($msgClass) ?>" style="margin-bottom:1rem;">
        <?= htmlspecialchars($message) ?>
      </div>
      <div class="demo-actions">
        <a class="demo-btn" href="read_employees.php">Back to All Records</a>
        <a class="demo-btn demo-btn-outline" href="employee_demo.php">Add New Employee</a>
      </div>
    </div>

    <footer class="demo-footer">
      CW-06 &mdash; MySQL + PHP &mdash; GSU &mdash; <?= date('Y') ?>
    </footer>
  </div>
</body>
</html>

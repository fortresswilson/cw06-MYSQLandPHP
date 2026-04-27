<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require "db.php";

$message = "";
$msgClass = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name   = trim($_POST["emp_name"] ?? "");
    $job    = trim($_POST["job_name"] ?? "");
    $salary = trim($_POST["salary"] ?? "");
    $hire   = trim($_POST["hire_date"] ?? "");
    $deptId = intval($_POST["department_id"] ?? 0);
    $dept   = trim($_POST["department_name"] ?? "");

    if ($name && $job && $salary && $hire && $deptId && $dept) {
        $stmt = $conn->prepare(
            "INSERT INTO employees (emp_name, job_name, salary, hire_date, department_id, department_name)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("ssdsid", $name, $job, $salary, $hire, $deptId, $dept);

        if ($stmt->execute()) {
            $message  = "Success! Employee added. Inserted ID: " . $stmt->insert_id;
            $msgClass = "success";
        } else {
            $message  = "Error: " . $stmt->error;
            $msgClass = "error";
        }
        $stmt->close();
    } else {
        $message  = "Please fill in all fields.";
        $msgClass = "error";
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee Demo — CW-06</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="demo-page">
  <div class="demo-shell">

    <header class="demo-header">
      <h1>CW-06 Employee Portal</h1>
      <p class="demo-tagline">PHP + MySQL CRUD Demo &mdash; GSU Web Pro</p>
    </header>

    <div class="demo-card">
      <h2 class="demo-title">Add New Employee</h2>
      <p class="demo-subtitle">All fields are required. Data is saved using prepared statements.</p>

      <form method="POST" action="employee_demo.php">
        <div class="demo-grid">

          <div class="demo-field">
            <label for="emp_name">Full Name</label>
            <input class="demo-input" type="text" id="emp_name" name="emp_name"
                   placeholder="e.g. Ana Lopez" required>
          </div>

          <div class="demo-field">
            <label for="job_name">Job Title</label>
            <input class="demo-input" type="text" id="job_name" name="job_name"
                   placeholder="e.g. Developer" required>
          </div>

          <div class="demo-field">
            <label for="salary">Salary ($)</label>
            <input class="demo-input" type="number" id="salary" name="salary"
                   step="0.01" min="0" placeholder="e.g. 73000.00" required>
          </div>

          <div class="demo-field">
            <label for="hire_date">Hire Date</label>
            <input class="demo-input" type="date" id="hire_date" name="hire_date" required>
          </div>

          <div class="demo-field">
            <label for="department_id">Department ID</label>
            <input class="demo-input" type="number" id="department_id" name="department_id"
                   min="1" placeholder="e.g. 3" required>
          </div>

          <div class="demo-field">
            <label for="department_name">Department Name</label>
            <input class="demo-input" type="text" id="department_name" name="department_name"
                   placeholder="e.g. Marketing" required>
          </div>

        </div>

        <div class="demo-actions">
          <button class="demo-btn" type="submit">Add Employee</button>
          <a class="demo-btn demo-btn-outline" href="read_employees.php">View All Records</a>
        </div>

        <?php if ($message): ?>
          <div class="demo-msg <?= htmlspecialchars($msgClass) ?>">
            <?= htmlspecialchars($message) ?>
          </div>
        <?php endif; ?>

      </form>
    </div>

    <footer class="demo-footer">
      CW-06 &mdash; MySQL + PHP &mdash; GSU &mdash; <?= date('Y') ?>
    </footer>
  </div>
</body>
</html>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require "db.php";

$message  = "";
$msgClass = "";
$row      = null;

// Get the ID from the URL
$id = intval($_GET["id"] ?? 0);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id     = intval($_POST["emp_id"] ?? 0);
    $name   = trim($_POST["emp_name"] ?? "");
    $job    = trim($_POST["job_name"] ?? "");
    $salary = trim($_POST["salary"] ?? "");
    $hire   = trim($_POST["hire_date"] ?? "");
    $deptId = intval($_POST["department_id"] ?? 0);
    $dept   = trim($_POST["department_name"] ?? "");

    if ($id && $name && $job && $salary && $hire && $deptId && $dept) {
        $stmt = $conn->prepare(
            "UPDATE employees
             SET emp_name=?, job_name=?, salary=?, hire_date=?, department_id=?, department_name=?
             WHERE emp_id=?"
        );
        $stmt->bind_param("ssdsidi", $name, $job, $salary, $hire, $deptId, $dept, $id);

        if ($stmt->execute()) {
            $message  = "Updated! Rows affected: " . $stmt->affected_rows;
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

// Fetch current data to pre-fill form
if ($id) {
    $stmt = $conn->prepare("SELECT * FROM employees WHERE emp_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row    = $result->fetch_assoc();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Employee — CW-06</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="demo-page">
  <div class="demo-shell">

    <header class="demo-header">
      <h1>Update Employee</h1>
      <p class="demo-tagline">UPDATE — Edit an existing record using a prepared statement</p>
    </header>

    <div class="demo-card">
      <?php if ($row): ?>
        <h2 class="demo-title">Editing: <?= htmlspecialchars($row['emp_name']) ?></h2>
        <form method="POST" action="update_employee.php">
          <input type="hidden" name="emp_id" value="<?= (int)$row['emp_id'] ?>">
          <div class="demo-grid">

            <div class="demo-field">
              <label>Full Name</label>
              <input class="demo-input" type="text" name="emp_name"
                     value="<?= htmlspecialchars($row['emp_name']) ?>" required>
            </div>

            <div class="demo-field">
              <label>Job Title</label>
              <input class="demo-input" type="text" name="job_name"
                     value="<?= htmlspecialchars($row['job_name']) ?>" required>
            </div>

            <div class="demo-field">
              <label>Salary ($)</label>
              <input class="demo-input" type="number" name="salary" step="0.01"
                     value="<?= htmlspecialchars($row['salary']) ?>" required>
            </div>

            <div class="demo-field">
              <label>Hire Date</label>
              <input class="demo-input" type="date" name="hire_date"
                     value="<?= htmlspecialchars($row['hire_date']) ?>" required>
            </div>

            <div class="demo-field">
              <label>Department ID</label>
              <input class="demo-input" type="number" name="department_id"
                     value="<?= htmlspecialchars($row['department_id']) ?>" required>
            </div>

            <div class="demo-field">
              <label>Department Name</label>
              <input class="demo-input" type="text" name="department_name"
                     value="<?= htmlspecialchars($row['department_name']) ?>" required>
            </div>

          </div>
          <div class="demo-actions">
            <button class="demo-btn" type="submit">Save Changes</button>
            <a class="demo-btn demo-btn-outline" href="read_employees.php">Cancel</a>
          </div>

          <?php if ($message): ?>
            <div class="demo-msg <?= htmlspecialchars($msgClass) ?>">
              <?= htmlspecialchars($message) ?>
            </div>
          <?php endif; ?>
        </form>
      <?php else: ?>
        <p class="demo-subtitle">Employee not found. <a class="demo-link" href="read_employees.php">Go back</a></p>
      <?php endif; ?>
    </div>

    <footer class="demo-footer">
      CW-06 &mdash; MySQL + PHP &mdash; GSU &mdash; <?= date('Y') ?>
    </footer>
  </div>
</body>
</html>
<?php $conn->close(); ?>

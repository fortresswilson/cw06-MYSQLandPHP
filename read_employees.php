<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require "db.php";

$result = $conn->query("SELECT * FROM employees ORDER BY emp_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Employees — CW-06</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="demo-page">
  <div class="demo-shell">

    <header class="demo-header">
      <h1>Employee Records</h1>
      <p class="demo-tagline">READ — Displaying all rows from the employees table</p>
    </header>

    <div class="demo-card">
      <div class="demo-actions" style="margin-bottom:1rem;">
        <a class="demo-btn" href="employee_demo.php">+ Add Employee</a>
      </div>

      <?php if ($result && $result->num_rows > 0): ?>
        <div class="table-wrap">
          <table class="emp-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Job</th>
                <th>Salary</th>
                <th>Hire Date</th>
                <th>Dept ID</th>
                <th>Department</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td><?= htmlspecialchars($row['emp_id']) ?></td>
                  <td><?= htmlspecialchars($row['emp_name']) ?></td>
                  <td><?= htmlspecialchars($row['job_name']) ?></td>
                  <td>$<?= htmlspecialchars(number_format($row['salary'], 2)) ?></td>
                  <td><?= htmlspecialchars($row['hire_date']) ?></td>
                  <td><?= htmlspecialchars($row['department_id']) ?></td>
                  <td><?= htmlspecialchars($row['department_name']) ?></td>
                  <td class="action-cell">
                    <a href="update_employee.php?id=<?= (int)$row['emp_id'] ?>" class="demo-link">Edit</a>
                    &nbsp;|&nbsp;
                    <a href="delete_employee.php?id=<?= (int)$row['emp_id'] ?>"
                       class="demo-link danger"
                       onclick="return confirm('Delete this employee?')">Del</a>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <p class="demo-subtitle">No employee records found. <a class="demo-link" href="employee_demo.php">Add one now.</a></p>
      <?php endif; ?>
    </div>

    <footer class="demo-footer">
      CW-06 &mdash; MySQL + PHP &mdash; GSU &mdash; <?= date('Y') ?>
    </footer>
  </div>
</body>
</html>
<?php $conn->close(); ?>

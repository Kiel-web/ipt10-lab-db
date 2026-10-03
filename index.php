<?php
require_once 'db_connect.php';


$sql = 'SELECT id, first_name, last_name, email, enrolment_date 
        FROM students 
        ORDER BY enrolment_date DESC, id DESC';

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Records (mysqli)</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>All Student Records</h2>
        <a href="create.php" class="btn btn-primary">+ Add New Student</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Enrolled</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><small class="text-muted"><?= htmlspecialchars($row['id']) ?></small></td>
                        <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['enrolment_date']) ?></td>
                        <td>
                            <a href="view.php?id=<?= urlencode($row['id']) ?>" class="btn btn-sm btn-info text-white">View</a>
                            <a href="edit.php?id=<?= urlencode($row['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="delete.php?id=<?= urlencode($row['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
<?php

mysqli_free_result($result);
$conn->close();
?>
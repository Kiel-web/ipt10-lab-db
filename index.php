<?php
require_once 'config.php';

$sql = 'SELECT id, first_name, last_name, email, enrolment_date FROM students ORDER BY enrolment_date DESC, id DESC';
$rows = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Students (PDO)</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body class="section">
<div class="container">
    <div class="level">
        <h1 class="title">All Student Records (PDO)</h1>
        <a href="create.php" class="button is-primary">Add New Student</a>
    </div>
    <table class="table is-fullwidth is-striped is-hoverable">
        <thead>
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Enrolled</th><th>Actions</th></tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['enrolment_date']) ?></td>
                <td>
                    <a class="button is-small is-info" href="view.php?id=<?= urlencode($row['id']) ?>">View</a>
                    <a class="button is-small is-warning" href="edit.php?id=<?= urlencode($row['id']) ?>">Edit</a>
                    <a class="button is-small is-danger" href="delete.php?id=<?= urlencode($row['id']) ?>">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
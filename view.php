<?php
require_once 'config.php';

$id = trim($_GET['id'] ?? '');
if ($id === '') { die('Invalid student ID'); }

$stmt = $pdo->prepare('SELECT id, first_name, middle_name, last_name, birthday, sex, email, student_number, program, enrolment_date, created_at FROM students WHERE id = ?');
$stmt->execute([$id]);
$row = $stmt->fetch();

if (!$row) { die('Student not found.'); }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>View Student (PDO)</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body class="section">
<div class="container box" style="max-width: 600px;">
    <h2 class="title is-4">Student Details (PDO)</h2>
    <p><strong>Student ID:</strong> <?= htmlspecialchars($row['id']) ?></p>
    <p><strong>Full Name:</strong> <?= htmlspecialchars(trim($row['first_name'] . ' ' . ($row['middle_name'] ?? '') . ' ' . $row['last_name'])) ?></p>
    <p><strong>Birthday:</strong> <?= htmlspecialchars($row['birthday']) ?></p>
    <p><strong>Sex:</strong> <?= htmlspecialchars($row['sex']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
    <p><strong>Student Number:</strong> <?= htmlspecialchars($row['student_number']) ?></p>
    <p><strong>Program:</strong> <?= htmlspecialchars($row['program']) ?></p>
    <p><strong>Enrolment Date:</strong> <?= htmlspecialchars($row['enrolment_date']) ?></p>
    <p><strong>Created At:</strong> <?= htmlspecialchars($row['created_at']) ?></p>
    <br>
    <a href="index.php" class="button is-link is-light">Back to List</a>
</div>
</body>
</html>
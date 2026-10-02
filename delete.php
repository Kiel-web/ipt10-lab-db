<?php
require_once 'config.php';

$id = trim($_GET['id'] ?? ($_POST['id'] ?? ''));
if ($id === '') { die('Invalid student ID'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $d = $pdo->prepare('DELETE FROM students WHERE id = ?');
    $d->execute([$id]);
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT first_name, last_name FROM students WHERE id = ?');
$stmt->execute([$id]);
$student = $stmt->fetch();

if (!$student) { die('Student not found.'); }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirm Delete (PDO)</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body class="section">
<div class="container box" style="max-width: 500px;">
    <h2 class="title is-4">Confirm Deletion (PDO)</h2>
    <p>Are you sure you want to delete <strong><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></strong>?</p>
    <br>
    <form method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
        <button type="submit" class="button is-danger">Yes, Delete</button>
        <a href="index.php" class="button is-light">Cancel</a>
    </form>
</div>
</body>
</html>
<?php
require_once 'db_connect.php';

$id = trim($_GET['id'] ?? ($_POST['id'] ?? ''));
if ($id === '') { die('Invalid student ID'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $d = $conn->prepare('DELETE FROM students WHERE id = ?');
    $d->bind_param('s', $id);
    $d->execute();
    $deleted = ($d->affected_rows > 0);
    $d->close();
    $conn->close();
    header('Location: index.php');
    exit;
}

$s = $conn->prepare('SELECT first_name, last_name FROM students WHERE id = ?');
$s->bind_param('s', $id);
$s->execute();
$r = $s->get_result()->fetch_assoc();
$s->close();

if (!$r) { die('Student not found.'); }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirm Delete</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body class="section">
<div class="container box" style="max-width: 500px;">
    <h2 class="title is-4">Confirm Deletion</h2>
    <p>Are you sure you want to delete <strong><?= htmlspecialchars($r['first_name'] . ' ' . $r['last_name']) ?></strong>?</p>
    <br>
    <form method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
        <button type="submit" class="button is-danger">Yes, Delete</button>
        <a href="index.php" class="button is-light">Cancel</a>
    </form>
</div>
</body>
</html>
<?php $conn->close(); ?>
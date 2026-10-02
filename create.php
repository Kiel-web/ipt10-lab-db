<?php
require_once 'config.php';

$errors = [];
$first_name = $middle_name = $last_name = $birthday = $sex = $email = $student_number = $program = $enrolment_date = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name     = trim($_POST['first_name'] ?? '');
    $middle_name    = trim($_POST['middle_name'] ?? '');
    $last_name      = trim($_POST['last_name'] ?? '');
    $birthday       = trim($_POST['birthday'] ?? '');
    $sex            = trim($_POST['sex'] ?? '');
    $email          = trim($_POST['email'] ?? '');
    $student_number = trim($_POST['student_number'] ?? '');
    $program        = trim($_POST['program'] ?? '');
    $enrolment_date = trim($_POST['enrolment_date'] ?? '');

    if (!preg_match('/^[A-Za-z\s]{2,100}$/', $first_name)) { $errors['first_name'] = '2-100 letters/spaces.'; }
    if (!preg_match('/^[A-Za-z\s]{2,100}$/', $last_name)) { $errors['last_name'] = '2-100 letters/spaces.'; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors['email'] = 'Valid email required.'; }
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $birthday)) { $errors['birthday'] = 'YYYY-MM-DD required.'; }
    if (!in_array($sex, ['Male', 'Female'], true)) { $errors['sex'] = 'Select Male or Female.'; }
    if ($student_number !== '' && !preg_match('/^[A-Za-z0-9]{1,50}$/', $student_number)) { $errors['student_number'] = 'Max 50 alphanumeric.'; }
    if (strlen($program) > 200) { $errors['program'] = 'Max 200 chars.'; }
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $enrolment_date)) { $errors['enrolment_date'] = 'YYYY-MM-DD required.'; }

    if (empty($errors)) {
        $sql = 'INSERT INTO students (id, first_name, middle_name, last_name, birthday, sex, email, student_number, program, enrolment_date) VALUES (UUID(), ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = $pdo->prepare($sql);
        $m_name = $middle_name === '' ? null : $middle_name;
        $stmt->execute([$first_name, $m_name, $last_name, $birthday, $sex, $email, $student_number, $program, $enrolment_date]);

        if ($stmt->rowCount() > 0) {
            $success = true;
            $first_name = $middle_name = $last_name = $birthday = $sex = $email = $student_number = $program = $enrolment_date = '';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Student (PDO)</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body class="section">
<div class="container box" style="max-width: 650px;">
    <h1 class="title is-4">Add New Student (PDO)</h1>
    <?php if ($success): ?><div class="notification is-success">Student created successfully!</div><?php endif; ?>
    <form method="POST">
        <div class="field">
            <label class="label">First Name *</label>
            <input class="input" type="text" name="first_name" value="<?= htmlspecialchars($first_name) ?>">
            <?php if (isset($errors['first_name'])): ?><p class="help is-danger"><?= $errors['first_name'] ?></p><?php endif; ?>
        </div>
        <div class="field">
            <label class="label">Middle Name</label>
            <input class="input" type="text" name="middle_name" value="<?= htmlspecialchars($middle_name) ?>">
        </div>
        <div class="field">
            <label class="label">Last Name *</label>
            <input class="input" type="text" name="last_name" value="<?= htmlspecialchars($last_name) ?>">
            <?php if (isset($errors['last_name'])): ?><p class="help is-danger"><?= $errors['last_name'] ?></p><?php endif; ?>
        </div>
        <div class="field">
            <label class="label">Birthday *</label>
            <input class="input" type="date" name="birthday" value="<?= htmlspecialchars($birthday) ?>">
            <?php if (isset($errors['birthday'])): ?><p class="help is-danger"><?= $errors['birthday'] ?></p><?php endif; ?>
        </div>
        <div class="field">
            <label class="label">Sex *</label>
            <div class="select is-fullwidth">
                <select name="sex">
                    <option value="">Select Sex</option>
                    <option value="Male" <?= $sex === 'Male' ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= $sex === 'Female' ? 'selected' : '' ?>>Female</option>
                </select>
            </div>
            <?php if (isset($errors['sex'])): ?><p class="help is-danger"><?= $errors['sex'] ?></p><?php endif; ?>
        </div>
        <div class="field">
            <label class="label">Email *</label>
            <input class="input" type="text" name="email" value="<?= htmlspecialchars($email) ?>">
            <?php if (isset($errors['email'])): ?><p class="help is-danger"><?= $errors['email'] ?></p><?php endif; ?>
        </div>
        <div class="field">
            <label class="label">Student Number</label>
            <input class="input" type="text" name="student_number" value="<?= htmlspecialchars($student_number) ?>">
            <?php if (isset($errors['student_number'])): ?><p class="help is-danger"><?= $errors['student_number'] ?></p><?php endif; ?>
        </div>
        <div class="field">
            <label class="label">Program</label>
            <input class="input" type="text" name="program" value="<?= htmlspecialchars($program) ?>">
            <?php if (isset($errors['program'])): ?><p class="help is-danger"><?= $errors['program'] ?></p><?php endif; ?>
        </div>
        <div class="field">
            <label class="label">Enrolment Date *</label>
            <input class="input" type="date" name="enrolment_date" value="<?= htmlspecialchars($enrolment_date) ?>">
            <?php if (isset($errors['enrolment_date'])): ?><p class="help is-danger"><?= $errors['enrolment_date'] ?></p><?php endif; ?>
        </div>
        <button class="button is-primary" type="submit">Submit</button>
        <a href="index.php" class="button is-light">Back</a>
    </form>
</div>
</body>
</html>
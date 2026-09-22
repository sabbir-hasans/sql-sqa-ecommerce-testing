<?php require_once __DIR__ . '/../config/database.php';
$pageTitle = 'Add Customer';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $s = $pdo->prepare('INSERT INTO customers(first_name,last_name,age,country) VALUES(?,?,?,?)');
    $s->execute([trim($_POST['first_name']), trim($_POST['last_name']) ?: null, (int)$_POST['age'], trim($_POST['country'])]);
    header('Location: ../public/customers.php');
    exit;
}
include '../public/header.php'; ?>
<h2>Add Customer</h2>
<form method="post" class="card p-4">
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label">First Name</label><input required class="form-control" name="first_name"></div>
        <div class="col-md-6"><label class="form-label">Last Name</label><input class="form-control" name="last_name"></div>
        <div class="col-md-4"><label class="form-label">Age</label><input required type="number" min="1" class="form-control" name="age"></div>
        <div class="col-md-8"><label class="form-label">Country</label><input required class="form-control" name="country"></div>
    </div><button class="btn btn-primary mt-4">Save</button>
</form><?php include '../public/footer.php'; ?>
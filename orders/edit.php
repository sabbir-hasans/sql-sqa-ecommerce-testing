<?php

require_once __DIR__ . '/../config/database.php';

$id = (int) ($_GET['id'] ?? 0);

$s = $pdo->prepare(
    'SELECT *
     FROM orders
     WHERE order_id = ?'
);

$s->execute([$id]);

$o = $s->fetch();

if (!$o) {
    die('Order not found');
}

$customers = $pdo
    ->query(
        'SELECT customer_id, first_name, last_name
         FROM customers
         ORDER BY first_name'
    )
    ->fetchAll();

$pageTitle = 'Edit Order';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $s = $pdo->prepare(
        'UPDATE orders
         SET item = ?, amount = ?, customer_id = ?
         WHERE order_id = ?'
    );

    $s->execute([
        trim($_POST['item']),
        (float) $_POST['amount'],
        (int) $_POST['customer_id'],
        $id,
    ]);

    header('Location: ../public/orders.php');
    exit;
}

include '../public/header.php';
?>

<h2>Edit Order #<?= $id ?></h2>

<form method="post" class="card p-4">

    <label class="form-label">Customer</label>

    <select
        required
        class="form-select mb-3"
        name="customer_id">
        <?php foreach ($customers as $c): ?>

            <option
                value="<?= $c['customer_id'] ?>"
                <?= $o['customer_id'] == $c['customer_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars(
                    $c['first_name'] . ' ' . ($c['last_name'] ?? '')
                ) ?>
            </option>

        <?php endforeach; ?>
    </select>

    <label class="form-label">Item</label>

    <input
        required
        class="form-control mb-3"
        name="item"
        value="<?= htmlspecialchars($o['item']) ?>">

    <label class="form-label">Amount</label>

    <input
        required
        step="0.01"
        type="number"
        class="form-control mb-3"
        name="amount"
        value="<?= $o['amount'] ?>">

    <button class="btn btn-primary">
        Update Order
    </button>

</form>

<?php include '../public/footer.php'; ?>
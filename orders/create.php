<?php

require_once __DIR__ . '/../config/database.php';

$pageTitle = 'Add Order';

$customers = $pdo
    ->query(
        'SELECT customer_id, first_name, last_name
         FROM customers
         ORDER BY first_name'
    )
    ->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $s = $pdo->prepare(
        'INSERT INTO orders (item, amount, customer_id)
         VALUES (?, ?, ?)'
    );

    $s->execute([
        trim($_POST['item']),
        (float) $_POST['amount'],
        (int) $_POST['customer_id'],
    ]);

    header('Location: ../public/orders.php');
    exit;
}

include '../public/header.php';
?>

<h2>Add Order</h2>

<form method="post" class="card p-4">

    <label class="form-label">Customer</label>

    <select required class="form-select mb-3" name="customer_id">
        <?php foreach ($customers as $c): ?>
            <option value="<?= $c['customer_id'] ?>">
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
        name="item">

    <label class="form-label">Amount</label>

    <input
        required
        step="0.01"
        min="0"
        type="number"
        class="form-control mb-3"
        name="amount">

    <button class="btn btn-success">
        Save Order
    </button>

</form>

<?php include '../public/footer.php'; ?>
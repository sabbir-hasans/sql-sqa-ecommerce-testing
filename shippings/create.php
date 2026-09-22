<?php

require_once __DIR__ . '/../config/database.php';

$pageTitle = 'Add Shipping';

$customers = $pdo
    ->query(
        '
        SELECT
            customer_id,
            first_name,
            last_name
        FROM customers
        ORDER BY first_name
        '
    )
    ->fetchAll();

$orders = $pdo
    ->query(
        '
        SELECT
            order_id,
            item,
            customer_id
        FROM orders
        ORDER BY order_id DESC
        '
    )
    ->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $s = $pdo->prepare(
        '
        INSERT INTO shippings (
            status,
            customer,
            order_id
        )
        VALUES (?, ?, ?)
        '
    );

    $s->execute([
        $_POST['status'],
        (int) $_POST['customer'],
        $_POST['order_id'] !== ''
            ? (int) $_POST['order_id']
            : null,
    ]);

    header('Location: ../public/shippings.php');
    exit;
}

include '../public/header.php';
?>

<h2>Add Shipping</h2>

<form method="post" class="card p-4">

    <label class="form-label">
        Status
    </label>

    <select
        class="form-select mb-3"
        name="status">
        <option>Pending</option>
        <option>Delivered</option>
    </select>


    <label class="form-label">
        Shipping Customer
    </label>

    <select
        required
        class="form-select mb-3"
        name="customer">

        <?php foreach ($customers as $c): ?>

            <option value="<?= $c['customer_id'] ?>">

                <?= htmlspecialchars(
                    $c['first_name'] . ' ' . ($c['last_name'] ?? '')
                ) ?>

            </option>

        <?php endforeach; ?>

    </select>


    <label class="form-label">
        Order (optional)
    </label>

    <select
        class="form-select mb-3"
        name="order_id">

        <option value="">
            No order
        </option>

        <?php foreach ($orders as $o): ?>

            <option value="<?= $o['order_id'] ?>">

                #<?= $o['order_id'] ?>
                —
                <?= htmlspecialchars($o['item']) ?>

            </option>

        <?php endforeach; ?>

    </select>


    <button class="btn btn-secondary">
        Save Shipping
    </button>

</form>

<?php include '../public/footer.php'; ?>
<?php

require_once __DIR__ . '/../config/database.php';

$id = (int) ($_GET['id'] ?? 0);

$s = $pdo->prepare(
    '
    SELECT *
    FROM shippings
    WHERE shipping_id = ?
    '
);

$s->execute([$id]);

$x = $s->fetch();

if (!$x) {
    die('Shipping not found');
}

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
            item
        FROM orders
        ORDER BY order_id DESC
        '
    )
    ->fetchAll();

$pageTitle = 'Update Shipping';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $s = $pdo->prepare(
        '
        UPDATE shippings
        SET
            status = ?,
            customer = ?,
            order_id = ?
        WHERE shipping_id = ?
        '
    );

    $s->execute([
        $_POST['status'],
        (int) $_POST['customer'],
        $_POST['order_id'] !== ''
            ? (int) $_POST['order_id']
            : null,
        $id,
    ]);

    header('Location: ../public/shippings.php');
    exit;
}

include '../public/header.php';
?>

<h2>Update Shipping #<?= $id ?></h2>

<form method="post" class="card p-4">

    <label class="form-label">
        Status
    </label>

    <select
        class="form-select mb-3"
        name="status">

        <option
            <?= $x['status'] === 'Pending' ? 'selected' : '' ?>>
            Pending
        </option>

        <option
            <?= $x['status'] === 'Delivered' ? 'selected' : '' ?>>
            Delivered
        </option>

    </select>


    <label class="form-label">
        Shipping Customer
    </label>

    <select
        class="form-select mb-3"
        name="customer">

        <?php foreach ($customers as $c): ?>

            <option
                value="<?= $c['customer_id'] ?>"
                <?= $x['customer'] == $c['customer_id'] ? 'selected' : '' ?>>

                <?= htmlspecialchars(
                    $c['first_name'] . ' ' . ($c['last_name'] ?? '')
                ) ?>

            </option>

        <?php endforeach; ?>

    </select>


    <label class="form-label">
        Order
    </label>

    <select
        class="form-select mb-3"
        name="order_id">

        <option value="">
            No order
        </option>

        <?php foreach ($orders as $o): ?>

            <option
                value="<?= $o['order_id'] ?>"
                <?= $x['order_id'] == $o['order_id'] ? 'selected' : '' ?>>

                #<?= $o['order_id'] ?>
                —
                <?= htmlspecialchars($o['item']) ?>

            </option>

        <?php endforeach; ?>

    </select>


    <button class="btn btn-primary">
        Update Shipping
    </button>

</form>

<?php include '../public/footer.php'; ?>
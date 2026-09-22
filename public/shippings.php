<?php

require_once __DIR__ . '/../config/database.php';

$pageTitle = 'Shippings';

$rows = $pdo->query(
    '
    SELECT
        s.*,
        c.first_name,
        c.last_name,
        o.item,
        o.amount,
        o.customer_id AS order_customer
    FROM shippings s
    LEFT JOIN customers c
        ON s.customer = c.customer_id
    LEFT JOIN orders o
        ON s.order_id = o.order_id
    ORDER BY s.shipping_id DESC
    '
)->fetchAll();

include 'header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">

    <h2>Shippings</h2>

    <a
        class="btn btn-secondary"
        href="../shippings/create.php">
        + Add Shipping
    </a>

</div>

<div class="card p-3">

    <div class="table-responsive">

        <table class="table table-hover">

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Status</th>
                    <th>Shipping Customer</th>
                    <th>Order</th>
                    <th>Order Customer</th>
                    <th>Actions</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($rows as $r): ?>

                    <?php
                    $mismatch =
                        $r['order_id'] !== null
                        && $r['order_customer'] !== null
                        && $r['customer'] != $r['order_customer'];

                    $missing =
                        $r['order_id'] !== null
                        && $r['item'] === null;
                    ?>

                    <tr
                        class="<?= $mismatch || $missing ? 'table-danger' : '' ?>">

                        <td>
                            <?= $r['shipping_id'] ?>
                        </td>

                        <td>

                            <span
                                class="badge <?= $r['status'] === 'Pending'
                                                    ? 'badge-pending'
                                                    : 'badge-delivered' ?>">
                                <?= $r['status'] ?>
                            </span>

                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $r['first_name'] . ' ' . ($r['last_name'] ?? '')
                            ) ?>
                        </td>

                        <td>
                            <?= $r['order_id'] ?? '—' ?>

                            <?= $missing ? ' (missing)' : '' ?>
                        </td>

                        <td>
                            <?= $r['order_customer'] ?? '—' ?>
                        </td>

                        <td>

                            <a
                                class="btn btn-sm btn-outline-primary"
                                href="../shippings/update.php?id=<?= $r['shipping_id'] ?>">
                                Update
                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<?php include 'footer.php'; ?>
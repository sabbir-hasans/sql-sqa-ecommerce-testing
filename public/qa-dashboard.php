<?php

require_once __DIR__ . '/../config/database.php';

$pageTitle = 'QA Dashboard';

/*
|--------------------------------------------------------------------------
| 1. Order / Shipping Customer Mismatch
|--------------------------------------------------------------------------
*/

$mismatch = $pdo->query(
    '
    SELECT
        o.order_id,
        o.customer_id AS order_customer,
        s.customer AS shipping_customer,
        s.shipping_id
    FROM orders o
    JOIN shippings s
        ON o.order_id = s.order_id
    WHERE o.customer_id <> s.customer
    '
)->fetchAll();

/*
|--------------------------------------------------------------------------
| 2. Delivered Shipping Without Order
|--------------------------------------------------------------------------
*/

$delivered = $pdo->query(
    '
    SELECT
        s.shipping_id,
        s.customer,
        c.first_name,
        c.last_name
    FROM shippings s
    JOIN customers c
        ON s.customer = c.customer_id
    LEFT JOIN orders o
        ON s.order_id = o.order_id
    WHERE s.status = "Delivered"
        AND o.order_id IS NULL
    '
)->fetchAll();

/*
|--------------------------------------------------------------------------
| 3. Customers Without Orders
|--------------------------------------------------------------------------
*/

$without = $pdo->query(
    '
    SELECT
        c.customer_id,
        c.first_name,
        c.last_name
    FROM customers c
    LEFT JOIN orders o
        ON c.customer_id = o.customer_id
    WHERE o.order_id IS NULL
    '
)->fetchAll();

/*
|--------------------------------------------------------------------------
| 4. Country Average Outliers
|--------------------------------------------------------------------------
*/

$outliers = $pdo->query(
    '
    SELECT
        c.first_name,
        c.last_name,
        c.country,
        o.order_id,
        o.amount
    FROM customers c
    JOIN orders o
        ON c.customer_id = o.customer_id
    WHERE o.amount > 2 * (
        SELECT AVG(o2.amount)
        FROM orders o2
        JOIN customers c2
            ON o2.customer_id = c2.customer_id
        WHERE c2.country = c.country
    )
    ORDER BY o.amount DESC
    '
)->fetchAll();

include 'header.php';
?>

<div class="d-flex justify-content-between align-items-center">

    <div>
        <h2>QA / Data Integrity Dashboard</h2>

        <p class="text-muted">
            These checks intentionally look for suspicious or inconsistent
            database states.
        </p>
    </div>

    <span class="badge text-bg-danger fs-6">
        Training Defects
    </span>

</div>


<!-- ==========================================================
     1. Order / Shipping Customer Mismatch
     ========================================================== -->

<div class="card p-3 mb-4">

    <h4>
        1. Order / Shipping Customer Mismatch

        <span class="badge text-bg-danger">
            <?= count($mismatch) ?>
        </span>
    </h4>

    <table class="table">

        <thead>
            <tr>
                <th>Shipping ID</th>
                <th>Order ID</th>
                <th>Order Customer</th>
                <th>Shipping Customer</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($mismatch as $r): ?>

                <tr>

                    <td>
                        <?= $r['shipping_id'] ?>
                    </td>

                    <td>
                        <?= $r['order_id'] ?>
                    </td>

                    <td>
                        <?= $r['order_customer'] ?>
                    </td>

                    <td>
                        <?= $r['shipping_customer'] ?>
                    </td>

                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</div>


<!-- ==========================================================
     2. Delivered Without Order
     ========================================================== -->

<div class="card p-3 mb-4">

    <h4>
        2. Delivered Without Order

        <span class="badge text-bg-danger">
            <?= count($delivered) ?>
        </span>
    </h4>

    <table class="table">

        <thead>
            <tr>
                <th>Shipping ID</th>
                <th>Customer</th>
                <th>Name</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($delivered as $r): ?>

                <tr>

                    <td>
                        <?= $r['shipping_id'] ?>
                    </td>

                    <td>
                        <?= $r['customer'] ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $r['first_name'] . ' ' . ($r['last_name'] ?? '')
                        ) ?>
                    </td>

                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</div>


<!-- ==========================================================
     3. Customers Without Orders
     ========================================================== -->

<div class="card p-3 mb-4">

    <h4>
        3. Customers Without Orders

        <span class="badge text-bg-warning">
            <?= count($without) ?>
        </span>
    </h4>

    <table class="table">

        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($without as $r): ?>

                <tr>

                    <td>
                        <?= $r['customer_id'] ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $r['first_name'] . ' ' . ($r['last_name'] ?? '')
                        ) ?>
                    </td>

                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</div>


<!-- ==========================================================
     4. Country Average Outliers
     ========================================================== -->

<div class="card p-3">

    <h4>
        4. Country Average Outliers

        <span class="badge text-bg-danger">
            <?= count($outliers) ?>
        </span>
    </h4>

    <p class="text-muted">
        Order amount is more than twice the customer's country
        average order amount.
    </p>

    <table class="table">

        <thead>
            <tr>
                <th>Customer</th>
                <th>Country</th>
                <th>Order</th>
                <th>Amount</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($outliers as $r): ?>

                <tr>

                    <td>
                        <?= htmlspecialchars(
                            $r['first_name'] . ' ' . ($r['last_name'] ?? '')
                        ) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($r['country']) ?>
                    </td>

                    <td>
                        #<?= $r['order_id'] ?>
                    </td>

                    <td>
                        <?= number_format($r['amount'], 2) ?>
                    </td>

                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</div>


<?php include 'footer.php'; ?>
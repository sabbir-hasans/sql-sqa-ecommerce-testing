<?php

require_once __DIR__ . '/../config/database.php';

$pageTitle = 'Sales Report';

$summary = $pdo->query(
    '
    SELECT
        COUNT(*) AS total_orders,
        SUM(amount) AS total_sales,
        AVG(amount) AS avg_order,
        MIN(amount) AS min_order,
        MAX(amount) AS max_order
    FROM orders
    '
)->fetch();

$top = $pdo->query(
    '
    SELECT
        o.order_id,
        o.item,
        o.amount,
        c.first_name,
        c.last_name
    FROM orders o
    INNER JOIN customers c
        ON o.customer_id = c.customer_id
    ORDER BY o.amount DESC
    '
)->fetchAll();

include '../public/header.php';
?>

<h2>Sales Report</h2>

<div class="row g-3 mb-4">

    <?php
    $metrics = [
        [
            'Total Orders',
            $summary['total_orders'],
        ],
        [
            'Total Sales',
            number_format($summary['total_sales'], 2),
        ],
        [
            'Average',
            number_format($summary['avg_order'], 2),
        ],
        [
            'Minimum',
            number_format($summary['min_order'], 2),
        ],
        [
            'Maximum',
            number_format($summary['max_order'], 2),
        ],
    ];
    ?>

    <?php foreach ($metrics as $m): ?>

        <div class="col">

            <div class="card p-3">

                <div class="text-muted">
                    <?= $m[0] ?>
                </div>

                <div class="metric">
                    <?= $m[1] ?>
                </div>

            </div>

        </div>

    <?php endforeach; ?>

</div>


<div class="card p-3">

    <h5>Orders — Highest to Lowest</h5>

    <table class="table">

        <thead>

            <tr>
                <th>Order</th>
                <th>Customer</th>
                <th>Item</th>
                <th>Amount</th>
            </tr>

        </thead>

        <tbody>

            <?php foreach ($top as $r): ?>

                <tr>

                    <td>
                        #<?= $r['order_id'] ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $r['first_name'] . ' ' . ($r['last_name'] ?? '')
                        ) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($r['item']) ?>
                    </td>

                    <td>
                        <?= number_format($r['amount'], 2) ?>
                    </td>

                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</div>

<?php include '../public/footer.php'; ?>
<?php

require_once __DIR__ . '/../config/database.php';

$pageTitle = 'Country Report';

$rows = $pdo->query(
    '
    SELECT
        c.country,
        COUNT(DISTINCT c.customer_id) AS total_customers,
        COUNT(o.order_id) AS total_orders,
        COALESCE(SUM(o.amount), 0) AS total_spent,
        COALESCE(AVG(o.amount), 0) AS avg_order
    FROM customers c
    LEFT JOIN orders o
        ON c.customer_id = o.customer_id
    GROUP BY c.country
    ORDER BY total_spent DESC
    '
)->fetchAll();

include '../public/header.php';
?>

<h2>Country Report</h2>

<div class="card p-3">

    <div class="table-responsive">

        <table class="table">

            <thead>

                <tr>
                    <th>Country</th>
                    <th>Customers</th>
                    <th>Orders</th>
                    <th>Total Spent</th>
                    <th>Average Order</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($rows as $r): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars($r['country']) ?>
                        </td>

                        <td>
                            <?= $r['total_customers'] ?>
                        </td>

                        <td>
                            <?= $r['total_orders'] ?>
                        </td>

                        <td>
                            <?= number_format($r['total_spent'], 2) ?>
                        </td>

                        <td>
                            <?= number_format($r['avg_order'], 2) ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<?php include '../public/footer.php'; ?>
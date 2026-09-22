<?php

require_once __DIR__ . '/../config/database.php';

$pageTitle = 'Customer Report';

$rows = $pdo->query(
    '
    SELECT
        c.customer_id,
        c.first_name,
        c.last_name,
        COUNT(o.order_id) AS total_orders,
        COALESCE(SUM(o.amount), 0) AS total_spent
    FROM customers c
    LEFT JOIN orders o
        ON c.customer_id = o.customer_id
    GROUP BY
        c.customer_id,
        c.first_name,
        c.last_name
    ORDER BY total_spent DESC
    '
)->fetchAll();

$high = $pdo->query(
    '
    SELECT
        c.customer_id,
        c.first_name,
        c.last_name,
        SUM(o.amount) AS total_spent
    FROM customers c
    JOIN orders o
        ON c.customer_id = o.customer_id
    GROUP BY
        c.customer_id,
        c.first_name,
        c.last_name
    HAVING SUM(o.amount) > 500
    ORDER BY total_spent DESC
    '
)->fetchAll();

include '../public/header.php';
?>

<h2>Customer Report</h2>


<!-- All Customers -->

<div class="card p-3 mb-4">

    <h5>All Customers</h5>

    <div class="table-responsive">

        <table class="table">

            <thead>

                <tr>
                    <th>Customer</th>
                    <th>Orders</th>
                    <th>Total Spent</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($rows as $r): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars(
                                $r['first_name'] . ' ' . ($r['last_name'] ?? '')
                            ) ?>
                        </td>

                        <td>
                            <?= $r['total_orders'] ?>
                        </td>

                        <td>
                            <?= number_format($r['total_spent'], 2) ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>


<!-- Customers With Spending > 500 -->

<div class="card p-3">

    <h5>
        Customers With Spending &gt; 500 (HAVING)
    </h5>

    <table class="table">

        <thead>

            <tr>
                <th>Customer</th>
                <th>Total Spent</th>
            </tr>

        </thead>

        <tbody>

            <?php foreach ($high as $r): ?>

                <tr>

                    <td>
                        <?= htmlspecialchars(
                            $r['first_name'] . ' ' . ($r['last_name'] ?? '')
                        ) ?>
                    </td>

                    <td>
                        <?= number_format($r['total_spent'], 2) ?>
                    </td>

                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</div>

<?php include '../public/footer.php'; ?>
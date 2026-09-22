<?php

require_once __DIR__ . '/../config/database.php';

$pageTitle = 'Orders';

$q = trim($_GET['q'] ?? '');

$sort = $_GET['sort'] ?? 'order_id';

$allowed = [
    'order_id',
    'item',
    'amount',
    'customer_id',
];

if (!in_array($sort, $allowed, true)) {
    $sort = 'order_id';
}

$sql = '
    SELECT
        o.*,
        c.first_name,
        c.last_name
    FROM orders o
    INNER JOIN customers c
        ON o.customer_id = c.customer_id
    WHERE 1 = 1
';

$p = [];

if ($q !== '') {
    $sql .= '
        AND (
            o.item LIKE :q
            OR c.first_name LIKE :q
            OR c.last_name LIKE :q
        )
    ';

    $p['q'] = "%$q%";
}

$sql .= " ORDER BY o.`$sort` DESC";

$s = $pdo->prepare($sql);

$s->execute($p);

$rows = $s->fetchAll();

include 'header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">

    <h2>Orders</h2>

    <a
        class="btn btn-success"
        href="../orders/create.php">
        + Add Order
    </a>

</div>

<form class="card p-3 mb-3">

    <div class="row g-2">

        <div class="col-md-8">

            <input
                class="form-control"
                name="q"
                value="<?= htmlspecialchars($q) ?>"
                placeholder="Search item or customer">

        </div>

        <div class="col-md-2">

            <select
                class="form-select"
                name="sort">

                <?php foreach ($allowed as $x): ?>

                    <option
                        value="<?= $x ?>"
                        <?= $sort === $x ? 'selected' : '' ?>>
                        Sort: <?= $x ?>
                    </option>

                <?php endforeach; ?>

            </select>

        </div>

        <div class="col-md-2">

            <button class="btn btn-dark w-100">
                Filter
            </button>

        </div>

    </div>

</form>

<div class="card p-3">

    <div class="table-responsive">

        <table class="table table-hover">

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Item</th>
                    <th>Amount</th>
                    <th>Actions</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($rows as $r): ?>

                    <tr>

                        <td>
                            <?= $r['order_id'] ?>
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

                        <td>

                            <a
                                class="btn btn-sm btn-outline-primary"
                                href="../orders/edit.php?id=<?= $r['order_id'] ?>">
                                Edit
                            </a>

                            <a
                                class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Delete this order?')"
                                href="../orders/delete.php?id=<?= $r['order_id'] ?>">
                                Delete
                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<?php include 'footer.php'; ?>
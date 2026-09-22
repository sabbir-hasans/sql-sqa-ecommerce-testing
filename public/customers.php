<?php
require_once __DIR__ . '/../config/database.php';
$pageTitle = 'Customers';
$q = trim($_GET['q'] ?? '');
$country = trim($_GET['country'] ?? '');
$sort = $_GET['sort'] ?? 'customer_id';
$allowed = ['customer_id', 'first_name', 'last_name', 'age', 'country'];
if (!in_array($sort, $allowed, true)) $sort = 'customer_id';
$sql = 'SELECT * FROM customers WHERE 1=1';
$params = [];
if ($q !== '') {
    $sql .= " AND (first_name LIKE :q OR last_name LIKE :q OR country LIKE :q)";
    $params['q'] = "%$q%";
}
if ($country !== '') {
    $sql .= ' AND country=:country';
    $params['country'] = $country;
}
$sql .= " ORDER BY `$sort`";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();
$countries = $pdo->query('SELECT DISTINCT country FROM customers ORDER BY country')->fetchAll();
include 'header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Customers</h2><a class="btn btn-primary" href="../customers/create.php">+ Add Customer</a>
</div>
<form class="card p-3 mb-3">
    <div class="row g-2">
        <div class="col-md-5"><input class="form-control" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Search name/country (LIKE)"></div>
        <div class="col-md-3"><select class="form-select" name="country">
                <option value="">All countries</option><?php foreach ($countries as $c): ?><option <?= $country === $c['country'] ? 'selected' : '' ?>><?= htmlspecialchars($c['country']) ?></option><?php endforeach; ?>
            </select></div>
        <div class="col-md-2"><select class="form-select" name="sort"><?php foreach ($allowed as $s): ?><option value="<?= $s ?>" <?= $sort === $s ? 'selected' : '' ?>>Sort: <?= $s ?></option><?php endforeach; ?></select></div>
        <div class="col-md-2"><button class="btn btn-dark w-100">Filter</button></div>
    </div>
</form>
<div class="card p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Country</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody><?php foreach ($rows as $r): ?><tr>
                        <td><?= $r['customer_id'] ?></td>
                        <td><?= htmlspecialchars($r['first_name'] . ' ' . ($r['last_name'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string)$r['age']) ?></td>
                        <td><?= htmlspecialchars($r['country']) ?></td>
                        <td><a class="btn btn-sm btn-outline-primary" href="../customers/edit.php?id=<?= $r['customer_id'] ?>">Edit</a> <a class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this customer?')" href="../customers/delete.php?id=<?= $r['customer_id'] ?>">Delete</a></td>
                    </tr><?php endforeach; ?></tbody>
        </table>
    </div>
</div>
<?php include 'footer.php'; ?>
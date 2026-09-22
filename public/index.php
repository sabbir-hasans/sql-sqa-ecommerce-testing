<?php
require_once __DIR__ . '/../config/database.php';
$pageTitle = 'Dashboard';
$customers = (int)$pdo->query('SELECT COUNT(*) FROM customers')->fetchColumn();
$orders = (int)$pdo->query('SELECT COUNT(*) FROM orders')->fetchColumn();
$sales = (float)$pdo->query('SELECT COALESCE(SUM(amount),0) FROM orders')->fetchColumn();
$pending = (int)$pdo->query("SELECT COUNT(*) FROM shippings WHERE status='Pending'")->fetchColumn();
$issues = (int)$pdo->query("SELECT COUNT(*) FROM shippings s LEFT JOIN orders o ON s.order_id=o.order_id WHERE (s.order_id IS NOT NULL AND o.order_id IS NULL) OR (o.order_id IS NOT NULL AND s.customer <> o.customer_id) OR (s.status='Delivered' AND s.order_id IS NULL)")->fetchColumn();
include 'header.php';
?>
<div class="p-4 bg-white rounded-3 shadow-sm mb-4"><h1>SQL for SQA — E-Commerce Training Project</h1><p class="lead mb-0">Practice SQL through a realistic customer, order, shipping and data-integrity workflow.</p></div>
<div class="row g-3">
<?php foreach ([['Customers',$customers,'primary'],['Orders',$orders,'success'],['Total Sales','$'.number_format($sales,2),'info'],['Pending Shipments',$pending,'warning'],['QA Issues',$issues,'danger']] as $m): ?>
<div class="col-md-6 col-xl"><div class="card p-3 h-100"><div class="text-muted"><?= $m[0] ?></div><div class="metric text-<?= $m[2] ?>"><?= $m[1] ?></div></div></div>
<?php endforeach; ?>
</div>
<div class="row g-4 mt-2">
<div class="col-lg-7"><div class="card p-4"><h4>Training Path</h4><ol><li>Class 01: SELECT, WHERE, sorting and filtering.</li><li>Class 02: aggregates, GROUP BY/HAVING and JOIN.</li><li>Class 03: QA data-integrity investigations.</li><li>Final Exam: theory, scenario analysis and SQL queries.</li></ol></div></div>
<div class="col-lg-5"><div class="card p-4"><h4>Quick Links</h4><div class="d-grid gap-2"><a class="btn btn-primary" href="customers.php">Manage Customers</a><a class="btn btn-success" href="orders.php">Manage Orders</a><a class="btn btn-secondary" href="shippings.php">Manage Shippings</a><a class="btn btn-info" href="reports.php">Open Reports</a><a class="btn btn-danger" href="qa-dashboard.php">Open QA Dashboard</a></div></div></div>
</div>
<?php include 'footer.php'; ?>

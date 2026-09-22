<?php
if (!isset($pageTitle)) $pageTitle = 'SQL for SQA';
$base = '/sql-sqa-project';
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($pageTitle) ?> | SQL for SQA</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="<?= $base ?>/assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-dark navbar-dark mb-4">
<div class="container-fluid px-4">
<a class="navbar-brand" href="<?= $base ?>/public/index.php">SQL for SQA</a>
<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
<div class="collapse navbar-collapse" id="nav">
<ul class="navbar-nav me-auto">
<li class="nav-item"><a class="nav-link" href="<?= $base ?>/public/customers.php">Customers</a></li>
<li class="nav-item"><a class="nav-link" href="<?= $base ?>/public/orders.php">Orders</a></li>
<li class="nav-item"><a class="nav-link" href="<?= $base ?>/public/shippings.php">Shippings</a></li>
<li class="nav-item"><a class="nav-link" href="<?= $base ?>/public/reports.php">Reports</a></li>
<li class="nav-item"><a class="nav-link" href="<?= $base ?>/public/qa-dashboard.php">QA Dashboard</a></li>
</ul>
</div></div></nav>
<main class="container-fluid px-4 pb-5">

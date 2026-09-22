<?php

require_once __DIR__ . '/../config/database.php';

$pageTitle = 'Reports';

include 'header.php';
?>

<h2>Reports & Analytics</h2>

<p class="text-muted">
    Each report demonstrates SQL concepts from the course.
</p>

<div class="row g-3">

    <!-- Customer Report -->
    <div class="col-md-4">

        <div class="card p-4">

            <h5>Customer Report</h5>

            <p>
                COUNT, SUM, GROUP BY and HAVING.
            </p>

            <a
                class="btn btn-primary"
                href="../reports/customer-report.php">
                Open
            </a>

        </div>

    </div>


    <!-- Country Report -->
    <div class="col-md-4">

        <div class="card p-4">

            <h5>Country Report</h5>

            <p>
                Country-wise customer and spending analysis.
            </p>

            <a
                class="btn btn-primary"
                href="../reports/country-report.php">
                Open
            </a>

        </div>

    </div>


    <!-- Sales Report -->
    <div class="col-md-4">

        <div class="card p-4">

            <h5>Sales Report</h5>

            <p>
                SUM, AVG, MIN, MAX and ORDER BY.
            </p>

            <a
                class="btn btn-primary"
                href="../reports/sales-report.php">
                Open
            </a>

        </div>

    </div>

</div>

<?php include 'footer.php'; ?>
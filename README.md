# SQL for SQA — E-Commerce Training Project

A beginner-friendly PHP + MySQL project designed around an SQA-focused SQL course.

## Requirements
- XAMPP (Apache + MySQL)
- PHP 8.x recommended
- MySQL/MariaDB
- A browser

## Run in XAMPP
1. Copy the `sql-sqa-project` folder into `C:\xampp\htdocs\`.
2. Start **Apache** and **MySQL** from XAMPP Control Panel.
3. Open `http://localhost/phpmyadmin/`.
4. Import `database/schema.sql`.
5. Import `database/seed.sql`.
6. Open `http://localhost/sql-sqa-project/public/`.

Default database connection in `config/database.php`:
- Host: `127.0.0.1`
- Database: `sql_sqa_project`
- User: `root`
- Password: empty

If your XAMPP MySQL password is different, update `config/database.php`.

## Main Modules
- Customers: CRUD, search, filtering and sorting.
- Orders: CRUD and customer relationship.
- Shippings: create/update shipping records.
- Reports: COUNT, SUM, AVG, MIN, MAX, GROUP BY, HAVING and JOIN.
- QA Dashboard: data-integrity investigation.

## Intentionally Inconsistent Training Data
The seed includes a few deliberately suspicious records so students can practice QA investigation:
- Order/shipping customer mismatch.
- Delivered shipping without a valid order.
- Customer without orders.
- Country-average outlier.

These are training defects, not production recommendations.

## SQL Course Mapping
### Class 01
SELECT, WHERE, AND/OR, BETWEEN, IN, LIKE, ORDER BY, NULL.

### Class 02
COUNT, SUM, AVG, MIN, MAX, GROUP BY, HAVING, INNER JOIN, LEFT JOIN.

### Class 03
Data integrity checks, mismatched relationships, missing orders, NULL investigation and country-level outlier analysis.

## Final Exam Mapping
- Theory: WHERE vs HAVING; INNER vs LEFT JOIN; GROUP BY; NULL; UPDATE/DELETE safety.
- Scenario: e-commerce data-integrity investigation.
- Query Q1–Q9: fundamental SQL and reporting.
- Query Q10: order/shipping customer mismatch.
- Query Q11: country-average outlier using a correlated subquery.
- Query Q12: delivered shipping without an order.

## Useful URLs
- Dashboard: `/sql-sqa-project/public/`
- Customers: `/sql-sqa-project/public/customers.php`
- Orders: `/sql-sqa-project/public/orders.php`
- Shippings: `/sql-sqa-project/public/shippings.php`
- Reports: `/sql-sqa-project/public/reports.php`
- QA Dashboard: `/sql-sqa-project/public/qa-dashboard.php`

## Security / Training Notes
This is a classroom project. It uses PDO prepared statements for user-entered CRUD/filter values, but it is not intended as a production-ready application. Authentication, authorization, CSRF protection, audit logging and production deployment hardening are intentionally outside the course scope.

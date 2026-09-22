SELECT
c.customer_id,
c.first_name,
c.last_name,
SUM(o.amount) AS total_spent
FROM customers c
INNER JOIN orders o
ON c.customer_id = o.customer_id
GROUP BY c.customer_id
HAVING SUM(o.amount) > 500;
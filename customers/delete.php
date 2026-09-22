<?php require_once __DIR__ . '/../config/database.php';
$id = (int)($_GET['id'] ?? 0);
try {
    $s = $pdo->prepare('DELETE FROM customers WHERE customer_id=?');
    $s->execute([$id]);
} catch (PDOException $e) {
    die('Cannot delete this customer because related records exist.');
}
header('Location: ../public/customers.php');
exit;

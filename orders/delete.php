<?php require_once __DIR__ . '/../config/database.php';
$id = (int)($_GET['id'] ?? 0);
$s = $pdo->prepare('DELETE FROM orders WHERE order_id=?');
try {
    $s->execute([$id]);
} catch (PDOException $e) {
    die('Cannot delete this order because a shipping record references it.');
}
header('Location: ../public/orders.php');
exit;

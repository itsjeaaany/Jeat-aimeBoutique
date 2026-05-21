<?php

$dbPath = __DIR__ . '/database.sqlite';
$db = new PDO('sqlite:' . $dbPath);

// Get all orders with their items
$query = "
    SELECT o.id, o.total,
           SUM(oi.price * oi.quantity) as calculated_total
    FROM orders o
    LEFT JOIN order_items oi ON o.id = oi.order_id
    GROUP BY o.id
";

$result = $db->query($query);
$orders = $result->fetchAll(PDO::FETCH_ASSOC);

echo "Fixing order totals...\n\n";

foreach ($orders as $order) {
    $id = $order['id'];
    $oldTotal = $order['total'];
    $newTotal = $order['calculated_total'] ?? 0;
    
    if ($oldTotal != $newTotal) {
        $updateQuery = "UPDATE orders SET total = :total WHERE id = :id";
        $stmt = $db->prepare($updateQuery);
        $stmt->execute([':total' => $newTotal, ':id' => $id]);
        
        echo "Order #{$id}: ₱{$oldTotal} → ₱{$newTotal}\n";
    }
}

echo "\nAll orders fixed!\n";

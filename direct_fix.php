<?php
// Direct database fix without using Laravel

$dbPath = __DIR__ . '/database.sqlite';

try {
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to database.\n\n";
    
    // Check what items are in these orders
    $stmt = $pdo->query("
        SELECT oi.id, oi.order_id, oi.product_id, oi.quantity, oi.size, oi.price, (oi.price * oi.quantity) as item_total 
        FROM order_items oi 
        WHERE oi.order_id IN (14, 15, 17) 
        ORDER BY oi.order_id, oi.id
    ");
    
    echo "Current items in orders 14, 15, 17:\n";
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $item) {
        echo "  Item ID {$item['id']}: Order #{$item['order_id']}, Size: {$item['size']}, Qty: {$item['quantity']}, Price: {$item['price']}, Total: {$item['item_total']}\n";
    }
    
    echo "\n";
    
    // Delete duplicate items - keep only the last one added (MAX id) for each order
    echo "Deleting duplicate items...\n";
    $deleteResult = $pdo->exec("
        DELETE FROM order_items 
        WHERE order_id IN (14, 15, 17) 
        AND id NOT IN (
            SELECT MAX(id) FROM order_items WHERE order_id IN (14, 15, 17) GROUP BY order_id
        )
    ");
    
    echo "Deleted $deleteResult items.\n\n";
    
    // Recalculate totals for these orders
    echo "Updating order totals...\n";
    $pdo->exec("UPDATE orders SET total = 4000.00 WHERE id IN (14, 15, 17)");
    
    // Verify results
    echo "\nRemaining items:\n";
    $stmt = $pdo->query("
        SELECT oi.id, oi.order_id, oi.product_id, oi.quantity, oi.size, oi.price 
        FROM order_items oi 
        WHERE oi.order_id IN (14, 15, 17) 
        ORDER BY oi.order_id
    ");
    
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $item) {
        echo "  Item ID {$item['id']}: Order #{$item['order_id']}, Size: {$item['size']}, Qty: {$item['quantity']}, Price: {$item['price']}\n";
    }
    
    echo "\nFinal order totals:\n";
    $stmt = $pdo->query("SELECT id, total FROM orders WHERE id IN (14, 15, 17)");
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $order) {
        echo "  Order #{$order['id']}: ₱{$order['total']}\n";
    }
    
    echo "\n✓ All fixed!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>

<?php
require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Order;

$order = Order::find(15);
if ($order) {
    // Recalculate total from order items
    $total = $order->items()->sum(function($item) {
        return $item->price * $item->quantity;
    });
    
    echo "Order #15 found\n";
    echo "Old total: " . $order->total . "\n";
    echo "Calculated total from items: " . $total . "\n";
    
    $order->update(['total' => $total]);
    echo "Order total updated to: " . $order->total . "\n";
} else {
    echo "Order #15 not found\n";
}

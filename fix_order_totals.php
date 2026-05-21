<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app['Illuminate\Contracts\Http\Kernel']->bootstrap();

use App\Models\Order;
use Illuminate\Support\Facades\DB;

// Fix all orders with incorrect totals
$orders = Order::all();

foreach ($orders as $order) {
    $calculatedTotal = $order->items->sum(function($item) {
        return $item->price * $item->quantity;
    });
    
    if ($order->total != $calculatedTotal) {
        echo "Order #{$order->id}: {$order->total} -> {$calculatedTotal}\n";
        $order->update(['total' => $calculatedTotal]);
    }
}

echo "\nAll orders have been fixed!\n";

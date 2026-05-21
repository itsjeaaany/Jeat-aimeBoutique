<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class FixOrderTotals extends Command
{
    protected $signature = 'orders:fix-totals';
    protected $description = 'Fix order totals by recalculating from items';

    public function handle()
    {
        $orders = Order::with('items')->get();
        $fixedCount = 0;

        foreach ($orders as $order) {
            $calculatedTotal = $order->items->sum(function($item) {
                return $item->price * $item->quantity;
            });

            if ($order->total != $calculatedTotal) {
                $this->line("Order #{$order->id}: ₱{$order->total} → ₱{$calculatedTotal}");
                $order->update(['total' => $calculatedTotal]);
                $fixedCount++;
            }
        }

        $this->info("\n✓ Fixed {$fixedCount} orders!");
    }
}

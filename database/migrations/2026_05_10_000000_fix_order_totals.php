database/migrations/2026_05_10_fix_order_totals.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

return new class extends Migration
{
    public function up(): void
    {
        // Get all orders and recalculate their totals
        $orders = Order::with('items')->get();
        
        foreach ($orders as $order) {
            $calculatedTotal = $order->items->sum(function($item) {
                return $item->price * $item->quantity;
            });
            
            DB::table('orders')
                ->where('id', $order->id)
                ->update(['total' => $calculatedTotal]);
        }
    }

    public function down(): void
    {
        // Migration is non-reversible
    }
};

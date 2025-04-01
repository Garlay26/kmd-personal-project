<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Facades\Cache;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function orderCacheClear($order)
    {
        $all = "order_" . $order->customer_id;
        $orderCount = Order::count();
        $pages = round($orderCount / 10) + 1;
        for ($i = 1; $i <= $pages; $i++) {
            Cache::forget($all . "page_id$i");
        }
    }
    
    public function created(Order $order)
    {
        self::orderCacheClear($order);
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        self::orderCacheClear($order);
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        self::orderCacheClear($order);
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        self::orderCacheClear($order);
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        self::orderCacheClear($order);
    }
}

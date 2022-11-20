<?php

namespace App\Observers;

use App\Models\OrderDetail;
use App\Models\ProductDetail;
use App\Models\CartDetail;

class OrderDetailObserver
{
    /**
     * Handle the OrderDetail "created" event.
     *
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return void
     */
    public function created(OrderDetail $orderDetail)
    {
        // update product detail quantity
        $product_detail = ProductDetail::find($orderDetail->product_detail_id);
        $product_detail->quantity -= $orderDetail->quantity;
        $product_detail->update();
    }

    /**
     * Handle the OrderDetail "updated" event.
     *
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return void
     */
    public function updated(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Handle the OrderDetail "deleted" event.
     *
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return void
     */
    public function deleted(OrderDetail $orderDetail)
    {
        //
        $product_detail = ProductDetail::find($orderDetail->product_detail_id);
        $product_detail->quantity += $orderDetail->quantity;
        $product_detail->update();
    }

    /**
     * Handle the OrderDetail "restored" event.
     *
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return void
     */
    public function restored(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Handle the OrderDetail "force deleted" event.
     *
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return void
     */
    public function forceDeleted(OrderDetail $orderDetail)
    {
        //
    }
}

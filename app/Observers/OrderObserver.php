<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\DB;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        //
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        //
        if ($order->status == "Cancelled"){
            $order_detail_ids = DB::table('order_details')->where('order_id', '=', $order->id)->get()->map(function($element){
                return $element->id;
            });
            foreach ($order_detail_ids as $order_detail_id){
                $order_detail = OrderDetail::find($order_detail_id);
                
                $product_detail = ProductDetail::find($order_detail->product_detail_id);
                $product_detail->quantity += $order_detail->quantity;
                $product_detail->update();
            }
        }
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function deleting(Order $order)
    {
        //
        $order_detail_ids = DB::table('order_details')->where('order_id', '=', $order->id)->get()->map(function($element){
            return $element->id;
        });
        if ($order->status == "Cancelled"){
            foreach ($order_detail_ids as $order_detail_id){
                $order_detail = OrderDetail::find($order_detail_id);

                $product_detail = ProductDetail::find($order_detail->product_detail_id);
                $product_detail->quantity -= $order_detail->quantity;
                $product_detail->update();

                $order_detail->delete();
            }
        }
        else {
            foreach ($order_detail_ids as $order_detail_id){
                $order_detail = OrderDetail::find($order_detail_id);
                $order_detail->delete();
            }
        }
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}

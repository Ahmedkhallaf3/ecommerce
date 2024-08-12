<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\cart;
use App\Models\product;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Throwable;

class DeductProductQuantity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
    $order=$event->order;

    try{
    foreach($order->products as $product){
        $product->decrement('quantity',$product->order_item->quantity);
    }
}catch (Throwable $e)
{

}
        // //لما اعمل اوردر لمنتج في السلة بعد ما اعمل الاوردر المنتج يتشال من السلة
        // foreach(cart::get() as $item){
        //     product::where('id','=',$item->product_id)->update([
        //     //DB::row=>بنكتبها عشان يتعامل مع الجملة زي ما هيا كيخلهاش استرنج
        //     'quantity'=>DB::raw("quantity-{$item->product_id}"),
        //     ]);

        // }
    }
}

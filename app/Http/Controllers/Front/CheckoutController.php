<?php

namespace App\Http\Controllers\Front;

use Throwable;
use App\Models\User;
use App\Models\order;
use App\Models\order_item;
use App\Events\OrderCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use App\Exceptions\InvalidOrderException;
use App\Exceptions\InvalidOrderExcertion;
use App\Repositories\Cart\CartRepository;
use App\Notifications\OrderCreatedNotification;

class CheckoutController extends Controller
{
    public function create(CartRepository $cart){


        if($cart->get()->count()==0){
            throw new InvalidOrderExcertion('Your cart is empty');
            }
        return view('front.checkout',[
        'cart'=>$cart,
        'countries'=> Countries::getNames(),

        ]);


    }
    public function store(request $request,CartRepository $cart)
    {
        $request->validate([
            'addr.billing.first_name' => ['required', 'string', 'max:255'],
            'addr.billing.last_name' => ['required', 'string', 'max:255'],
            'addr.billing.email' => ['required', 'string', 'max:255'],
            'addr.billing.phone_number' => ['required', 'string', 'max:255'],
            'addr.billing.city' => ['required', 'string', 'max:255'],
        ]);



        $items=$cart->get()->groupBy('product.store_id')->all();


        DB::beginTransaction();
        try{
        foreach($items as $store_id=>$cart_items)
        {

        $order=order::create([
            'store_id'=>$store_id,
            'user_id'=>Auth::id(),
        'payment_method'=>'cod',
        ]
        );




        //هضيف ايتيم تبع الاوردر وهجيب الايتيم من السلة
        foreach($cart_items as $item){

           order_item::create([
            'order_id'=>$order->id,
            'product_id'=>$item->product_id,
            'product_name'=>$item->product->name,
            'price'=>$item->product->price,
            'quantity'=>$item->quantity
            ]);



        }
        foreach($request->post('addr') as $type=>$address){
        $address['type']=$type;
        $order->addresses()->create($address);
        }
    }
  //  $cart->empty();//بعد ما اعمل الاوردر امسح السلة
        DB::commit();//عشان ميمسحش البيانات من الداتابيز

        //event('order.created',$order,Auth::user());//روح عرفها في provider Event


        event(new OrderCreated($order));


    }catch(Throwable $e){
        DB::rollBack();
        throw $e;
    }

   // return redirect()->route('home');
    }
}

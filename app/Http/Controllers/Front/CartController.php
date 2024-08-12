<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\product;
use app\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{

protected $cart;
public function __construct(CartRepository $cart)
{
    $this->cart =$cart ;
}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       // $repository=new CartModelRepository();
        return view('front.cart',['cart'=>$this->cart]);
    }

    //احنا استخدمنا الجملة دي كتير اللي بنقرا منها الداتا بيز
    // $repository=new CartModelRepository();
    //فا هنروح علي appserviceprovider
    //سمناها cart
    //لما نعوز نغير طريقة قراءة الداتا هنغيرها

    /**
     * Show the form for creating a new resource.
     */
     //     مستخدمناش كرييت عشان مفيش فورم



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,CartRepository $cart)
    {
    $request->validate([
    'product_id'=>['required','int','exists:products,id'],
    'quantity'=>['nullable','int','min:1']

    ]);
        $product=product::findOrFail($request->post('product_id'));
       // $repository=new CartModelRepository();
        $cart->add($product,$request->post('quantity'));

        return redirect()->route('cart.index')->with('success','product added to cart');
    }

    /**
     * Display the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update($id,Request $request)
    {
        $request->validate([
           // 'product_id'=>['required','int','exists:products,id'],
            'quantity'=>['required','int','min:1']

            ]);
          //  $product=product::findOrFail($request->post('product_id'));
              //  $repository=new CartModelRepository();
        $this->cart->update($id,$request->post('quantity'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //$repository=new CartModelRepository();
        $this->cart->delete($id);

        return['message'=>'item deleted!'];
    }
}

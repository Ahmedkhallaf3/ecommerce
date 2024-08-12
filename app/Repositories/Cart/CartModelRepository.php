<?php

namespace App\Repositories\Cart;

use Carbon\Carbon;
use App\Models\cart;
use App\Models\product;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CartModelRepository implements CartRepository
{
    protected $items;
    public function __construct()
    {
        //collect=>بتحول الاراي لكوليكشن
        $this->items = collect([]);
    }

    public function get(): Collection
    {
        //عملنا كدا عشان نعمل جملة استعلام واحدة مش كل مرة تتكرر
        if (!$this->items->count()) {
            $this->items = cart::with('product')->get();
        }

        return $this->items;
    }
    public function add(product $product, $quantity = 1)
    {
        $items = cart::where('product_id', '=', $product->id)
            ->first();
        if (!$items) {
            $cart = cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,

            ]);

            $this->get()->push($cart);
            // dd($cart);
            return $cart;
        }
        return $items->increment('quantity', $quantity); //ده عشان لو جينا نضيف نفس المنتج يزود الكمية فقط
    }
    public function update($id, $quantity)
    {
        cart::where('id', '=', $id)
            ->update([
                'quantity' => $quantity,
            ]);
    }
    public function delete($id)
    {
        cart::with('product')->where('id', '=', $id)
            ->delete();
    }
    public function empty()
    {
        return cart::query()->delete();
    }
    public function total(): float
    {
        // return (float) cart::
        // join('products', 'products.id', '=', 'carts.product_id')
        //     ->selectRaw('SUM(products.price*carts.quantity) as total')
        //     ->value('total');

            return $this->get()->sum(function ($items) {
                return $items->quantity * $items->product->price;
            });


        
    }
}

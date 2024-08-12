<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Observers\CartObserver;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class cart extends Model
{
    use HasFactory;
    public $incrementing=false;

    protected $fillable=['cookie_id','user_id','product_id','quantity','options'];

    //Events(observers)
    //creating جهز حاجة قبل ما تعمل كرييت
    //created اعمل حاجة بعد ما تعمل كرييت

    protected static function booted()
    {

    static::addGlobalScope('cookie_id',function(Builder $builder){
    //هنا استدعينا الفانكشن بالموديل عشان مينفعش نستخدم=> this في static
        $builder->where('cookie_id', '=', cart::getCookieId());
    });


    static::observe(CartObserver::class);
    //دي طريقة تانية
        // static::creating(function(cart $cart){
        //     $cart->id=Str::uuid();
        // });


    }

    public static function getCookieId()
    {
        $cookie_id = Cookie::get('cart_id');
        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            //السطر اللي تحت هنخزن الكوكي
            $cookie_id = Cookie::queue('cart_id', $cookie_id, 30 * 24 * 60);
        }
        return $cookie_id;
    }


    public function user(){
        return $this->belongsTo(User::class)->withDefault(['name'=>'Anonymous']);
}
public function product(){
    return $this->belongsTo(product::class);
}
}

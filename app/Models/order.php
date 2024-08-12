<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
//use App\Models\order;
use App\Models\Store;
use App\Models\product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class order extends Model
{
    use HasFactory;

    protected $fillable = ['store_id', 'user_id','payment_method', 'status', 'status_payment'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,)->withDefault([
            'name' => 'Guest Customer'
        ]);
    }



    public function products()
    {
        return $this->belongsToMany(product::class, 'order_items', 'order_id', 'product_id', 'id', 'id')
        ->using(order_item::class)
        ->as('order_item')
            //whithpivot=> بنعملها في علاقة المني تو مني عشان نرجع بقت العناصر اللي في الجدول
            ->withPivot([
                'product_name', 'price', 'quantity', 'options'
            ]);
    }
    public function addresses()
    {
        return $this->hasMany(order_address::class);
    }
    public function billingAddress(){
    return $this->hasOne(order_address::class,'order_id','id')->where('type','=','billing');
    }
    public function shippingAddress(){
    return $this->hasOne(order_address::class,'order_id','id')->where('type','=','shipping');
    }
    public function items()
    {
        return $this->hasMany(order_item::class, 'order_id');
    }


    protected static function booted()
    {
        static::creating(function (order $order) {
        
            //20240001,20240002
            $order->number = order::getNextOrderNumber();
        });
    }
    // بنجيب هنا رقم الاوردر اللي عليه الدور
    public static function getNextOrderNumber()
    {
        $year = Carbon::now()->year();
        $number = order::whereyear('created_at', $year)->max('number');

        if ($number) {
            return $number + 1;
        }
        return $year . '0001';
    }
}

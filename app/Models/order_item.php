<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
//استدعينا pivot بدل model
//عشان عندي في الجدول id,forenid
//وهو بيعتبر forenid =>primarykey مثل id
class order_item extends Pivot
{
    use HasFactory;
    protected $table='order_items';//عملنا كدا عشان سمينا جدول الوسيط بتاع الميني تو ميني تسمية غلط
    public $incrementing=true;
    public $timestamps=false;


    public function product(){
    return $this->belongsTo(product::class)->withDefault(['name'=>$this->product_name]);
    }
    public function order(){
    return $this->belongsTo(order::class);
    }
}

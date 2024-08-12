<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Intl\Countries;

class order_address extends Model
{
    use HasFactory;

    public $timestamps=false;

    protected$fillable = [
        'order_id', 'type', 'first_name', 'last_name', 'email', 'phone_number',
        'street_address', 'city', 'postal_code', 'state', 'country',
    ];

//accessor=>بنضيف اسم حقل مش موجود في الداتا
    public function getNameAttribute()
    {
        return $this->first_name.''.$this->last_name;
    }
//accessor=>بنضيف اسم حقل مش موجود في الداتا
    public function getCountryNameAttribute()
    {
        return Countries::getName($this->country);
    }
}

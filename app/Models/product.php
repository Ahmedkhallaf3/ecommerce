<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class product extends Model
{
    use HasFactory,Notifiable;
    protected $fillable = [
        'name', 'slug', 'description', 'image', 'category_id', 'store_id',
        'price', 'compare_price', 'status',
    ];
    protected $hidden = [
        'image',
        'created_at', 'updated_at', 'deleted_at',
    ];
    protected $appends = [
        'image_url',
    ];

    //protected $fillable=['name','slug','category_id','store_id','price','compare_price','image','status','description'];
    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function store(){
        return $this->belongsTo(Store::class,'store_id','id');
    }

    public function tags(){
        return $this->belongsToMany(
            Tag::class,
            'product_tag',
            'product_id',
            'tag_id',
            'id',
            'id'
        );
        }



    //global scope
    //code الشخص المسجل يشوف المنتجات الخاصة به فقط وليس كل المنتجات
    protected static function booted(){
        static::creating(function(Product $product) {
            $product->slug = Str::slug($product->name);

        });
        Static::addGlobalScope('store',function(Builder $builder){

            $user=Auth::user();

            //الادمن ملوش ستور اي دي فالازم الادمن يشوف كل المنتجات code
            if($user&&$user->store_id){

            $builder->where('store_id','=',$user->store_id);



        //////////////
            // static::creating(function(Product $product) {
            //     $product->slug = Str::slug($product->name);
            // });
            }
        });

    }
//local scope
    public function scopeActive(Builder $builder){
        $builder->where('status','=','active');
    }

    //هنعمل فحص للصور
    public function getImageUrlattribute(){
        if(!$this->image){
            return 'https://www.incathlab.com/images/products/default_product.png';
        }
        if(Str::startsWith($this->image,['https://','http://'])){
        return $this->image;
        }
        return asset('storage/'.$this->image);
    }
    public function getSalePerecentAttribute(){
        if(!$this->compare_price){
        return 0;
        }
        return round(100 - (100 * $this->price / $this->compare_price));
    }
    public function scopeFilter(Builder $builder, $filters)
    {
        $options = array_merge([
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null,
            'status' => 'active',
        ], $filters);

        $builder->when($options['status'], function ($query, $status) {
            return $query->where('status', $status);
        });

        $builder->when($options['store_id'], function($builder, $value) {
            $builder->where('store_id', $value);
        });
        $builder->when($options['category_id'], function($builder, $value) {
            $builder->where('category_id', $value);
        });
        $builder->when($options['tag_id'], function($builder, $value) {

            $builder->whereExists(function($query) use ($value) {
                $query->select(1)
                    ->from('product_tag')
                    ->whereRaw('product_id = products.id')
                    ->where('tag_id', $value);
                    
            });
            // $builder->whereRaw('id IN (SELECT product_id FROM product_tag WHERE tag_id = ?)', [$value]);
            // $builder->whereRaw('EXISTS (SELECT 1 FROM product_tag WHERE tag_id = ? AND product_id = products.id)', [$value]);

            // $builder->whereHas('tags', function($builder) use ($value) {
            //     $builder->where('id', $value);
            // });
        });
    }
    }

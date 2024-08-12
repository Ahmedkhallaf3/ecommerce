<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpParser\Node\Stmt\Return_;

class Category extends Model
{
    use HasFactory // SoftDeletes
    ;
    protected $fillable=['name','parent_id','slug','image','status','description'];

public function parent(){
    return $this->belongsTo(Category::class,'parent_id','id')->withDefault(['name'=>'-']);

}
public function childeren(){
    return $this->hasMany(Category::class,'parent_id','id');
}

    public function products(){
        return $this->hasMany(Product::class,'category_id','id');
    }




//code search
    public static function ScopeFilter(Builder $builder,$filters){
        if($filters['name']?? false){
            $builder->where('name','LIKE',"%{$filters['name']}%");
        }
        if($filters['status']?? false){
            $builder->where('status','=',$filters['status']);
        }
    }
//end
    public static function rule(){
    return
        [
            'name'=>['required','string','min:3','max:255','unique:categories,name',
            function($attribute,$value,$fails){
                if(strtolower($value)=='laravel'){
                $fails('name is forbidden');
                }
            }

            //new Filter(), موجودة في ال rule
            ],
            'parent_id'=>'nullable|int|exists:categories,id',
            'image'=>'image|size:1048576',
            'status'=>'in:active,archived',


            ];

    }
}

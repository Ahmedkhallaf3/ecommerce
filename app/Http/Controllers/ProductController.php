<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Jobs\ImportProducts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view-any', Product::class);
        $products=product::with(['category','store'])->paginate();
        return view('dashboard.product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Product::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Product::class);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('view', $product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product=Product::findorfail($id);
        $this->authorize('update', $product);
        //implode بتحول الاري ل سترنج
        $tags=implode(',',$product->tags()->pluck('name')->Toarray());//يعرض اسم التاج فقط
        return view('dashboard.product.edit',compact('product','tags'));

    }

    /**
     * Update the specified resource in storage.
     */

        public function update(Request $request, Product $product)
        {
            $this->authorize('update', $product);

            $product->update($request->except('tags'));
            $tags =  explode(',' , $request->post('tags')); //turn string to array
            $tag_ids=[];
            $saved_tag=Tag::all();
            foreach ($tags as $t_name){
                $slug = Str::slug($t_name);
              $tag =  $saved_tag->where('slug' , $slug)->first();
              if(!$tag){
             $tag= Tag::create([
              'name'=>$t_name,
              'slug'=>$slug
              ]);
              }

                $tag_ids[] = $tag->id; //get ids of tags inserted
            }
            $product->tags()->sync($tag_ids); //sync searches if there are matches records if found dousnt delete the matched record if it has record not found in table will insertt it and if it doesnt have a record which exists in table delete it from table
            return redirect()->route('product.index')->with('success', 'product updated!');
        }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('delete', $product);
    }

    
}

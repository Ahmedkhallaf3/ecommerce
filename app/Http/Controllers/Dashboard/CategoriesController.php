<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Support\Str;
use function Ramsey\Uuid\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Gate::allows('categories.view')) {
            abort(403);
        }

        $categories=Category::with('parent')->withCount('products as products_number')
        ->filter($request->query())->orderBy('name')->paginate(7);
        return view('dashboard.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        if (Gate::denies('categories.create')) {
            abort(403);
        }

    $parents=Category::all();
    $category=new Category();
        return view('dashboard.category.create',compact('parents','category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('categories.create');

        //عملنا الفالديشن في الموديل واستدعناها هنا
        $request->validate(Category::rule()
        //,[
        //هنا لو عايز تعدل علي رسايل الايرور
            //'name.required' => 'fuck!'

      //  ]
        );

        //merge بيضيف تاتا يدوية مش موجودة في الفورم
        $request->merge([
        'slug'=> Str::slug($request->post('name'))
        ]);

                $data['image']=$this->uploadimage($request);


                $data=$request->except('image');

        $category=Category::create($data);

        return redirect()->route('category.index',)->with('success','category created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        if (Gate::denies('categories.view')) {
            abort(403);
        }

        return view('dashboard.category.show',['category'=>$category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        Gate::authorize('categories.update');

    $category=Category::findOrFail($id);
    $parents=Category::where('id','<>',$id)->whereNull('parent_id')->Orwhere('parent_id','<>',$id)->get();
        return view('dashboard.category.edit',compact('category','parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        Gate::authorize('categories.update');


    //عملنا الفالديشن في الموديل واستدعناها هنا
    $request->validate(Category::rule());
        $category=Category::findOrFail($id);
        $old_image=$category->image;
        $data=$request->except('image');
        $new_image = $this->uploadimage($request);
        if ($new_image) {
            $data['image'] = $new_image;
        }
        $category->update($data);
        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }
        return redirect()->route('category.index')->with('success','category updated ');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        Gate::authorize('categories.delete');

        $category=Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index')->with('success','category deleted');

    }


    protected function uploadimage(Request $request){
        if(!$request->hasFile('image')){
            return;
        }
        {
            $file=$request->file('image');
            $path=$file->store('uploads',['disk'=>'public']);

        }
            return $path;

    }
    public function trash(){
        $categories=Category::onlyTrashed()->paginate();
        return view('dashboard.category.trash',compact('categories'));
    }
    public function restore(Request $request,$id){
        $category=Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('category.trash')->with('success','category restored!');
    }
    public function forceDelete($id){
        $category=Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        if($category->image){
            Storage::disk('public')->delete($category->image);

        }
        return redirect()->route('category.trash')->with('success','category deleted for ever!');
    }
}


<div class="form-group">

    <x-form.input label="Category Name" class="form-control-lg" role="input" name="name" :value="$product->name"/>
</div>

<div class="form-group">
    <label for="">Category </label>
    <select name="category_id" class="form-control form-select">
        <option value=""> category</option>
        @foreach (App\models\Category::all() as $category)
            <option value="{{ $category->id }}"@selected(old('category_id',$product->category_id) == $category->id) >{{ $category->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
<label for="">description</label>
    <x-form.textarea name="description"  :value="$product->description" />
</div>
<div class="form-group">
    <label for="">Image</label>
    <x-form.input type="file" name="image" />
    @if ($product->image)
    <img src="{{ asset('storage/'.$product->image) }}" alt="" height="50px">
    @endif
</div>
<div class="form-group">
    <label for="">status</label>
    <div>
    <x-form.radio name="status" :checked="$category->status" :options="['active'=>'Active','archived'=>'Archived']"/>
</div>

<div class="form-group">

    <x-form.input label="price" class="form-control-lg" role="input" name="price" :value="$product->price"/>
</div>
<div class="form-group">

    <x-form.input label="compare price" class="form-control-lg" role="input" name="compare price" :value="$product->compare_price"/>
</div>
<div class="form-group">

    <x-form.input label="Tags"  name="tags" :value="$tags"/>
</div>


<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'save' }}</button>
</div>


@push('styles')
<link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
@endpush
@push('scripts')
<script src="https://unpkg.com/@yaireo/tagify"></script>
<script src="https://unpkg.com/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<script>
var inputElm = document.querySelector('[name=tags]'),
    tagify = new Tagify (inputElm);
</script>
@endpush


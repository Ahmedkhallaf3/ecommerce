
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group">
    <label for="">Category name</label>
    <x-form.input name="name" type="text" :value="$category->name" />
    {{-- <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$category->name) }}">
    @error('name')
    <div class="text-danger">{{ $message }}</div>
@enderror --}}
</div>

<div class="form-group">
    <label for="">Category parent</label>
    <select name="parent_id" class="form-control form-select">
        <option value="">primary category</option>
        @foreach ($parents as $parent)
            <option value="{{ $parent->id }}"@selected(old('parent_id')==$parent->id)>{{ $parent->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="">Description</label>
    <x-form.textarea name="description"  :value="$category->description"/>

</div>

<div class="form-group">
    <x-form.label id="image">image</x-form.label>
    <x-form.input type="file" name="image" />
    @if($category->image)
    <td><img src="{{ asset('storage/'.$category->image) }}" alt="" height="50"></td>

    @endif

</div>

<div class="form-group">
    <label for="">status</label>
    <div>
    <x-form.radio name="status" :checked="$category->status" :options="['active'=>'Active','archived'=>'Archived']"  />
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>

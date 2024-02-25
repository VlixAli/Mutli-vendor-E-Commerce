@if($errors->any())
    <div class="alert alert-danger">
        <h3>Error Occurred!</h3>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group">
    <x-form.input label="Product Name" name="name" :value="$product->name" />
</div>
<div class="form-group">
    <label for="">Category</label>
    <select name="category_id" class="form-control form-select">
        <option value="">Primary Category</option>
        @foreach($categories as $category)
            <option
                value="{{ $category->id }}" @selected(old('category_id',$product->category_id) == $category->id)>{{ $category->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <x-form.textarea label="Description" name="description" :value="old('description', $category->description)" />
</div>
<div class="form-group">
    <x-form.label id="image">Image</x-form.label>
    <x-form.input type="file" name="image" accept="image/*" />
    @if($category->image)
        <img src="{{asset('storage/'.$category->image)}}" alt="" height="50">
    @endif
</div>

<div class="form-group">
    <x-form.input label="Price" name="price" :value="$product->price" />
</div>

<div class="form-group">
    <x-form.input label="Compare Price" name="compare_price" :value="$product->compare_price" />
</div>

<div class="form-group">
    <x-form.input label="Tags" name="tags" :value="$tags"/>
</div>

<div class="form-group">
    <label for="">Status</label>
    <div>
        <x-form.radio name="status" :checked="$category->status" :options="['active' => 'Active' , 'draft' => 'Draft' ,'archived' => 'Archived']" />
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>

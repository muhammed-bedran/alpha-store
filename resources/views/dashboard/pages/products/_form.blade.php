<div class="card-body">
    <div class="form-group">
   
        <x-form.input id="name" name="name"  type="text" placeholder="Enter Product Name" label="Enter Product Name" :value="$product->name" />
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Description</label>
        <textarea name="description" class="form-control" id="" cols="30"
            rows="10">{{ old('description', $product->description) }}</textarea>
        @if ($errors->has('description'))
            <p class="text-danger">{{ $errors->first('description') }}</p>
        @endif
    </div>


    <x-form.select
    label="Select Product Status"
    name="status"
    :options="[
        'active' => 'Active',
        'inactive' => 'Inactive'
    ]"
       :selected="$product->status ?? 'active'"
    />
    <x-form.select
    label="Select Product Store"
    name="store_id"
    :options="$stores"
       :selected="$product->store_id ?? ''"
    />
    <x-form.select
    label="Select Product Category"
    name="category_id"
    :options="$categories"
       :selected="$product->category_id ?? ''"
    />
    <div class="form-group">
    
        <x-form.input id="price" name="price" type="number" step="0.01" min="0" placeholder="Enter Product Price" label="Enter Product Price"
            :value="$product->price" onkeydown="return !['-','e','E','+'].includes(event.key)" oninput="if (this.value !== '' && Number(this.value) < 0) this.value = 0;" />
    </div>

</div>

@push('scripts')
<script>
    document.getElementById('price')?.addEventListener('input', function () {
        if (this.value !== '' && Number(this.value) < 0) {
            this.value = 0;
        }
    });
</script>
@endpush
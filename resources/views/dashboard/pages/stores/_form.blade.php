<div class="card-body">
    <div class="form-group">
        {{-- <label for="exampleInputEmail1">Category Name</label>
        <input type="text" name="name" class="form-control" placeholder="Category Name"
            value="{{ old('name', $category->name) }}">
        {{-- @if ($errors->has('name'))
        <p class="text-danger">{{ $errors->first('name') }}</p>
        @endif 
        @error('name')
            <p class="text-danger">{{ $message }}</p>
        @enderror --}}
        <x-form.input id="name" name="name"  type="text" placeholder="Enter Store Name" label="Enter Store Name" :value="$store->name" />
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Description</label>
        <textarea name="description" class="form-control" id="" cols="30"
            rows="10">{{ old('description', $store->description) }}</textarea>
        @if ($errors->has('description'))
            <p class="text-danger">{{ $errors->first('description') }}</p>
        @endif
    </div>


    <x-form.select
    label="Select Store Status"
    name="status"
    :options="[
        'active' => 'Active',
        'inactive' => 'Inactive'
    ]"
       :selected="$store->status ?? 'active'"
    />

</div>
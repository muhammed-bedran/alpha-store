<div class="form-group">
    <label for="name">Store Name</label>
    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
</div>

<div class="form-group">
    <label for="description">Store Description</label>
    <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
</div>
<x-form.select label="Select Store Status" name="status" :options="[
        'active' => 'Active',
        'inactive' => 'Inactive'
    ]"
    :selected="$store->status ?? 'active'" />
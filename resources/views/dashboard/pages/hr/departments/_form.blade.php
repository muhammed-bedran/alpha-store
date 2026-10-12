<div class="card-body">
    <div class="form-group">
        <x-form.input id="name" name="name" type="text" placeholder="اسم القسم" label="اسم القسم" :value="$department->name" />
    </div>
    <div class="form-group">
        <label for="description">الوصف</label>
        <textarea name="description" id="description" class="form-control" rows="5">{{ old('description', $department->description) }}</textarea>
        @error('description')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <x-form.select
        label="الحالة"
        name="status"
        :options="['active' => 'نشط', 'inactive' => 'غير نشط']"
        :selected="$department->status ?? 'active'"
    />
</div>

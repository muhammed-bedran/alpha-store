<div class="card-body">
    <div class="form-group">
        <x-form.input id="name" name="name" type="text" placeholder="اسم الموظف" label="الاسم" :value="$employee->name" />
    </div>
    <div class="form-group">
        <x-form.input id="email" name="email" type="email" placeholder="email@example.com" label="البريد الإلكتروني" :value="$employee->email" />
    </div>
    <div class="form-group">
        <x-form.input id="phone" name="phone" type="text" placeholder="رقم الهاتف" label="الهاتف" :value="$employee->phone" />
    </div>
    <div class="form-group">
        <x-form.input id="national_id" name="national_id" type="text" placeholder="الرقم الوطني" label="الرقم الوطني" :value="$employee->national_id" />
    </div>
    <div class="form-group">
        <x-form.select
            label="القسم"
            name="department_id"
            :options="['' => 'بدون قسم'] + $departments->toArray()"
            :selected="$employee->department_id"
        />
    </div>
    <div class="form-group">
        <x-form.input id="job_title" name="job_title" type="text" placeholder="المسمى الوظيفي" label="المسمى الوظيفي" :value="$employee->job_title" />
    </div>
    <div class="form-group">
        <x-form.input id="hire_date" name="hire_date" type="date" label="تاريخ التعيين" :value="old('hire_date', optional($employee->hire_date)->format('Y-m-d'))" />
    </div>
    <div class="form-group">
        <x-form.input id="salary" name="salary" type="number" step="0.01" min="0" placeholder="0" label="الراتب" :value="$employee->salary" />
    </div>
    <div class="form-group">
        <x-form.select
            label="الحالة"
            name="status"
            :options="[
                'active' => 'نشط',
                'on_leave' => 'في إجازة',
                'inactive' => 'غير نشط',
                'terminated' => 'منتهي الخدمة',
            ]"
            :selected="$employee->status ?? 'active'"
        />
    </div>
    <div class="form-group">
        <x-form.input id="address" name="address" type="text" placeholder="العنوان" label="العنوان" :value="$employee->address" />
    </div>
    <div class="form-group">
        <label for="notes">ملاحظات</label>
        <textarea name="notes" id="notes" class="form-control" rows="4">{{ old('notes', $employee->notes) }}</textarea>
    </div>
</div>

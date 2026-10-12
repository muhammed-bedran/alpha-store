<div class="card-body">
    <div class="form-group">
        <x-form.select
            label="الموظف"
            name="employee_id"
            :options="$employees->toArray()"
            :selected="$bonus->employee_id"
        />
    </div>
    <div class="form-group">
        <x-form.input id="title" name="title" type="text" placeholder="مثال: مكافأة إنجاز" label="العنوان" :value="$bonus->title" />
    </div>
    <div class="form-group">
        <x-form.select
            label="النوع"
            name="type"
            :options="[
                'performance' => 'أداء',
                'overtime' => 'عمل إضافي',
                'holiday' => 'مناسبة / عيد',
                'commission' => 'عمولة',
                'other' => 'أخرى',
            ]"
            :selected="$bonus->type ?? 'performance'"
        />
    </div>
    <div class="form-group">
        <x-form.input id="amount" name="amount" type="number" step="0.01" min="0" placeholder="0" label="المبلغ" :value="$bonus->amount" />
    </div>
    <div class="form-group">
        <x-form.input id="date" name="date" type="date" label="التاريخ" :value="optional($bonus->date)->format('Y-m-d')" />
    </div>
    <div class="form-group">
        <label for="notes">ملاحظات</label>
        <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', $bonus->notes) }}</textarea>
    </div>
</div>

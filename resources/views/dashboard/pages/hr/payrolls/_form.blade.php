<div class="card-body">
    <p class="text-muted">يُحسب الراتب تلقائياً: الأساسي + مكافآت الشهر − خصومات الشهر.</p>
    <div class="form-group">
        <x-form.select
            label="الموظف"
            name="employee_id"
            :options="$employees->toArray()"
            :selected="$payroll->employee_id"
        />
    </div>
    <div class="form-group">
        <x-form.input
            id="period"
            name="period"
            type="month"
            label="الشهر"
            :value="old('period', $payroll->exists ? $payroll->period() : now()->format('Y-m'))"
        />
    </div>
    <div class="form-group">
        <label for="notes">ملاحظات</label>
        <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', $payroll->notes) }}</textarea>
    </div>
</div>

<div class="card-body">
    <div class="form-group">
        <x-form.select
            label="الموظف"
            name="employee_id"
            :options="$employees->toArray()"
            :selected="$deduction->employee_id"
        />
    </div>
    <div class="form-group">
        <x-form.input id="title" name="title" type="text" placeholder="مثال: خصم تأخير" label="العنوان" :value="$deduction->title" />
    </div>
    <div class="form-group">
        <x-form.select
            label="النوع"
            name="type"
            :options="[
                'late' => 'تأخير',
                'absence' => 'غياب',
                'loan' => 'سلفة / قرض',
                'penalty' => 'جزاء',
                'tax' => 'ضريبة / تأمين',
                'other' => 'أخرى',
            ]"
            :selected="$deduction->type ?? 'late'"
        />
    </div>
    <div class="form-group">
        <x-form.input id="amount" name="amount" type="number" step="0.01" min="0" placeholder="0" label="المبلغ" :value="$deduction->amount" />
    </div>
    <div class="form-group">
        <x-form.input id="date" name="date" type="date" label="التاريخ" :value="optional($deduction->date)->format('Y-m-d')" />
    </div>
    <div class="form-group">
        <label for="notes">ملاحظات</label>
        <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', $deduction->notes) }}</textarea>
    </div>
</div>

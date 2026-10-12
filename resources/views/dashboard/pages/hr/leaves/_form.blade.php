<div class="card-body">
    <div class="form-group">
        <x-form.select
            label="الموظف"
            name="employee_id"
            :options="$employees->toArray()"
            :selected="$leave->employee_id"
        />
    </div>
    <div class="form-group">
        <x-form.select
            label="نوع الإجازة"
            name="type"
            :options="[
                'annual' => 'سنوية',
                'sick' => 'مرضية',
                'unpaid' => 'بدون راتب',
                'emergency' => 'طارئة',
            ]"
            :selected="$leave->type ?? 'annual'"
        />
    </div>
    <div class="form-group">
        <x-form.input id="start_date" name="start_date" type="date" label="من تاريخ" :value="optional($leave->start_date)->format('Y-m-d')" />
    </div>
    <div class="form-group">
        <x-form.input id="end_date" name="end_date" type="date" label="إلى تاريخ" :value="optional($leave->end_date)->format('Y-m-d')" />
    </div>
    <div class="form-group">
        <label for="reason">السبب</label>
        <textarea name="reason" id="reason" class="form-control" rows="4">{{ old('reason', $leave->reason) }}</textarea>
    </div>
</div>

@push('scripts')
<script>
    (function () {
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');

        if (!startDate || !endDate) {
            return;
        }

        function syncEndDateMin() {
            if (!startDate.value) {
                endDate.removeAttribute('min');
                return;
            }

            endDate.min = startDate.value;

            if (endDate.value && endDate.value < startDate.value) {
                endDate.value = '';
            }
        }

        startDate.addEventListener('change', syncEndDateMin);
        syncEndDateMin();
    })();
</script>
@endpush

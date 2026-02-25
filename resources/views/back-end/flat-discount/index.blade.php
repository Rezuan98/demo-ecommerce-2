@extends('back-end.master')

@section('admin-title', 'Flat Discount')

@section('admin-content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-2">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="row justify-content-center mt-3">
        <div class="col-lg-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Flat Discount Settings</h3>
                </div>

                <form action="{{ route('flat-discount.update') }}" method="POST">
                    @csrf
                    <div class="card-body">

                        <p class="text-muted mb-3">
                            When flat discount is <strong>active</strong>, it overrides all individual product discounts site-wide.
                        </p>

                        {{-- Active toggle --}}
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox"
                                       class="custom-control-input"
                                       id="flat_discount_active"
                                       name="flat_discount_active"
                                       value="1"
                                       {{ optional($setting)->flat_discount_active ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold" for="flat_discount_active">
                                    Enable Flat Discount
                                </label>
                            </div>
                        </div>

                        {{-- Discount type --}}
                        <div class="form-group">
                            <label for="flat_discount_type">Discount Type</label>
                            <select name="flat_discount_type" id="flat_discount_type" class="form-control">
                                <option value="percentage" {{ optional($setting)->flat_discount_type === 'percentage' || !optional($setting)->flat_discount_type ? 'selected' : '' }}>
                                    Percentage (%)
                                </option>
                                <option value="fixed" {{ optional($setting)->flat_discount_type === 'fixed' ? 'selected' : '' }}>
                                    Fixed Amount (Tk)
                                </option>
                            </select>
                        </div>

                        {{-- Discount amount --}}
                        <div class="form-group">
                            <label for="flat_discount_amount">Discount Amount</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="typeLabel">
                                        {{ optional($setting)->flat_discount_type === 'fixed' ? 'Tk' : '%' }}
                                    </span>
                                </div>
                                <input type="number"
                                       name="flat_discount_amount"
                                       id="flat_discount_amount"
                                       class="form-control"
                                       step="0.01"
                                       min="0"
                                       value="{{ optional($setting)->flat_discount_amount ?? 0 }}"
                                       placeholder="e.g. 10">
                            </div>
                            <small class="form-text text-muted" id="amountHint">
                                Enter a percentage value (0–100).
                            </small>
                            @error('flat_discount_amount')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Live preview --}}
                        <div class="alert alert-info" id="previewBox" style="display:none;">
                            <strong>Preview:</strong>
                            A product priced at <strong>Tk1000</strong> will cost
                            <strong id="previewPrice">–</strong> after flat discount.
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('admin-scripts')
<script>
    const typeSelect  = document.getElementById('flat_discount_type');
    const amountInput = document.getElementById('flat_discount_amount');
    const typeLabel   = document.getElementById('typeLabel');
    const amountHint  = document.getElementById('amountHint');
    const previewBox  = document.getElementById('previewBox');
    const previewPrice = document.getElementById('previewPrice');

    function updateUI() {
        const type   = typeSelect.value;
        const amount = parseFloat(amountInput.value) || 0;

        if (type === 'fixed') {
            typeLabel.textContent  = 'Tk';
            amountInput.max        = '';
            amountHint.textContent = 'Enter a fixed amount in Taka.';
        } else {
            typeLabel.textContent  = '%';
            amountInput.max        = '100';
            amountHint.textContent = 'Enter a percentage value (0–100).';
        }

        if (amount > 0) {
            previewBox.style.display = 'block';
            const base = 1000;
            const final = type === 'fixed'
                ? Math.max(0, base - amount)
                : Math.max(0, base - (base * amount / 100));
            previewPrice.textContent = 'Tk' + final.toFixed(0);
        } else {
            previewBox.style.display = 'none';
        }
    }

    typeSelect.addEventListener('change', updateUI);
    amountInput.addEventListener('input', updateUI);
    updateUI();
</script>
@endpush
